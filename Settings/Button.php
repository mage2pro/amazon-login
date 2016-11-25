<?php
// 2016-11-25
/** @used-by \Df\Sso\Button::s() */
namespace Dfe\AmazonLogin\Settings;
class Button extends \Df\Sso\Settings\Button {
	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Color
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 * @return string
	 */
	public function nativeColor() {return $this->v();}

	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Size
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 * @return string
	 */
	public function nativeSize() {return $this->v();}

	/**
	 * 2016-11-25
	 * @see \Dfe\AmazonLogin\Source\Button\Native\Type
	 * @used-by \Dfe\AmazonLogin\Button::loggedOut()
	 * @return string
	 */
	public function nativeType() {return $this->v();}
}