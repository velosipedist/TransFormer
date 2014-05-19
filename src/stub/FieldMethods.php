<?php
namespace TransFormer\stub;
//todo extract separate stubs for radio, select, files etc
class FieldMethods extends HtmlMethods{
	/**
	 * @param $placeholder
	 * @return static
	 */
	public static function placeholder($placeholder) {}
	/**
	 * @param $rows
	 * @return static
	 */
	public static function rows($rows) {}
	/**
	 * @param $columns
	 * @return static
	 */
	public static function columns($columns) {}
	/**
	 * @param $size
	 * @return static
	 */
	public static function size($size) {}
	/**
	 * @param $message
	 * @return static
	 */
	public static function error_message($message) {}
	/**
	 * @return static
	 */
	public static function autofocus() {}
	/**
	 * @return static
	 */
	public static function grouped() {}

	/**
	 * @param array $checkboxes Can have labels or integer values
	 * @return static
	 */
	public static function checkboxes(array $checkboxes) {}
	/**
	 * @param $radios
	 * @return static
	 */
	public static function radios($radios) {}

	/**
	 * Make checkboxes/radios inline
	 * @return static
	 */
	public static function inline() {}

	/**
	 * Make checkboxes/radios inline
	 * @return static
	 */
	public static function stacked() {}

	/**
	 * Check certain checkboxes
	 * @param int|array $items ['name_0'=>true, 'name_1'=>false]
	 * @return static
	 */
	public static function check($items) {}

	/**
	 * @param $items
	 * @param $select
	 * @return static
	 */
	public static function options($items, $select) {}

	/**
	 * @param $state
	 * @return static
	 */
	public static function state($state) {}

	/**
	 * @param $help
	 * @return static
	 */
	public static function help($help) {}

	/**
	 * @param $help
	 * @return static
	 */
	public static function inlineHelp($help) {}

	/**
	 * Acceptable extensions or mimes for file field
	 * @param $accept ...
	 * @return static
	 */
	public static function accept($accept) {}

	/**
	 * Max file size
	 * @param int $size
	 * @param string $units KB | MB | TB
	 * @internal param $accept
	 */
	public static function max($size, $units) {}

	/**
	 * @param array $data
	 * @param string $key
	 * @return static
	 */
	public static function useDatalist($data, $key = null) {}

}
 