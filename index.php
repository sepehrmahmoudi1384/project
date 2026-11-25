<?php

use Admin\Admin;

session_start();

//
// config
define('BASE_PATH', __DIR__);
define('BASE_URL', currentDomain() . '/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', "utf8mb4");
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// 
// class include
require_once 'database/Database.php';
require_once 'database/CreateDB.php';
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Category.php';
require_once 'activities/Admin/Post.php';
require_once 'activities/Admin/Banner.php';

//
// Create tables (run it once)
// $creator = new \database\CreateDB;
// $creator->run();

// display errors
displayError(DISPLAY_ERROR);

//
// helpers

function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https')
        ? 'https://'
        : 'http://';
}

function currentDomain()
{
    return protocol() . $_SERVER['HTTP_HOST'];
}

function dd(mixed $data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}

function asset(string $src)
{
    $domain = rtrim(BASE_URL, '/ ');
    $src = trim($src, '/ ');
    return $domain . '/' . $src;
}

function url(string $url)
{
    $domain = rtrim(BASE_URL, '/ ');
    $url = trim($url, '/ ');
    return $domain . '/' . $url;
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function requestMethod()
{
    return $_SERVER['REQUEST_METHOD'];
}

function displayError(bool $display)
{
    if ($display) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}

const FLASH = 'flash_message';
global $flashMessage;
if (isset($_SESSION[FLASH])) {
    $flashMessage = $_SESSION[FLASH];
    unset($_SESSION[FLASH]);
}

function flash(string $name, ?string $message = null)
{
    if ($message === null) {
        global $flashMessage;
        return isset($flashMessage[$name])
            ? $flashMessage[$name]
            : '';
    } else {
        $_SESSION[FLASH][$name] = $message;
    }
}

function uri(
    string $reservedUrl,
    string $class,
    string $method,
    string $requestMethod = 'GET'
) {
    if (requestMethod() !== $requestMethod)
        return;

    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(BASE_URL, '', $currentUrl);
    $currentUrl = trim($currentUrl, '/');


    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);
    $currentUrlArray = array_values($currentUrlArray);

    $reservedUrl = trim($reservedUrl, '/');

    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);
    $reservedUrlArray = array_values($reservedUrlArray);


    if (
        count($currentUrlArray) !== count($reservedUrlArray)
    ) {
        return;
    }

    $parameters = [];
    for ($i = 0; $i < count($reservedUrlArray); $i++) {
        if (preg_match('/{(.+)}/i', $reservedUrlArray[$i])) {
            $parameters[] = $currentUrlArray[$i];
        } elseif ($reservedUrlArray[$i] !== $currentUrlArray[$i]) {
            return;
        }
    }

    if ($requestMethod === 'POST') {
        $request = isset($_FILES)
            ? array_merge($_POST, $_FILES)
            : $_POST;

        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;
    call_user_func_array([$object, $method], $parameters);
    die;
}

//
// reserve addresses

// category
uri('admin/category', 'Admin\Category', 'index');
uri('admin/category/create', 'Admin\Category', 'create');
uri('admin/category/store', 'Admin\Category', 'store', 'POST');
uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
uri('admin/category/delete/{id}', 'Admin\Category', 'delete');

// post
uri('admin/post', 'Admin\Post', 'index');
uri('admin/post/create', 'Admin\Post', 'create');
uri('admin/post/store', 'Admin\Post', 'store', 'POST');
uri('admin/post/edit/{id}', 'Admin\Post', 'edit');
uri('admin/post/update/{id}', 'Admin\Post', 'update', 'POST');
uri('admin/post/delete/{id}', 'Admin\Post', 'delete');
uri('admin/post/selected/{id}', 'Admin\Post', 'selected');
uri('admin/post/breaking-news/{id}', 'Admin\Post', 'breakingNews');

// banner
uri('admin/banner', 'Admin\Banner', 'index');
uri('admin/banner/create', 'Admin\Banner', 'create');
uri('admin/banner/store', 'Admin\Banner', 'store', 'POST');
uri('admin/banner/edit/{id}', 'Admin\Banner', 'edit');
uri('admin/banner/update/{id}', 'Admin\Banner', 'update', 'POST');
uri('admin/banner/delete/{id}', 'Admin\Banner', 'delete');


// show 404 if no url match
echo '404 - Not Found'; 
