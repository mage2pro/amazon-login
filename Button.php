<?php
// 2016-06-02
// «Login with Amazon» button
namespace Dfe\AmazonLogin;
use Df\Amazon\Settings as SCommon;
use Dfe\AmazonLogin\Settings as S;
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
		if (!S::s()->enable()) {
			$result = '';
		}
		else if (df_customer_logged_in()) {
			$result = df_x_magento_init(__CLASS__, 'invalidate');
		}
		else {
			/** @var string $domId */
			$domId = df_uid(4, 'dfe-amazon-login-');
			$result = df_x_magento_init(__CLASS__, 'login', $this['jsOptions'] + [
				'clientId' => SCredentials::s()->id()
				,'domId' => $domId
				,'loggedIn' => df_customer_logged_in()
				,'merchantId' => SCommon::s()->merchantId()
				,'redirect' => df_url_frontend(df_route(__CLASS__), ['_secure' => true])
				,'sandbox' => SCommon::s()->test()
			]) . df_tag('div', ['id' => $domId]);
		}
		return $result;
	}
}