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

$templater = new Templater();
$templater->putTemplate('initial', 'templates/initial.tpl');
$templater->putTemplate('interface', 'templates/interface.tpl');

$MySQL = new MySQL();
$Files = new Files();






$data = array();

if( isset( $_GET['uploadfiles'] ) ){
    
	$error = false;
    $files = array();
	$uploaddir = $_SESSION['logged_user']['user_home_dir'];
    
	// Перемещаем файлы из временной директории в указанную
	foreach( $_FILES as $file ){
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
			$getFileData = $Files->getFileData();
			//$files[] = realpath( $uploaddir . $file['name'] );
			$files[] = $getFileData[0];
			$files[] = $_SESSION['logged_user']['directory'];
			$files[] = $file['name'];
			$files[] = $getFileData[2];
			$files[] = $getFileData[3];
			
			
			
        }
        else{
            $error = true;
        }
    }
	
	
	
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
	
	echo json_encode( $data );
}
