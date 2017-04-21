// 2016-06-03
define(['df', 'jquery'], function(df, $) {return (
	/**
	 * @param {Object} config
	 * @param {String} config.clientId
	 * @param {String} config.merchantId
	 * @param {String} config.redirect
	 * @param {Boolean} config.sandbox
	 * @param {String} config.selector
	 * @param {String} config.type
	 * @param {Object} config.widget
	 * @param {String} config.widget.size
	 * @param {?String} config.widget.style
	 * @param {String} config.widget.type
	 * @param {HTMLAnchorElement} element
	 * @returns void
	 */
	function(config, element) {
		// 2016-06-04
		// https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/javascript_sdk_reference.html#setClientId
		// «Sets the client identifier that will be used to request authorization.
		// You must call this function before calling authorize.»
		window.onAmazonLoginReady = window.onAmazonLoginReady || function() {
			amazon.Login.setClientId(config.clientId);
		};
		var login = function() {
			// 2016-06-04
			// https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/javascript_sdk_reference.html#authorize
			// 2016-11-27
			// http://login.amazon.com/website
			amazon.Login.authorize({
				/**
				 * 2016-06-03
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 *
				 * The popup parameter determines whether the buyer
				 * will be presented with a pop-up window to authenticate,
				 * or if the buyer will instead be redirected
				 * to an Amazon Payments page to authenticate.
				 *
				 * Use one of the following popup parameters:
				 *
				 * true — An Amazon Payments authentication screen is presented
				 * in a pop-up dialog where buyers can authenticate
				 * without ever leaving your website.
				 * This value is recommended for desktops
				 * where the button widget is presented on a secure page.
				 * Please be aware that this option requires
				 * the button to reside on an HTTPS page with a valid SSL certificate.
				 *
				 * false — The buyer is redirected to an Amazon Payments page
				 * within the same browser window.
				 * This value is recommended for smartphone optimized devices
				 * or if you are rendering the button widget on a non-secure page.
				 * Please be aware that the redirect URL must use HTTPS protocol
				 * and have a valid SSL certificate.
				 */
				popup: 'true'
				/**
				 * 2016-06-03
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/customer_profile.html
				 */
				,scope: [
					/**
					 * 2016-06-03
					 * «Gives access to the full shipping address
					 * via the GetOrderReferenceDetails API call
					 * as soon as an address has been selected in the address widget.»
					 * https://payments.amazon.com/documentation/lpwa/201953980
					 *
					 * 2016-06-04
					 * Документация к GetOrderReferenceDetails:
					 * https://payments.amazon.com/documentation/apireference/201751970
					 */
					'payments:shipping_address'
					/**
					 * 2016-06-03
					 * https://payments.amazon.com/documentation/lpwa/201953980
					 * «Required to show the Amazon Payments widgets
					 * (address and wallet widget) on your page.
					 * If used without the parameter below,
					 * it gives access to the full shipping address
					 * after ConfirmOrderReference call.»
					 */
					,'payments:widget'
					/**
					 * 2016-06-03
					 * «Gives access to the full user profile
					 * (username, email address, and userID) after login.»
					 * https://payments.amazon.com/documentation/lpwa/201953980
					 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/customer_profile.html
					 *
					 * Например:
					 *	{
					 *		"user_id": "amzn1.account.AGM6GZJB6GO42REKZDL33HG7GEJA",
					 *		"name": "Jack London",
					 *		"email": "test-customer@mage2.pro"
					 *	}
					 */
					,'profile'
					/**
					 * 2016-06-04
					 * «This includes the user's zip/postal code number
					 * from their primary shipping address.
					 * The postal code provides valuable location data
					 * that allows you to tune your offerings
					 * and understand your customers better.»
					 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/customer_profile.html
					 *
					 * Например:
					 *	{
					 *		"user_id": "amzn1.account.AGM6GZJB6GO42REKZDL33HG7GEJA",
					 *		"name": "Jack London",
					 *		"email": "test-customer@mage2.pro",
					 *		"postal_code": "98101"
					 *	}
					 *
					 * Сначала я подумал, что запрашивать почтовый индекс тут необязательно,
					 * потому что мы уже запросили полномочия «payments:shipping_address»,
					 * и мы можем получить почтовый индекс оттуда.
					 * Однако читаем внимательно комментарий к «payments:shipping_address»:
					 * «Gives access to the full shipping address
					 * via the GetOrderReferenceDetails API call
					 * as soon as an address has been selected in the address widget.»
					 * Т.е. мы получим доступ к адресу покупателя
					 * только после того, как покупатель выберет этот адрес.
					 *
					 * Также обратите внимание, что полномочия «profile»
					 * не дают доступ к почтовому индексу.
					 *
					 * 2016-06-05
					 * Мы используем почтовый индекс здесь:
					 * https://code.dmitry-fedyuk.com/m2e/login-and-pay-with-amazon/blob/42dcb17/Customer.php#L43
					 */
					,'postal_code'
				].join(' ')
				/**
				 * 2016-06-05
				 * Запоминаем адрес страницы, на которой находился посетитель
				 * непосредственно перед авторизацией.
				 * Когда сервис авторизации вернёт посетителя обратно в наш магазин,
				 * мы перенаправим посетителя на эту страницу.
				 * https://code.dmitry-fedyuk.com/m2e/login-and-pay-with-amazon/blob/4f911a0d/Controller/Login/Index.php#L57
				 *
				 * «An opaque value used by the client
				 * to maintain state between this request and the response.
				 * The Login with Amazon authorization service will include this value
				 * when redirecting the user back to the client.
				 * It is also used to prevent crosssite request forgery.»
				 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
				 *
				 * Это значение вернётся к нам, когда сервер Amazon вернёт нам покупателя:
				 * https://client.example.com/cb#access_token=Atza|IQEBLj...
				 * &state=208257577ll0975l93l2l59l895857093449424
				 * &token_type=bearer&expires_in=3600&scope=profile
				 */
				,state: window.location.href
			}
			/**
			 * 2016-06-04
			 * «If next is a URI, once the user logs in
			 * the current window will be redirected to the URI
			 * and the authorization response will be added to the query string.
			 * The URI must use the HTTPS protocol
			 * and belong to the same domain as the current window.»
			 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/javascript_sdk_reference.html#authorize
			 *
			 * Вообще говоря, вместо URL здесь можно указать функцию JavaScript,
			 * однако нам выгоднее перенаправить покупателя на URL,
			 * потому что нам нужно записать результаты авторизации в сессию покупателя,
			 * и я не совсем понимаю, как это делать асинхронно,
			 * а вот с перенаправлением я уже реализовал пдобное в модуле Facebook Login:
			 * https://mage2.pro/c/extensions/facebook-login
			 */
			,config.redirect);
		};
		/**
		 * 2016-11-28
		 * Система клонирует меню из блока «header.links» в видимый только в мобильном режиме
		 * (но присутствующий в DOM и в настольном режиме) блок «store.links»:
		 *		$('.panel.header > .header.links').clone().appendTo('#store\\.links');
		 * https://github.com/magento/magento2/blob/2.1.2/app/design/frontend/Magento/blank/web/js/theme.js#L26-L26
		 * https://mage2.pro/t/2336
		 * По этой причине у нас сразу 2 одинаковых кнопки в шапке: одна видимая и вторая — невидимая.
		 * Обе эти кнопки инициализируются независимо (сюда мы попадаем для каждой из этих кнопок отдельно),
		 * но имеют одинаковые идентификаторы.
		 * При этом код document.getElementById('<идентификатор>') или $('#<идентификатор>')
		 * вернёт только первую из кнопок.
		 * Найти вторую можно по селектору: $(config.selector)
		 * При этом такой поиск по селектору может вернуть и третью кнопку,
		 * потому что на страницах регистрации и аутентификации наша кнопка аутентификации
		 * может быть одновременно расположена как в шапке, так и над блоком регистрации/аутентификации.
		 */
		/** @type {jQuery} HTMLAnchorElement */
		var $c = $(element);
		if ($c.closest('.nav-sections').length) {
			element.id += '-nav-sections';
		}
		else if ($c.closest('.page-header').length) {
			element.id += '-page-header';
		}
		/** @type {String} */
		var widgetUrl = df.a.ccClean('/', [
			'https://static-na.payments-amazon.com/OffAmazonPayments/us'
			,config.sandbox ? 'sandbox' : null
			,'js/Widgets.js?sellerId=' + config.merchantId
		]);
		require([widgetUrl], function() {
			if ('N' !== config.type) {
				$c.click(login);
			}
			else {
				// 2016-11-30
				// Чтобы кнопка native при загрузке елозила по экрану,
				// мы в разметке изначально указываем ['style' => 'display:none'],
				// а затем уже после загрузки JavaScript
				// удаляем это значение атрибута «style».
				$c.removeAttr('style');
				/**
				 * 2016-06-03
				 * Сделал по аналогии с
				 * https://github.com/amzn/amazon-payments-magento-plugin/blob/v1.4.2/app/code/community/Amazon/Payments/Block/Login/Script.php#L42
				 *https://github.com/amzn/amazon-payments-magento-plugin/blob/v1.4.2/app/code/community/Amazon/Payments/Block/Script.php#L56
				 *
				 * «Login and Pay with Amazon Integration Guide» → «Widgets» → «Button widgets»
				 * https://payments.amazon.com/documentation/lpwa/201953980
				 *
				 * 2016-06-04
				 * Вообще говоря, мы не обязаны использовать стандартную кнопку «Login with Amazon»,
				 * а вместо этого можем использовать ссылку https://www.amazon.com/ap/oa с параметрами:
				 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
				 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/authorization_code_grant.html
				 *
				 * Например:
				 * https://www.amazon.com/ap/oa?client_id=foodev
				 * &scope=profile&response_type=token&state=208257577ll0975l93l2l59l89585709344942
				 * &redirect_uri=https://client.example.com/redirect/
				 *
				 * При этом есть две технологии взаимодействия с сервером Amazon:
				 * «Authorization Code Grant» и «Implicit Grant», они чуть различаются
				 * серверной обработкой магазина:
				 * при «Implicit Grant» надо сделать один дополнительный запрос к API:
				 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/authorization_grants.html
				 *  Виджет ниже использует «Implicit Grant».
				 */
				OffAmazonPayments.Button(
					element.id
					,config.merchantId
					,df.o.merge(config.widget, {authorization: login})
				);
			}
		});
	});
});