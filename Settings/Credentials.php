<?php
# 2016-06-02
namespace Dfe\AmazonLogin\Settings;
/** @method static Credentials s() */
final class Credentials extends \Df\Config\Settings {
	/**
	 * 2016-06-02
	 * «Client ID»
	 * @return string
	 */
	function id() {return $this->v();}

	/**
	 * 2016-06-02
	 * «Client Secret»
	 * @return string
	 */
	function secret() {return $this->p();}

	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Config\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_amazon/login/credentials';}
}