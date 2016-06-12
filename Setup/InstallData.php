<?php
namespace Dfe\AmazonLogin\Setup;
class InstallData extends \Df\Customer\External\Install\Data {
	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Customer\External\Install\Data::labelPrefix()
	 * @used-by \Df\Customer\External\Install\Data::attribute()
	 * @return string
	 */
	protected function labelPrefix() {return 'Amazon';}

	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Customer\External\Install\Data::schemaClass()
	 * @used-by \Df\Customer\External\Install\Data::schema()
	 * @return string
	 */
	protected function schemaClass() {return InstallSchema::class;}
}