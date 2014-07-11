<?php

/**
 * Class Yii
 */
class Yii extends YiiBase {
	/**
	 * @return YiiApplication
	 */
	static function app() {

	}
}

/**
 * CApplication is the base class for all application classes.
 *
 * An application serves as the global context that the user request
 * is being processed. It manages a set of application components that
 * provide specific functionalities to the whole application.
 *
 * The core application components provided by CApplication are the following:
 * <ul>
 * <li>{@link getErrorHandler errorHandler}: handles PHP errors and
 *   uncaught exceptions. This application component is dynamically loaded when needed.</li>
 * <li>{@link getSecurityManager securityManager}: provides security-related
 *   services, such as hashing, encryption. This application component is dynamically
 *   loaded when needed.</li>
 * <li>{@link getStatePersister statePersister}: provides global state
 *   persistence method. This application component is dynamically loaded when needed.</li>
 * <li>{@link getCache cache}: provides caching feature. This application component is
 *   disabled by default.</li>
 * <li>{@link getMessages messages}: provides the message source for translating
 *   application messages. This application component is dynamically loaded when needed.</li>
 * <li>{@link getCoreMessages coreMessages}: provides the message source for translating
 *   Yii framework messages. This application component is dynamically loaded when needed.</li>
 * <li>{@link getUrlManager urlManager}: provides URL construction as well as parsing functionality.
 *   This application component is dynamically loaded when needed.</li>
 * <li>{@link getRequest request}: represents the current HTTP request by encapsulating
 *   the $_SERVER variable and managing cookies sent from and sent to the user.
 *   This application component is dynamically loaded when needed.</li>
 * <li>{@link getFormat format}: provides a set of commonly used data formatting methods.
 *   This application component is dynamically loaded when needed.</li>
 * </ul>
 *
 * CApplication will undergo the following lifecycles when processing a user request:
 * <ol>
 * <li>load application configuration;</li>
 * <li>set up class autoloader and error handling;</li>
 * <li>load static application components;</li>
 * <li>{@link onBeginRequest}: preprocess the user request;</li>
 * <li>{@link processRequest}: process the user request;</li>
 * <li>{@link onEndRequest}: postprocess the user request;</li>
 * </ol>
 *
 * Starting from lifecycle 3, if a PHP error or an uncaught exception occurs,
 * the application will switch to its error handling logic and jump to step 6 afterwards.
 *
 * @property string $id The unique identifier for the application.
 * @property string $basePath The root directory of the application. Defaults to 'protected'.
 * @property string $runtimePath The directory that stores runtime files. Defaults to 'protected/runtime'.
 * @property string $extensionPath The directory that contains all extensions. Defaults to the 'extensions' directory under 'protected'.
 * @property string $language The language that the user is using and the application should be targeted to.
 * Defaults to the {@link sourceLanguage source language}.
 * @property string $timeZone The time zone used by this application.
 * @property CLocale $locale The locale instance.
 * @property string $localeDataPath The directory that contains the locale data. It defaults to 'framework/i18n/data'.
 * @property CNumberFormatter $numberFormatter The locale-dependent number formatter.
 * The current {@link getLocale application locale} will be used.
 * @property CDateFormatter $dateFormatter The locale-dependent date formatter.
 * The current {@link getLocale application locale} will be used.
 * @property CErrorHandler $errorHandler The error handler application component.
 * @property CSecurityManager $securityManager The security manager application component.
 * @property CPhpMessageSource $coreMessages The core message translations.
 * @property CMessageSource $messages The application message translations.
 * @property CUrlManager $urlManager The URL manager component.
 * @property CController $controller The currently active controller. Null is returned in this base class.
 * @property string $prize$baseUrl The relative URL for the application.
 * @property string $homeUrl The homepage URL.
 *
 * @property CWebUser $user User Compoent
 * @property CHttpSession $session
 * @property CClientScript $clientScript
 * @property CHttpRequest $request

 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.base
 * @since 1.0
 */
class YiiApplication extends CApplication {

	/**
	 * Processes the request.
	 * This is the place where the actual request processing work is done.
	 * Derived classes should override this method.
	 */
	public function processRequest()
	{
	}
}
