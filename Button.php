<?php
// 2016-06-02
// «Login with Amazon» button
namespace Dfe\AmazonLogin;
use Df\Amazon\Settings as SCommon;
use Dfe\AmazonLogin\Settings\Credentials as SCredentials;
class Button extends \Df\Sso\Button {
	/**
	 * 2016-11-23
	 * @override
	 * @see \Df\Sso\Button::loggedIn()
	 * @used-by \Df\Sso\Button::_toHtml()
	 * @return string
	 */
	protected function loggedIn() {return df_x_magento_init(__CLASS__, 'invalidate');}

	/**
	 * 2016-11-23
	 * @override
	 * @see \Df\Sso\Button::loggedOut()
	 * @used-by \Df\Sso\Button::_toHtml()
	 * @return string
	 */
	protected function loggedOut() {
		/** @var string $domId */
		$domId = df_uid(4, 'dfe-amazon-login-');
		return df_x_magento_init(__CLASS__, 'login', $this['dfJsOptions'] + [
			'clientId' => SCredentials::s()->id()
			,'domId' => $domId
			,'loggedIn' => df_customer_logged_in()
			,'merchantId' => SCommon::s()->merchantId()
			,'redirect' => df_url_frontend(df_route(__CLASS__), ['_secure' => true])
			,'sandbox' => SCommon::s()->test()
		]) . df_tag('div', ['id' => $domId]);
	}
}