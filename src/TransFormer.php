<?php
namespace TransFormer;

/**
 * Class TransFormer
 * @package TransFormer
 */
class TransFormer
{
	const FORMS_ROOT = 'formsRoot';
	const TEMPLATES_ROOT = 'templatesRoot';
	const LOCALE = 'locale';
	const TRANSLATIONS_PATH = 'translationsPath';
	const AJAX_URL = 'ajaxUrl';

	/** @var Manager */
	private static $manager;

	/**
	 * Instantiate forms Manager and save to session. Use it on main site frontend.
	 * @param array $options
	 * @return Manager
	 */
	public static function instance($options = array()) {
		if (is_null(self::$manager)) {
			self::$manager                       = new Manager($options);
			$_SESSION['TransFormer\TransFormer'] = self::$manager;
		} else {
			self::$manager->setOptions($options);
		}
		return self::$manager;
	}

	/**
	 * Restore manager from session, used in backend application
	 * @return Manager
	 */
	public static function resume() {
		if (is_null(self::$manager)) {
			try {
				self::$manager = $_SESSION['TransFormer\TransFormer'];
			} catch (\Exception $e) {
				exit($e->getMessage());
			}
		}
		return self::$manager;
	}

	/**
	 * @param        $formName
	 * @param string $template
	 */
	public static function render($formName, $template = 'default') {
		self::ensureManager();
		self::$manager->render($formName, $template);
	}

	/**
	 * Checks that manager already started
	 */
	private static function ensureManager() {
		if (is_null(self::$manager)) {
			throw new \LogicException("Connect manager first using TransFormer::connect()");
		}
	}
}