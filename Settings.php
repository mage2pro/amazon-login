<?php
// 2016-06-02
namespace Dfe\AmazonLogin;
/** @method static Settings s() */
class Settings extends \Df\Core\Settings {
	/**
	 * 2016-06-02
	 * @override
	 * @see \Df\Core\Settings::prefix()
	 * @used-by \Df\Core\Settings::v()
	 * @return string
	 */
	protected function prefix() {return 'df_amazon/login/';}
}


