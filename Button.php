<?php
// 2016-06-02
// «Login with Amazon» button
namespace Dfe\AmazonLogin;
use Df\Amazon\Settings as S;
use Dfe\AmazonLogin\Settings as SLogin;
use Dfe\AmazonLogin\Settings\Credentials as SCredentials;
use Magento\Framework\View\Element\AbstractBlock;
class Button extends AbstractBlock {
	/**
	 * 2016-06-03
	 * @override
	 * @see AbstractBlock::_toHtml()
	 * @return string
	 */
	protected function _toHtml() {
		/** @var string $result */
		if (!SLogin::s()->enable()) {
			$result = '';
		}
		else if (df_customer_logged_in()) {
			$result = df_x_magento_init(__CLASS__, 'invalidate');
		}
		else {
			/** @var string $domId */
			$domId = df_uid(4, 'df-amazon-');
			$result =
				df_x_magento_init(__CLASS__, 'login', $this['jsOptions'] + [
					'clientId' => SCredentials::s()->id()
					,'domId' => $domId
					,'loggedIn' => df_customer_logged_in()
					,'merchantId' => S::s()->merchantId()
					,'redirect' => df_url('df-amazon/login', ['_secure' => true])
					,'sandbox' => S::s()->test()
				])
				. df_tag('div', ['id' => $domId])
			;
		}
		return $result;
	}
}