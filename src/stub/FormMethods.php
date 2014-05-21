<?php
namespace TransFormer\stub;
/**
 * @method static class($class)
 */
class FormMethods extends HtmlMethods{
	/**
	 * @param string $name CSS framework name: TwitterBootstrap(3)|ZurbFoundation(4)
	 */
	public static function framework($name) {}

	/**
	 * @param $data Eloquent|array
	 * @return static
	 */
	public static function populate($data) {}

	/**
	 * @param $name
	 * @param $data Eloquent|array
	 * @return static
	 */
	public static function populateField($name, $data) {}

	/**
	 * @param $action
	 * @param $method
	 * @param $attributes
	 * @param $secure
	 * @return static
	 */
	public static function open($action, $method, $attributes, $secure) {}

	/**
	 * @param $action
	 * @param $method
	 * @param $attributes
	 * @param $secure
	 * @return static
	 */
	public static function open_horizontal($action, $method, $attributes, $secure) {}

	/**
	 * @param $action
	 * @param $method
	 * @param $attributes
	 * @param $secure
	 * @return static
	 */
	public static function open_vertical($action, $method, $attributes, $secure) {}

	/**
	 * @param $id
	 * @return static
	 */
	public static function id($id) {}

	/**
	 * @param $name
	 * @return static
	 */
	public static function name($name) {}

	/**
	 * @param $method
	 * @return static
	 */
	public static function method($method) {}

	/**
	 * @param $action
	 * @return static
	 */
	public static function action($action) {}

	/**
	 * @param $secure
	 * @return static
	 */
	public static function secure($secure) {}

	/**
	 * @param $rules
	 * @return static
	 */
	public static function rules($rules) {}

	/**
	 * @param $name
	 * @return HtmlMethods
	 */
	public static function label($name) {}

	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function text($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function textarea($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function checkbox($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function checkboxes($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function radio($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function select($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function file($name) {}
	/**
	 * @param $name
	 * @return FieldMethods
	 */
	public static function files($name) {}
	/**
	 * @return ActionsMethods
	 */
	public static function actions() {}
}
 