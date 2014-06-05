<?php
namespace TransFormer\stub;
class ActionsMethods extends HtmlMethods{
	/**
	 * @param $label
	 * @param null $link
	 * @param array $attributes
	 * @return static
	 */
	public static function primary_submit($label, $link = null, $attributes = array()) {}

	/**
	 * @param $label
	 * @param null $link
	 * @param array $attributes
	 * @return static
	 */
	public static function success_submit($label, $link = null, $attributes = array()) {}

	/**
	 * @param $label
	 * @param null $link
	 * @param array $attributes
	 * @return static
	 */
	public static function danger_submit($label, $link = null, $attributes = array()) {}

	/**
	 * @param $label
	 * @param null $link
	 * @param array $attributes
	 * @return static
	 */
	public static function inverse_submit($label, $link = null, $attributes = array()) {}

	/**
	 * @param $label
	 * @param null $link
	 * @param array $attributes
	 * @return static
	 */
	public static function large_submit($label, $link = null, $attributes = array()) {}
	/**
	 * @param $label
	 * @return static
	 */
	public static function primary_reset($label) {}
	/**
	 * @param $label
	 * @return static
	 */
	public static function success_reset($label) {}
	/**
	 * @param $label
	 * @return static
	 */
	public static function danger_reset($label) {}
	/**
	 * @param $label
	 * @return static
	 */
	public static function inverse_reset($label) {}
	/**
	 * @param $label
	 * @return static
	 */
	public static function large_reset($label) {}
}
 