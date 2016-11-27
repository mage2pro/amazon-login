<?php
// 2016-06-02
// «Login with Amazon» button
namespace Dfe\AmazonLogin;
use Df\Amazon\Settings as SCommon;
use Dfe\AmazonLogin\Settings\Credentials as SCredentials;
/** @method \Dfe\AmazonLogin\Settings\Button s() */
class Button extends \Df\Sso\Button\Js {
	/**
	 * 2016-11-26
	 * @override
	 * @see \Df\Sso\Button\Js::jsOptions()
	 * @used-by \Df\Sso\Button\Js::loggedOut()
	 * @return array(string => mixed)
	 */
	final protected function jsOptions() {return [
		'clientId' => SCredentials::s()->id()
		,'loggedIn' => df_customer_logged_in()
		,'merchantId' => SCommon::s()->merchantId()
		,'sandbox' => SCommon::s()->test()
		,'widget' => [
			// 2016-06-03
			// «The color parameter is an optional parameter for selecting a button color.»
			// https://payments.amazon.com/documentation/lpwa/201953980
			'color' => $this->s()->nativeColor()
			// 2016-06-03
			// «The size parameter is an optional parameter for selecting a button size.»
			// https://payments.amazon.com/documentation/lpwa/201953980
			,'size' => $this->s()->nativeSize()
			// 2016-06-03
			// «The type parameter is an optional parameter
			// for indicating the type of button image that you want to select for your web page.
			// Note that if you decide not to specify a value for type,
			// the LwA (Login with Amazon) button will be set as the default value.
			// The following table shows the valid type parameter values,
			// button descriptions, and sample button images.»
			//	https://payments.amazon.com/documentation/lpwa/201953980
			,'type' => $this->s()->nativeType()
		]
	];}

	/**
	 * 2016-11-23
	 * @override
	 * @see \Df\Sso\Button::loggedIn()
	 * @used-by \Df\Sso\Button::_toHtml()
	 * @return string
	 */
	final protected function loggedIn() {return df_x_magento_init(__CLASS__, 'invalidate');}

	/**
	 * 2016-11-26
	 * @overide
	 * @see \Df\Sso\Button\Js::redirectShouldBeSecure()
	 * @used-by \Df\Sso\Button\Js::loggedOut()
	 * @return bool
	 */
	final protected function redirectShouldBeSecure() {return true;}
}