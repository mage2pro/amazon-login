<?php
// 2016-11-25
// https://payments.amazon.com/developer/documentation/lpwa/201953980
namespace Dfe\AmazonLogin\Source\Button\Native;
class Size extends \Df\Config\SourceT {
	/**
	 * 2016-11-25
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()  
	 * @see \Dfe\AmazonLogin\Settings\Button::nativeSize()
	 * @return array(string => string)
	 */
	protected function map() {return dfa_combine_self(['small', 'medium', 'large', 'x-large']);}
}