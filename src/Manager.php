<?php
namespace TransFormer;

use Former\Facades\Former as F;
use Former\Form\Form;
use Former\Former as Former;
use Former\Traits\Field;
use Illuminate\Container\Container;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Manager
 * @package TransFormer
 */
class Manager
{
	/** @var */
	private $ajaxUrl;
	/** @var */
	private $formsRoot;
	/** @var  Container */
	private $container;
	/** @var  Former */
	private $former;
	/** @var */
	private $templatesRoot;

	private $locale = 'ru';
	private $translationsPath = __DIR__;

	/**
	 * @param array $options
	 */
	public function __construct($options = array()) {
		$this->setOptions($options);

		$this->bootstrapFormer();
	}

	/**
	 * @param string    $formName
	 * @param array     $data
	 * @param Validator $validator
	 * @return Form
	 */
	private function renderForm($formName, $data, $validator) {
		$messages = $validator->getMessageBag();
		require $this->formsRoot . '/' . $formName . '.php';
	}

	/**
	 *
	 */
	private function bootstrapFormer() {
		// implicitly startup app
		F::framework('TwitterBootstrap3');
		$this->container = F::getFacadeApplication();
		$this->configureTranslations();
		$this->listenInputsRendering();
		$this->former = $this->container['former']; //todo remove?
	}

	public function onInputRender(Field $field) {
		$rules = (array)$field->getRules();
		/** @var $validator Validator */
		$validator = $this->container['validator'];
		foreach ($rules as $rule=>$config) {
			$attributes = Parsley::ruleToAttributes($field, $rule, $config);
			$field->setAttributes($attributes);
			if($field->getAttribute('error-message')){
				$message = $field->getAttribute('error-message');
				$field->removeAttribute('error-message');
			} else {
				$message = $validator->getRuleMessage($field->getName(), $rule, $config);
			}
			$field->setAttribute('data-parsley-error-message', $message);
		}
	}

	/**
	 * @param $formName
	 */
	public function render($formName) {
		$rules     = $this->findRules($formName);
		$data      = $this->fetchData($formName);
		$validator = $this->validator($rules, $data);
		$this->container->instance('validator', $validator);
		$this->renderForm($formName, $data, $validator);
	}

	/**
	 * @param $formName
	 * @return array
	 */
	private function findRules($formName) {
		return (array) require $this->formsRoot . "/{$formName}.rules.php";
	}

	/**
	 * @param $formName
	 * @return array
	 */
	private function fetchData($formName) {
		/** @var $RequestData Request */
		$RequestData = $this->container['request'];
		return $RequestData->get($formName, array());
	}

	/**
	 * @param array $rules
	 * @param array $data
	 * @return Validator
	 */
	public function validator(array $rules, array $data) {
		/** @var $translator Translator */
		$translator = $this->container['translator'];
		$translator->setLocale($this->locale);
		$factory = new Factory($translator, $this->container);
		$container = $this->container;
		$factory->resolver(function($translator, $data, $rules, $messages, $customAttributes)
			use ($container) {
				return new Validator($translator, $data, $rules, $messages, $customAttributes);
		});
		return $factory->make($data, $rules);
	}

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

	private function configureTranslations() {
		$me = $this;
		$this->container->bind('translator',
			function ($cont) use ($me) {
				$fileLoader = new FileLoader($cont['files'], __DIR__ . '/../lang');
				return new Translator($fileLoader, $this->locale);
			}
		);
	}

	/**
	 * @param $options
	 */
	public function setOptions($options) {
		foreach ($options as $option => $val) {
			$this->{$option} = $val;
		}
	}
}
 