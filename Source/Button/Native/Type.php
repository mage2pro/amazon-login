<?php
// 2016-11-25
// https://payments.amazon.com/developer/documentation/lpwa/201953980
namespace Dfe\AmazonLogin\Source\Button\Native;
class Type extends \Df\Config\SourceT {
	/**
	 * 2016-11-25
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()  
	 * @see \Dfe\AmazonLogin\Settings\Button::nativeType()
	 * @return array(string => string)
	 */
	protected function map() {return [
		'LwA' => 'logo and «Login with Amazon» label'
		,'Login' => 'logo and «Login» label'
		,'A' => 'logo only'
	];}
}