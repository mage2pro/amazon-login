<?php
# 2016-06-02
namespace Dfe\AmazonLogin\Settings;
/** @method static Credentials s() */
final class Credentials extends \Df\Config\Settings {
	/**
	 * 2016-06-02 «Client ID»
	 * @used-by \Dfe\AmazonLogin\Button::jsOptions()
	 * @used-by \Dfe\AmazonLogin\Customer::validate()
	 */
	function id():string {return $this->v();}

	/**
	 * 2016-06-02 «Client Secret»
	 * 2022-11-17 @deprecated It is unused.
	 */
	function secret():string {return $this->p();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return 'df_amazon/login/credentials';}
}