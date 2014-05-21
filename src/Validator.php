<?php
namespace TransFormer;

use Former\Traits\Field;

class Validator extends \Illuminate\Validation\Validator{
	public function getRuleMessage(Field $field, $rule, $params) {
		$messageKey = $field->getName();
		$message = $this->getMessage($messageKey, $rule);
		if(is_array($message)){
			$subKey = $this->detectSubtypeKey($field);
			$message = $message[$subKey];
		}
		return $this->doReplacements($message, $field->getName(), $rule, $params);
	}

	/**
	 * Detect validation type , that may be numeric|file|string|array
	 * @param $field
	 * @return string
	 */
	private function detectSubtypeKey(Field $field) {
		if($field->isOfType('checkbox','checkboxes')){
			return 'array';
		}
		if($field->isOfType('range')){
			return 'array';
		}
		if($field->isOfType('number')){
			return 'numeric';
		}
		if($field->isOfType('file')){
			return 'file';
		}
		if($field->isOfType('text', 'email', 'phone')){
			return 'string';
		}
		return 'string';
	}
}
 