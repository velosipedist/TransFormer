<?php
namespace TransFormer;

class Validator extends \Illuminate\Validation\Validator{
	public function getRuleMessage($attr, $rule) {
		return $this->getMessage($attr, $rule);
	}
}
 