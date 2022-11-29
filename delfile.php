<?php


declare(strict_types=1);

error_reporting(0);
session_start();

require_once("config.php");
require_once("class/Auth.class.php");
require_once("class/Templater.class.php");
require_once("class/MySQL.class.php");
require_once("class/Files.class.php");

$auth_object = new Auth();

$users = $auth_object->getUsersData();

$MySQL = new MySQL();
$Files = new Files();


if ((isset($_GET['delete'])) && ($_GET['delete'] == 'true')) {
        $file_name = $_SESSION['logged_user']['user_home_dir'] . $_GET['name'];
        if (is_file($file_name)) {
            unlink($file_name);
            $login_error = '<br /><br /><font color="#cd0000">Файл удален!</font><br /><br />';
        }
    }