<?php
# 2016-11-25
/** @used-by \Df\Sso\Button::s() */
namespace Dfe\AmazonLogin\Settings;
use Df\Sso\Source\Button\Type\UNL;
final class Button extends \Df\Sso\Settings\Button {
	/**
	 * 2016-11-29
	 * @override
	 * @see \Df\Sso\Settings\Button::label()
	 * @used-by \Df\Sso\Button::attributes()
	 * @used-by \Df\Sso\Button::loggedOut()
	 */
	function label():string {return UNL::isNative($this->type()) ? '' : parent::label();}

	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Color
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 */
	function nativeColor():string {return $this->v();}

	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Size
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 * @return string
	 */
	function nativeSize() {return $this->v();}

	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Type
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 * @return string
	 */
	function nativeType() {return $this->v();}
}