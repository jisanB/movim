<?php

// A few constants...
define('BASE_PATH', dirname(__FILE__) . '/');
define('APP_NAME', 'movim');
define('LIB_PATH', BASE_PATH.'system/');
define('PROPERTIES_PATH', BASE_PATH.'page/properties/');
define('THEMES_PATH', BASE_PATH . 'themes/');
define('USERS_PATH', BASE_PATH . 'user/');

define('DB_DEBUG', true);
define('DB_LOGFILE', BASE_PATH . 'log/queries.log');

// Loads up all system libraries.
require(LIB_PATH . "Lang/i18n.php");

require(LIB_PATH . "Storage/loader.php");
load_storage(array('sqlite'));

require(LIB_PATH . "Session.php");
require(LIB_PATH . "Utils.php");
require(LIB_PATH . "Cache.php");
require(LIB_PATH . "Conf.php");
require(LIB_PATH . "Event.php");
require(LIB_PATH . "Jabber.php");
require(LIB_PATH . "Logger.php");
require(LIB_PATH . "MovimException.php");
require(LIB_PATH . "RPC.php");
require(LIB_PATH . "User.php");

require(LIB_PATH . "Contact.php");
require(LIB_PATH . "Presence.php");
require(LIB_PATH . "Message.php");

require(LIB_PATH . "Controller/ControllerBase.php");
require(LIB_PATH . "Controller/ControllerMain.php");
require(LIB_PATH . "Controller/ControllerAjax.php");

require(LIB_PATH . "Tpl/TplPageBuilder.php");

require(LIB_PATH . "Widget/WidgetBase.php");
require(LIB_PATH . "Widget/WidgetWrapper.php");

// User agent detection

$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
} elseif (preg_match('/Opera[\/ ]([0-9]{1}\.[0-9]{1}([0-9])?)/',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Opera';
} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Firefox';
} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Safari';
} else {
    $browser_version = 0;
    $browser= 'other';
}

define('BROWSER_VERSION', $browser_version);
define('BROWSER', $browser);

$compatible = false;

switch($browser) {
    case 'Firefox':
        if($browser_version > 3.5)
            $compatible = true;
    break;
    case 'IE':
        if($browser_version > 8.0)
            $compatible = true;
    break;
    case 'Safari': // Also Chrome-Chromium
        if($browser_version > 522.0)
            $compatible = true;
    break;
    case 'Opera':
        if($browser_version > 9.0)
            $compatible = true;
    break;
}

define('BROWSER_COMP', $compatible);

// Starting session.
storage_load_driver(Conf::getServerConfElement('storageDriver'));
StorageEngineWrapper::setdriver(Conf::getServerConfElement('storageDriver'));
Session::start(APP_NAME);

$sdb = new StorageEngineWrapper(Conf::getServerConfElement('storageConnection'));

?>
