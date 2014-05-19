<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Нужно ваше явное согласие",
	"active_url"           => "Введите действующую ссылку",
	"after"                => "Укажите дату позже :date",
	"alpha"                => "Используйте только буквы",
	"alpha_dash"           => "Используйте только буквы, цифры, и дефисы",
	"alpha_num"            => "Используйте только буквы и цифры",
	"array"                => "Данные должны быть списком",
	"before"               => "Укажите дату ранее :date",
	"between"              => array(
		"numeric" => "Укажите число между :min и :max",
		"file"    => "Размер должен быть между :min и :max килобайт",
		"string"  => "Длина должна быть между :min и :max знаков",
		"array"   => "Укажите от :min до :max элементов",
	),
	"confirmed"            => "Не совпадает с подтверждением",
	"date"                 => "Дата указана неверно",
	"date_format"          => "Значение не сответствует формату :format",
	"different"            => "Значение должно отличаться от :other",
	"digits"               => "Значение должно содержать :digits цифр",
	"digits_between"       => "Значение должно содержать от :min до :max цифр",
	"email"                => "Укажите адрес электронной почты",
	"exists"               => "Не существует",
	"image"                => "Должен быть изображением",
	"in"                   => "Не в списке допустимых значений",
	"integer"              => "Введите целое число",
	"ip"                   => "Введите корректный IP-адрес",
	"max"                  => array(
		"numeric" => "Введите число меньше :max",
		"file"    => "Укажите файл меньше :max килобайт",
		"string"  => "Длина должна быть меньше :max знаков",
		"array"   => "должен содержать меньше :max значений",
	),
	"mimes"                => "поддерживает типы: :values",
	"min"                  => array(
		"numeric" => "должен быть не меньше :min",
		"file"    => "должен быть не меньше :min килобайт",
		"string"  => "должен быть не меньше :min знаков",
		"array"   => "должен иметь не меньше :min значений",
	),
	"not_in"               => "не в списке допустимых значений",
	"numeric"              => "должен быть числом",
	"regex"                => "не соответствует формату",
	"required"             => "обязателен",
	"required_if"          => "необходимо заполнить, если :other имеет значение :value",
	"required_with"        => "необходимо заполнить, если указаны :values",
	"required_with_all"    => "необходимо заполнить, если указаны :values",
	"required_without"     => "необходимо заполнить, если :values не указаны",
	"required_without_all" => "необходимо заполнить, если :values не указаны",
	"same"                 => "и :other должны совпадать",
	"size"                 => array(
		"numeric" => "Размер должен быть :size",
		"file"    => "Размер должен быть :size килобайт",
		"string"  => "Размер должен быть :size знаков",
		"array"   => "Размер должен содержать :size значений",
	),
	"unique"               => "Значение уже существует",
	"url"                  => "должен быть ссылкой",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
