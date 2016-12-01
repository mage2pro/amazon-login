<?php
namespace Dfe\AmazonLogin\Setup;
class InstallData extends \Df\Sso\Install\Data {
	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Sso\Install\Data::labelPrefix()
	 * @used-by \Df\Sso\Install\Data::attribute()
	 * @return string
	 */
	protected function labelPrefix() {return 'Amazon';}

	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Sso\Install\Data::schemaClass()
	 * @used-by \Df\Sso\Install\Data::schema()
	 * @return string
	 */
	protected function schemaClass() {return InstallSchema::class;}
}