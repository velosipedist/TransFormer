<?php
/**
 * @var string                           $formName
 * @var array                            $data
 * @var \Illuminate\Validation\Validator $validator
 * @var \Illuminate\Support\MessageBag   $messages
 */
use TransFormer\facade\Former as F;

/*$config = array(
	'form' => ['action' => '', 'method' => 'get', 'secure' => true],
	'inputs' => [
		'name' => ['type'=>'text','id' => 'nameId', 'rules' => 'required'],
		'comments' => ['type'=>'textarea','id' => 'commId', 'rules' => 'required'],
		'agree' => ['type'=>'checkboxes', 'rules' => 'required|min:2', ],
	],
	'buttons'=>[
		'submit'=>['type'=>'submit'],
	]
);*/
/** @var $form \Former\Form\Form */
print F::open_vertical('', 'GET', array(), true)
       ->id('MyForm')
       ->rules($validator->getRules());
print F::text('name')
       ->addClass('foo')
       ->placeholder('foo');

print F::textarea('comments')->grouped()
       ->rows(4)->columns(20)
       ->autofocus();
print F::checkboxes('bar')->grouped()
       ->checkboxes(array('Yes', 'No'))
       ->error_message('YES or NO')
       ->autofocus();
print F::radio('bar-radio')
       ->radios(array('FM', 'AM'))
       ->error_message('CHOOSE radio')
		->check(0)
       ->autofocus();

print F::actions()
       ->primary_submit('Submit')
       ->inverse_reset('Reset');
return $form;