<?php
/**
 * Project: cDeep
 * User: fso
 * Date: 07.11.2014
 * Time: 18:26
 * Description: Autoloader inclusion.
 *              Classloader and preconfiguration only.
 */

defined('IS_WEB_ACTION') || define('IS_WEB_ACTION', array_key_exists('REQUEST_URI', $_SERVER));
defined('WEB_ROOT') || define('WEB_ROOT', realpath($_SERVER['DOCUMENT_ROOT']) . '/');

defined('ROOT') || define('ROOT', realpath(__DIR__ . '/../') . '/');
defined('APP_ROOT') || define('APP_ROOT', realpath(IS_WEB_ACTION ? (WEB_ROOT . '../') : ROOT) . '/');


if (file_exists(ROOT . 'vendor/autoload.php')) {
    require_once(ROOT . 'vendor/autoload.php');
}
if (file_exists(APP_ROOT . 'vendor/autoload.php')) {
    require_once(APP_ROOT . 'vendor/autoload.php');
}
require_once(ROOT . 'lib/Deep/Autoload.php');

$Autoload = new \Deep\Autoload([
    APP_ROOT . 'lib/',
    ROOT . 'lib/',
    'phar://' . ROOT . 'lib.phar/',
    'phar://' . APP_ROOT . 'lib.phar/',
]);

$Config = new \Deep\Autoconf([
    APP_ROOT . 'etc/',
    ROOT . 'etc/',
]);

$Autoload->addPostLoadHandler([$Config, 'configureObject']);
