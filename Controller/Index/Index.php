<?php
namespace Dfe\AmazonLogin\Controller\Index;
use Df\Sso\CustomerReturn as _P;
use Df\Framework\Plugin\View\Layout as PluginLayout;
/**
 * 2016-06-04
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * «Integrate with Your Existing Account System»
 * https://login.amazon.com/documentation/combining-user-accounts
 *
 * 2016-06-03
 * «Obtaining profile information»
 * https://payments.amazon.com/documentation/lpwa/201953190#button_widget_php
 *
 * 2016-06-04
 * Обратите внимание, что сервер Amazon сюда же перенаправляет покупателя в ситуации,
 * когда покупатель не авторизовался:
 * «If the user did not grant the request for access, or an error occurs,
 * the authorization service will redirect the user-agent (a user's browser)
 * to a URI specified by the client.
 * That URI will contain error parameters detailing the error.»
 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
 *
 * HTTP/l.l 302 Found
 * Location: https://client.example.com/cb#error=access_denied
 * &state=208257577ll0975l93l2l59l895857093449424
 *
 * 2016-06-05
 * Проверку на подобные сбои мы производим в методе @see \Dfe\AmazonLogin\Customer::validate()
 *
 * 2016-06-06
 * Заметил, что если сменить имя владельца тестовой учётной записи в Amazon Seller Central,
 * то запросы к https://api.sandbox.amazon.com/user/profile продолжают возвращать прежнее имя.
 * https://mage2.pro/t/1739
 * http://sellercentral.amazon.com/gp/contact-us/contact-amazon-form.html?caseID=1769644581
 *
 * @method \Dfe\AmazonLogin\Customer c()
 */
class Index extends _P {
	/**
	 * 2016-06-06
	 * Перечень свойств покупателя, которые надо обновить в Magento
	 * после их изменения в сторонней системе авторизации.
	 *
	 * Почтовый индекс здесь обновлять бесполезно:
	 * несмотря на то, что он отображается в административной таблице покупателей,
	 * он привязан только к адресу, но не к покупателю.
	 *
	 * 2016-11-21
	 * Имя решил также не обновлять,
	 * потому что Amazon может вернуть в качестве имени просто «dfediuk»,
	 * и тогда мы перетрём в Magento реальное имя покупателя (ранее введённое им в Magento).
	 *
	 * @see _P::customerFieldsToSync()
	 * @used-by _P::customer()
	 * @return string[]
	 */
	final protected function customerFieldsToSync() {return
		array_merge(['email'], parent::customerFieldsToSync())
	;}

	/**
	 * 2016-06-05
	 * Не всегда имеет смысл автоматически создавать адрес.
	 * В частности, для Amazon решил этого не делать,
	 * потому что автоматический адрес создаётся на основании геолокации, что не точно,
	 * а в случае с Amazon мы гарантированно можем получить точный адрес из профиля Amazon,
	 * поэтому нам нет никакого смысла забивать систему неточным автоматическим адресом.
	 * @override
	 * @see _P::needCreateAddress()
	 * @used-by _P::register()
	 * @return bool
	 */
	final protected function needCreateAddress() {return false;}

	/**
	 * 2016-06-06
	 * @override
	 * @see _P::postProcess()
	 * @used-by _P::execute()
	 */
	final protected function postProcess() {df_cookie_set_js(PluginLayout::NEED_UPDATE_CUSTOMER_DATA, 1);}

	/**
	 * 2016-06-05
	 * https://code.dmitry-fedyuk.com/m2e/login-and-pay-with-amazon/blob/4f911a0d/view/frontend/web/login.js#L232
	 * @override
	 * @see _P::redirectUrlKey()
	 * @used-by _P::redirectUrl()
	 * @return string
	 */
	final protected function redirectUrlKey() {return 'state';}
}