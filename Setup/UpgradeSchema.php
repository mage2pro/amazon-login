<?php
namespace Dfe\AmazonLogin\Setup;
// 2016-06-04
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class UpgradeSchema extends \Df\Sso\Upgrade\Schema {
	/**
	 * 2016-06-04
	 * 2016-06-05
	 * В таблице eav_attribute длина кода свойства ограничивается 255 символами,
	 * однако в ядре в настоящее время есть дефект, ограничивающий длину 30 символами:
	 * https://mage2.pro/t/129
	 * Поэтому приходиться укладываться в 30.
	 * @override
	 * @see \Df\Sso\Upgrade\Schema::fId()
	 * @used-by \Df\Sso\Upgrade\Schema::_process()
	 * @return string
	 */
	final static function fId() {return 'df_amazon__id';}
}