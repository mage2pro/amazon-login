<?php
// 2016-06-02
namespace Dfe\AmazonLogin;
// Аргумент $s для методов этого класса не нужен,
// потому что опции этого класса считывается только на витрине для текущего магазина.
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


