<?php
namespace Dfe\AmazonLogin;
use Df\Amazon\Settings as S;
use Dfe\AmazonLogin\Settings\Credentials;
final class Customer extends \Df\Sso\Customer {
	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Sso\Customer::email()
	 * @used-by \Df\Sso\CustomerReturn::customerData()
	 */
	function email():string {return $this->p('email');}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Sso\Customer::id()
	 * @used-by \Df\Sso\CustomerReturn::register()
	 */
	function id():string {return $this->p('user_id');}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Sso\Customer::nameFirst()
	 * @used-by \Df\Sso\CustomerReturn::register()
	 * @return string
	 */
	function nameFirst() {return df_first($this->nameA());}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Sso\Customer::nameLast()
	 * @used-by \Df\Sso\CustomerReturn::register()
	 * @return string
	 */
	function nameLast() {return df_last($this->nameA());}

	/**
	 * 2016-06-04
	 * @used-by \Dfe\FacebookLogin\Controller\Index\Index::customerData()
	 * @return string
	 */
	function nameFull() {return $this->p('name');}

	/**
	 * 2016-06-04
	 * @override
	 * @see \Df\Sso\Customer::validate()
	 * @used-by \Df\Sso\CustomerReturn::c()
	 * @throws \Exception
	 */
	function validate():void {
		/**
		 * «If the user did not grant the request for access, or an error occurs,
		 * the authorization service will redirect the user-agent (a user's browser)
		 * to a URI specified by the client.
		 * That URI will contain error parameters detailing the error.»
		 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
		 *
		 * HTTP/l.l 302 Found
		 * Location: https://client.example.com/cb#error=access_denied
		 * &state=208257577ll0975l93l2l59l895857093449424
		 */
		$errorCode = df_request('error'); /** @var string|null $errorCode */
		if ($errorCode) {
			$errorDescription = df_request('error_description', $errorCode); /** @var string|null $errorDescription */
			df_error("[Login with Amazon]: «{$errorDescription}».");
		}
		/**
		 * 2016-06-04
		 * Проверка токена.
		 * «Once you receive an access token using the implicit grant,
		 * it is highly recommended that you verify the authenticity of the access token
		 * before you retrieve a customer profile using that token.
		 * If a malicious site can induce a user to login,
		 * they can take the valid access token they receive
		 * and use it to mimic an authorization response to your site.
		 * To verify a token, make a secure HTTP call to https://api.amazon.com/auth/O2/tokeninfo,
		 * passing the access token you wish to verify.
		 * You can specify the access token as a query parameter.»
		 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/implicit_grant.html
		 *
		 * Ответ сервера:
		 * {
		 *    "iss":"https://www.amazon.com",
		 *    "user_id": "amznl.account.K2LI23KL2LK2",
		 *    "aud": "amznl.oa2-client.ASFWDFBRN",
		 *    "app_id": "amznl.application.436457DFHDH",
		 *    "exp": 3597,
		 *    "iat": l3ll280970,
		 * }
		 * «Compare the aud value to the client_id you are using for your application.
		 * If they are different, the access token was not requested by your application,
		 * and you should not use the access token.»
		 */
		df_assert_eq(Credentials::s()->id(), $this->response('auth/o2/tokeninfo', 'aud'));
	}

	/**
	 * 2016-06-04
	 * @return string[]
	 */
	private function nameA() {return dfc($this, function() {return explode(' ', $this->nameFull());});}

	/**
	 * 2016-06-04
	 * 1) «Obtain Customer Profile Information»
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/obtain_customer_profile.html
	 * «Once the user grants your website access to their Amazon customer profile,
	 * you will receive an access token.
	 * If you're using the server-based Authorization Code Grant,
	 * the access token is returned in the access token response.
	 * If you're using the client-based Implicit grant,
	 * the access token is returned in the authorization response as a URI fragment.
	 * To access the authorized customer data,
	 * you submit that access token to Login with Amazon using HTTPS.
	 * In response, Login with Amazon will return the appropriate customer profile data.
	 * The profile data you receive is determined by the scope you specified when requesting access.
	 * The access token reflects access permission for that scope.»
	 * 2) Раньше решение было таким:
	 *	$client = new \Zend_Http_Client;
	 *	$client->setUri($this->url('user/profile'));
	 *	$client->setHeaders('Authorization', 'bearer ' . $token);
	 *	$profile = df_json_decode($client->request()->getBody())
	 *  3) Оказывается, мы не обязаны использовать заголовок HTTP «Authorization»,
	 * а можем вместо этого просто передать токен в URL:
	 * https://api.amazon.com/user/profile?access_token=AtzaIIQ...
	 * «If you are calling the Profile REST API directly,
	 * you can specify the access token in one of three ways:
	 * as a query parameter, as a bearer token, or using x-amz-access-token in the HTTP header.»
	 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/obtain_customer_profile.html
	 * 2016-06-03
	 *	{
	 *		"user_id": "amzn1.account.AGM6GZJB6GO42REKZDL33HG7GEJA",
	 *		"name": "Jack London",
	 *		"email": "test-customer@mage2.pro"
	 *	}
	 * 2016-06-04
	 * «Integrate with Your Existing Account System» https://login.amazon.com/documentation/combining-user-accounts
	 * «You will need to modify your account database
	 * to record a mapping between Amazon account identifiers and your local accounts.
	 * This could take the form of a new field in your account table
	 * or a table that maps between Amazon account identifiers and your local account identifiers.
	 * Amazon account identifiers are returned as the user_ID property,
	 * in the form amzn1.accountVALUE. For example: amzn1.account.K2LI23KL2LK2.»
	 * @used-by self::email()
	 * @used-by self::id()
	 * @used-by self::nameFull()
	 */
	private function p(string $k, string $d = ''):string {return df_nts($this->response('user/profile', $k, $d));}

	/**
	 * 2016-06-04
	 * @param string $path
	 * @param string $key
	 * @param string|null $d [optional]
	 * @return array(string => string)
	 */
	private function response($path, $key, $d = null):array {return dfa(dfc($this, function($path) {return
		df_http_json($this->url($path))
	;}, [$path]), $key, $d);}

	/**
	 * 2016-06-03
	 * @used-by self::response()
	 */
	private function url(string $path):string {
		if (!isset($this->_urlBase)) {
			$this->_urlBase = df_ccc('.', 'https://api', S::s()->test() ? 'sandbox' : null, 'amazon.com/');
		}
		if (!isset($this->_urlQuery)) {
			/**
			 * 2016-06-04
			 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/access_token.html
			 * «After users log in, they are returned to your website or mobile app.
			 * At this point, your client can obtain an access token
			 * by calling the Login with Amazon authorization service.
			 * That token allows clients to access the customer's name and email address
			 * from their customer profile.»
			 * «Access tokens are only valid for sixty minutes
			 * and are specific to the user logging in and the data the app requested
			 * when it triggered the login.»
			 *
			 * В принципе, при необходимости мы можем обменять полученный сейчас временный токен
			 * (который действителен 1 час) на безлимитный:
			 * «A refresh token allows a website to request a new access token,
			 * even if the access token has expired.
			 * Refresh tokens follow the same format as access tokens,
			 * except they begin with the string Atzr|.
			 * Refresh tokens are valid indefinitely,
			 * unless the user has removed the website or mobile app
			 * from the list of allowed apps for their account.
			 * Refresh tokens have a maximum size of 2048 bytes.
			 * A refresh token is specifically assigned to one client
			 * and cannot be used by another client.»
			 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/refresh_token.html
			 *
			 * Не, в данном конкретном случае получить refresh token не можем:
			 * «Refresh tokens are returned only in the Authorization Code Grant».
			 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/refresh_token.html
			 *
			 * Есть две технологии взаимодействия с сервером Amazon:
			 * «Authorization Code Grant» и «Implicit Grant», они чуть различаются
			 * серверной обработкой магазина:
			 * при «Implicit Grant» надо сделать один дополнительный запрос к API:
			 * https://developer.amazon.com/public/apis/engage/login-with-amazon/docs/authorization_grants.html
			 * Мы используем «Implicit Grant», поэтому получить refresh token не можем.
			 * Ну не особо и надо.
			 */
			$this->_urlQuery = '?' . http_build_query(['access_token' => df_request('access_token')]);
		}
		return $this->_urlBase . $path . $this->_urlQuery;
	}

	/**
	 * 2016-06-04
	 * @var string
	 * @used-by \Dfe\AmazonLogin\Customer::url()
	 */
	private $_urlBase;

	/**
	 * 2016-06-04
	 * @var string
	 * @used-by \Dfe\AmazonLogin\Customer::url()
	 */
	private $_urlQuery;
}