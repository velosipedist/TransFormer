<?php

namespace TransFormer;

use Former\Form\Fields\Checkbox;
use Former\Helpers;
use Former\Traits\Checkable;
use Former\Traits\Field;
use Illuminate\Translation\Translator;

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
			case 'confirmed':
				$attrs['data-parsley-confirmed'] = $field->getName() . '_confirmation';
				break;
			case 'turingbox':
				$attrs['data-parsley-turingbox'] = '';
				break;
		}
		return $attrs;
	}

	public static function translationsJson(Translator $translator, $lang) {
		$lmap = self::langMap();
		$translated = array();
		foreach ($lmap as $key => $message) {
			if(is_string($message)){
				$translated[$key] = $translator->trans('validation.' . $message);
			} else {
				if(is_array($message)){
					if(isset($message[0])){
						$msgString = array_shift($message);
						$replacePlaceholders = $message;
						$translatedMsg = $translator->trans('validation.' . $msgString);
						$translated[$key] = strtr($translatedMsg, $replacePlaceholders) ;
					} else {
						$translated[$key] = array();
						foreach ($message as $keySub => $messageSub) {
							$translated[$key][$keySub] = $translator->trans('validation.' . $messageSub);
						}
					}
				}
			}
		}
		return json_encode($translated);
	}

	public static function langMap() {
		return array(
			'type' =>
				array('email' => "email",
					'url' => "url",
					'number' => "numeric",
					'integer' => "integer",
					'digits' => "digits",
					'alphanum' => "alpha_num",
				),
			'notblank' => "required",
			'required' => "required",
			'pattern' => "regex",
			'min' => array("min.numeric",':min'=>'%s'),
			'max' =>  array("max.numeric",':max'=>'%s'),
			'range' => array("between.numeric", ':min'=>'%s', ':max'=>'%s'),
			'minlength' => array("min.string",':min'=>'%s'),
			'maxlength' => array("max.string",':max'=>'%s'),
			'length' => array("between.string", ':min'=>'%s', ':max'=>'%s'),
			'mincheck' => array("min.array",':min'=>'%s'),
			'maxcheck' => array("max.array",':max'=>'%s'),
			'check' => array("between.string", ':min'=>'%s', ':max'=>'%s'),
			'equalto' => 'same'
		);
	}
}
 