<?php
namespace TransFormer;

class Validator extends \Illuminate\Validation\Validator{
	public function getRuleMessage($attr, $rule, $params) {
		$message = $this->getMessage($attr, $rule);
		while(is_array($message)){
			$message = array_shift($message);
		}
		return $this->doReplacements($message, $attr, $rule, $params);
	}
}
 