<?php
namespace Dfe\AmazonLogin\Source\Button\Native;
# 2016-11-25 https://payments.amazon.com/developer/documentation/lpwa/201953980
final class Color extends \Df\Config\Source {
	/**
	 * 2016-11-25
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()  
	 * @see \Dfe\AmazonLogin\Settings\Button::nativeColor()
	 * @return array(string => string)
	 */
	protected function map():array {return ['Gold' => 'gold',' LightGray' => 'light gray', 'DarkGray' => 'dark gray'];}
}