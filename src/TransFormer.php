<?php
namespace TransFormer;

/**
 * Class TransFormer
 * @package TransFormer
 */
class TransFormer
{
	const LOCALE = 'locale';
	const TRANSLATIONS_PATH = 'translationsPath';

	/** @var Manager */
	private static $manager;


	/**
	 * Instantiate forms Manager and save to session. Use it on main site frontend.
	 * @param string $formsRoot
	 * @param string $templatesRoot
	 * @param string $ajaxUrl
	 * @param array  $options
	 * @return Manager
	 */
	public static function instance($formsRoot, $templatesRoot, $ajaxUrl, $options = array()) {
		if (is_null(self::$manager)) {
			self::$manager                       = new Manager($formsRoot, $templatesRoot, $ajaxUrl, $options);
			$_SESSION['TransFormer\TransFormer'] = self::$manager;
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
	 * @param $formName
	 * @return mixed
	 */
	public static function render($formName, $template = 'default') {
		self::ensureManager();
		return self::$manager->render($formName, $template);
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
 