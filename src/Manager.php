<?php
namespace TransFormer;

use Former\Form\Form;
use Former\Former as Former;
use Former\Traits\Field;
use Illuminate\Container\Container;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Symfony\Component\HttpFoundation\Request;
use TransFormer\facade\Former as F;

/**
 * Manages injection of custom behaviors in Former magic features.
 *
 * @package TransFormer
 */
class Manager
{
	private static $jsLangRegistered = false;
	/** @var */
	private $ajaxUrl;
	/** @var */
	private $formsRoot;
	/** @var  Container */
	private $container;

	private $locale = 'ru';
	private $translationsPath = __DIR__;

	private $lastFormId;
	/**
	 * @var array
	 */
	private $hooks;
	private $formsOptions;
	private $formsData = array();
	private $selectedForm;

	/**
	 * @param array $options
	 */
	public function __construct($options = array()) {
		$this->setOptions($options);
		$this->bootstrapFormer();
	}

	/**
	 * @param string $formName
	 * @return Form
	 */
	private function renderForm($formName) {
		require $this->formsRoot . '/' . $formName . '.php';
	}

	/**
	 * Startup procedures on Manager created
	 */
	private function bootstrapFormer() {
		// implicitly startup app
		F::framework('TwitterBootstrap3');
		$this->container = F::getFacadeApplication();
		$this->configureTranslations();
		$this->listenFormOpening();
		$this->listenInputsRendering();
		$this->hooks = array(
			'onFormOpened'=>array(),
			'onInputRender'=>array(),
		);
		$translator = $this->container['translator'];
		$translator->setLocale($this->locale);
	}

	/**
	 * Hook for improve input field with Parsley rules before rendering
	 * @param Field $field
	 */
	public function onInputRender(Field $field) {
		$rules = (array)$field->getRules();
		/** @var $validator Validator */
		foreach ($rules as $rule=>$config) {
			$attributes = Parsley::ruleToAttributes($field, $rule, $config);
			$field->setAttributes($attributes);
		}
		if($hook = $this->hooks['onInputRender']){
			call_user_func_array($hook, array($field));
		}
	}

	/**
	 * @param $formName
	 */
	public function render($formName) {
		$this->renderForm($formName);
		if($id = $this->lastFormId){
			print "<script>$(function(){ $('#{$id}:not(form[data-parsley-validate])').parsley() })</script>";
		}
	}

	/**
	 * Script for Parsley validation messages
	 */
	public function languageJs() {
		return "<!--parsley lang -->"
			. "<script>\n"
			. "//@ sourceURL=http://" . $_SERVER['HTTP_HOST'] . "/TransFormer/i18n\n"
			. "window.ParsleyConfig = window.ParsleyConfig || {};\n"
			. "window.ParsleyConfig.i18n = window.ParsleyConfig.i18n || {};\n"
			. "window.ParsleyConfig.i18n.ru = $.extend(window.ParsleyConfig.i18n.ru || {}, \n"
			. Parsley::translationsJson($this->container['translator'], 'ru')
			. ");\n"
			. "if ('undefined' !== typeof window.ParsleyValidator)\n"
			. "window.ParsleyValidator.addCatalog('ru', window.ParsleyConfig.i18n.ru, !0);\n</script>";
	}

	/**
	 * Register named form options
	 * @param $formName
	 * @param $rules
	 * @param $labels
	 * @return $this
	 */
	public function registerForm($formName, array $rules, array $labels = array()) {
		$validator = null;
		$this->formsOptions[$formName] = array(
			'rules'=>$rules,
			'labels'=>$labels,
		);
		$this->selectForm($formName);
		return $this;
	}

	/**
	 * Select pre-configured form for reading options
	 * @param $formName
	 * @return $this
	 */
	public function selectForm($formName) {
		$this->selectedForm = $formName;

		$options = $this->getRegisteredFormOptions($formName);
		list($rules, $labels) = array($options['rules'], $options['labels']);
		$validator = $this->createValidator($this->selectedForm);
		$this->container->instance('validator', $validator);

		$data = isset($this->formsData[$formName]) ? $this->formsData[$formName] : null;

		$this->hooks['onFormOpened'] = function(Form $form) use ($rules, $validator, $data){
			$form->rules($rules);
			if($data){
				$form->populate($data);
			}
		};
		$this->hooks['onInputRender'] = function(Field $field) use ($rules, $data, $labels){
			if(isset($labels[$field->getName()])){
				$field->label($labels[$field->getName()]);
			}
		};
		return $this;
	}

	/**
	 * Fill current form with data
	 * @param $data
	 * @param null $formName
	 * @return $this
	 */
	public function populate($data, $formName = null) {
		if(!$formName){
			$formName = $this->selectedForm;
		}
		$this->formsData[$formName] = $data;
		return $this;
	}

	/**
	 * Create configured form validator
	 * @param $formName
	 * @param array $data
	 * @return Validator
	 */
	public function createValidator($formName = null, array $data = null) {
		if (!$formName) {
			$formName = $this->selectedForm;
		}
		$options = $this->getRegisteredFormOptions($formName);
		list($rules, $labels) = array($options['rules'], $options['labels']);
		if (!$data) {
			$data = $this->getPopulatedFormData($formName);
		}
		/** @var $translator Translator */
		$translator = $this->container['translator'];
		$factory = new Factory($translator, $this->container);
		$container = $this->container;
		$factory->resolver(function($translator, $data, $rules, $messages, $customAttributes) use ($container) {
			return new Validator($translator, $data, $rules, $messages, $customAttributes);
		});
		
		return $factory->make($data, $rules, array(), $labels);
	}

	/**
	 * Setup container to catch every Form creation before render
	 */
	private function listenFormOpening() {
		$this->container->instance('former.form', new \stdClass());
		// start rebind chain for further fields cacthing
		$me = $this;
		$this->container->rebinding(
			'former.form',
			function ($container, $form) use ($me) {
				if ($form instanceof Form) {
					$me->onFormOpened($form);
				}
			}
		);
	}

	/**
	 * Setup container to catch every Field creation before render
	 */
	private function listenInputsRendering() {
		$this->container->instance('former.field', new \stdClass());
		// start rebind chain for further fields cacthing
		$me = $this;
		$this->container->rebinding(
			'former.field',
			function ($key, $field) use ($me) {
				if ($field instanceof Field) {
					$me->onInputRender($field);
				}
			}
		);
	}

	/**
	 * Setup container Translator to read standard rules messages from library directory
	 */
	private function configureTranslations() {
		$me = $this;
		$this->container->bind('translator',
			function ($cont) use ($me) {
				$fileLoader = new FileLoader($cont['files'], __DIR__ . '/../lang');
				return new Translator($fileLoader, $me->getLocale());
			}
		);
	}

	/**
	 * Set all options available as Service constants
	 * @param array $options
	 */
	public function setOptions(array $options = array()) {
		//todo inject hooks from outside, by name
		unset($options['hooks']);
		foreach ($options as $option => $val) {
			$this->{$option} = $val;
		}
	}

	/**
	 * Triggers hook for opening every Former Form
	 * @param Form $form
	 */
	public function onFormOpened(Form $form) {
		$this->lastFormId = ($id = $form->getAttribute('id')) ? $id : null;
		if($handler = $this->hooks['onFormOpened']){
			call_user_func_array($handler, array($form));
		}
	}

	/**
	 * Options for registered form, rules and labels
	 * @param $formName
	 * @return array ['rules'=> [...], 'labels' => [...]]
	 */
	private function getRegisteredFormOptions($formName) {
		if(!isset($this->formsOptions[$formName])){
			throw new \InvalidArgumentException("Form $formName not configured");
		}
		return $this->formsOptions[$formName];
	}

	/**
	 * Returns data if {@link $this->populate() populate} was called for this form
	 * @param $formName
	 * @return array
	 */
	private function getPopulatedFormData($formName) {
		$data = array();
		if(isset($this->formsData[$formName])){
			$data = $this->formsData[$formName];
		}
		return $data;
	}

	/**
	 * @return string
	 */
	public function getLocale() {
		return $this->locale;
	}
}
 