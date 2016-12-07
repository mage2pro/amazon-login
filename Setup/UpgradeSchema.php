<?php
namespace Dfe\AmazonLogin\Setup;
class UpgradeSchema extends \Df\Sso\Upgrade\Schema {
	/**
	 * 2016-06-04
	 * 2016-06-05
	 * В таблице eav_attribute длина кода свойства ограничивается 255 символами,
	 * однако в ядре в настоящее время есть дефект, ограничивающий длину 30 символами:
	 * https://mage2.pro/t/129
	 * Поэтому приходиться укладываться в 30.
	 * @override
	 * @used-by \Df\Sso\Upgrade\Schema::_process()
	 * @return string
	 */
	public static function fId() {return 'df_amazon__id';}
}