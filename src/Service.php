<?php
namespace TransFormer {
	use TransFormer;
	use TransFormer\facade\Former;

	/**
	 * Class TransFormer
	 * @package TransFormer
	 */
	class Service
	{
		const FORMS_ROOT = 'formsRoot';
		const LOCALE = 'locale';
		const TRANSLATIONS_PATH = 'translationsPath';
		const AJAX_URL = 'ajaxUrl';
		const ERRORS_DEFAULT = '__TransFormer_err_default';

		/** @var Manager */
		protected static $manager;
		private static $errors = array();

		/**
		 * Instantiate forms Manager and save to session. Use it on main site frontend.
		 * If manager instantiated, options will be set in existing instance.
		 * @param array $options
		 */
		public static function setup($options = array()) {
			if (is_null(self::$manager)) {
				self::$manager = new Manager($options);
			} else {
				self::$manager->setOptions($options);
			}
		}

		/**
		 * Restore manager from session, used in backend application
		 */
		public static function resume() {
			if (is_null(self::$manager)) {
				try {
					self::$manager = $_SESSION['TransFormer\TransFormer'];
				} catch (\Exception $e) {
					exit($e->getMessage());
				}
			}
		}

		/**
		 * Register named form confiuration for further validating & rendering
		 * @param $formName
		 * @param array $rules
		 * @param array $labels
		 */
		public static function registerForm($formName, array $rules, $labels = array()) {
			self::$manager->registerForm($formName, $rules, $labels);
		}

		/**
		 * Render separate template file with form options.
		 * Automatically register form.
		 * If form already registered, ignores passed rules, labels & data
		 * @param string $formName
		 * @param array $rules
		 * @param array $labels
		 * @param array $data
		 */
		public static function render($formName, array $rules = array(), $labels = array(), $data = array()) {
			self::ensureManager();
			try	{
				self::$manager->selectForm($formName);
			} catch (\Exception $e) {
				self::$manager->registerForm($formName, $rules, $labels)
					->populate($data);
			}
			return self::$manager->render($formName);
		}

		/**
		 * Checks that manager already started
		 */
		private static function ensureManager() {
			if (is_null(self::$manager)) {
				throw new \LogicException("Run TransFormer::setup() first");
			}
		}

		public static function languageJs() {
			self::ensureManager();
			return self::$manager->languageJs();
		}

		/**
		 * Validates and automatically populates form when data is invalid.
		 * Also implicitly makes form active
		 * @param $data
		 * @param null $formName
		 * @return bool
		 */
		public static function validate($data, $formName = null) {

			if ($formName) {
				self::$manager->selectForm($formName, $data);
			}
			$validator = self::$manager->createValidator($formName, $data);
			$errKey = $formName ? $formName : self::ERRORS_DEFAULT;
			$valid = $validator->passes();
			self::$errors[$errKey] = $valid ? array() : $validator->messages()->toArray();
			if(!$valid){
				self::populate($data);
				Former::withErrors($validator);
			}
			return $valid;
		}

		/**
		 * Fills active form with data. If formName specified, it will be made active.
		 * @param $data
		 * @param null $formName
		 */
		public static function populate($data, $formName = null) {
			Service::ensureManager();
			if ($formName) {
				self::$manager->selectForm($formName, $data);
			}
			Service::$manager->populate($data);
		}

		/**
		 * Errors for currently validated form.
		 * @param null $formName
		 * @return array
		 */
		public static function errors($formName = null) {
			$errKey = $formName ? $formName : self::ERRORS_DEFAULT;
			if(isset(self::$errors[$errKey])){
				return self::$errors[$errKey];
			}
			return array();
		}
	}
}
namespace {
	use TransFormer\facade\Former;
	use TransFormer\Service;

	/**
	 * @see TransFormer\Service
	 */
	class TransFormer extends Service{

	}
}