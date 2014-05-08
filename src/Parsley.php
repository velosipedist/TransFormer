<?php

namespace TransFormer;

use Former\Form\Fields\Checkbox;
use Former\Traits\Checkable;
use Former\Traits\Field;

class Parsley
{
	public static function ruleToAttributes(Field $field, $rule, $config) {
		$attrs = array();
		switch ($rule){
			case 'min':
				if($field instanceof Checkbox){
					$attrs['data-parsley-mincheck'] = $config[0];
				}
				break;
			//case 'required':
			//	$attrs['min'];
			//	break;
		}
		return $attrs;
	}
}
 