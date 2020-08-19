<?php
namespace Dfe\AmazonLogin\Setup;
# 2016-06-05
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class UpgradeData extends \Df\Sso\Upgrade\Data {
	/**
	 * 2016-06-05
	 * @override
	 * @see \Df\Sso\Upgrade\Data::labelPrefix()
	 * @used-by \Df\Sso\Upgrade\Data::attribute()
	 * @return string
	 */
	final protected function labelPrefix() {return 'Amazon';}
}