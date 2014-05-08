<?php
/**
 * @var string $formName
 * @var array $data
 * @var \Illuminate\Validation\Validator $validator
 * @var \Illuminate\Support\MessageBag $messages
 */
use Former\Facades\Former as Form;

$rules = array('name' => 'required');

/** @var $form \Former\Form\Form */
print Form::open('', 'GET', array(), true)
            ->id('MyForm')
            ->rules($validator->getRules());
print Form::text('name')
          ->addClass('foo')
          ->placeholder('foo');

print Form::textarea('comments')->grouped()
          ->rows(4)->columns(20)
          ->autofocus();
print Form::checkboxes('bar')->grouped()
			->checkboxes('Yes', 'No')->data_parsley_error_message('YES or NO')
          ->autofocus();

print Form::actions()
          ->primary_submit('Submit')
          ->inverse_reset('Reset');
return $form;