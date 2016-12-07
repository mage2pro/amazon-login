<?php
namespace Dfe\AmazonLogin\Setup;
class UpgradeData extends \Df\Sso\Upgrade\Data {
	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Sso\Upgrade\Data::labelPrefix()
	 * @used-by \Df\Sso\Upgrade\Data::attribute()
	 * @return string
	 */
	protected function labelPrefix() {return 'Amazon';}
}