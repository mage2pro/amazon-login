<?php
namespace Dfe\AmazonLogin\Setup;
class InstallSchema extends \Df\Customer\External\Install\Schema {
	/**
	 * 2016-06-04
	 * @override
	 * @used-by \Df\Customer\External\InstallSchema::install()
	 * @return string
	 */
	public function fId() {return self::F__ID;}

	/**
	 * 2016-06-04
	 * @override
	 * @used-by \Df\Customer\External\InstallSchema::install()
	 * @return string
	 */
	public function fName() {return self::F__NAME;}

	/**
	 * 2016-06-05
	 * В таблице eav_attribute длина кода свойства ограничивается 255 символами,
	 * однако в ядре в настоящее время есть дефект, ограничивающий длину 30 символами:
	 * https://mage2.pro/t/129
	 * Поэтому приходиться укладываться в 30.
	 */
	const F__ID = 'df_amazon__id';

	/**
	 * 2016-06-05
	 * «The person's full name»
	 * https://developers.facebook.com/docs/graph-api/reference/user
	 */
	const F__NAME = 'df_amazon__name';
}