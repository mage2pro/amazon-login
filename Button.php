<?php
namespace Dfe\AmazonLogin;
use Dfe\Amazon\Settings as SCommon;
use Df\Sso\Button\Js as _P;
use Dfe\AmazonLogin\Settings\Credentials as SCredentials;
/**
 * 2016-06-02
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method \Dfe\AmazonLogin\Settings\Button s()
 */
class Button extends _P {
	/**
	 * 2016-11-26
	 * @override
	 * @see _P::jsOptions()
	 * @used-by _P::attributes()
	 * @return array(string => mixed)
	 */
	final protected function jsOptions():array {$s = $this->s(); return parent::jsOptions() + [
		'clientId' => SCredentials::s()->id()
		,'loggedIn' => df_customer_logged_in()
		,'merchantId' => SCommon::s()->merchantId()
		,'sandbox' => SCommon::s()->test()
		,'widget' => [
			# 2016-06-03
			# «The color parameter is an optional parameter for selecting a button color.»
			# https://payments.amazon.com/documentation/lpwa/201953980
			'color' => $s->nativeColor()
			# 2016-06-03
			# «The size parameter is an optional parameter for selecting a button size.»
			# https://payments.amazon.com/documentation/lpwa/201953980
			,'size' => $s->nativeSize()
			# 2016-06-03
			# «The type parameter is an optional parameter
			# for indicating the type of button image that you want to select for your web page.
			# Note that if you decide not to specify a value for type,
			# the LwA (Login with Amazon) button will be set as the default value.
			# The following table shows the valid type parameter values,
			# button descriptions, and sample button images.»
			# https://payments.amazon.com/documentation/lpwa/201953980
			,'type' => $s->nativeType()
		]
	];}

	/**
	 * 2016-11-23
	 * @override
	 * @see \Df\Sso\Button::loggedIn()
	 * @used-by \Df\Sso\Button::_toHtml()
	 */
	final protected function loggedIn():string {return df_js(__CLASS__, 'invalidate');}

	/**
	 * 2016-11-26
	 * @overide
	 * @see _P::redirectShouldBeSecure()
	 * @used-by _P::attributes()
	 */
	final protected function redirectShouldBeSecure():bool {return true;}
}