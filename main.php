<?php

declare(strict_types=1);

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

function log_pas(object $MySQL, object $templater, string $login_error = ''): void
{
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++
		//+++++ Инициализация шаблона для ввода логина и пароля
		$cashLabel = $MySQL->getLabelData();	// Записываем данные из БД по Label в массив
		// Передаем данные в шаблонизатор
		foreach($cashLabel as $k => $v) {
			$templater->putLabel([$k => $v]);
		}
		
		$cashConst = $MySQL->getConstData();	// Записываем данные из БД по ConstNote в массив
		// Передаем данные в шаблонизатор
		foreach($cashConst as $k => $v) {
			$templater->putConstNote([$k => $v]);
		}
		
		$cashButton = $MySQL->getButtonData();	// Записываем данные из БД по Button в массив
		// Передаем данные в шаблонизатор
		foreach($cashButton as $k => $v) {
			$templater->putButton([$k => $v]);
		}
		
		$templater->putDynVar(['message' => $login_error]);
		
		$templater->putScriptName($_SERVER['PHP_SELF']);	// Передаем в шаблонизатор имя скрипта
		
		$templater->handlerTemplate("initial");	// Передаем шаблонизатору имя шаблона, которое нужно использовать
		//----- Инициализация шаблона для ввода логина и пароля
		//-----------------------------------------------------

}

//+++++++ Функция для показа пользователю домашнего каталога
function user_interface(object $MySQL, object $templater, string $login_error = '', object $Files): void
{
			
			$all_size = 0;
			$uploads_dir = opendir($_SESSION['logged_user']['user_home_dir']);
			
			while (FALSE !== ($filen = readdir($uploads_dir))) {
		
				$file_name = $_SESSION['logged_user']['user_home_dir'] . $filen;
		
				if (!is_file($file_name)) {
					continue;
				}
		
				$file_size = filesize($file_name);
				$all_size += $file_size;
				
				$date_of_file = date('j M Y H:i:s', filemtime($file_name));
				
				$templater->putFileLinks($_SESSION['logged_user']['directory'], $filen, $file_size, $date_of_file);
			}
			 
			$_SESSION['logged_user']['user_home_dir_real_size'] = $all_size;
			
			$cashLabel = $MySQL->getLabelData();	// Записываем данные из БД по Label в массив
			// Передаем данные в шаблонизатор
			foreach($cashLabel as $k => $v) {
				$templater->putLabel([$k => $v]);
			}
			$cashConst = $MySQL->getConstData();	// Записываем данные из БД по ConstNote в массив
			// Передаем данные в шаблонизатор
			foreach($cashConst as $k => $v) {
				$templater->putConstNote([$k => $v]);
			}
		
			$cashButton = $MySQL->getButtonData();	// Записываем данные из БД по Button в массив
			// Передаем данные в шаблонизатор
			foreach($cashButton as $k => $v) {
				$templater->putButton([$k => $v]);
			}
			
			//$templater->putDynVar(['user_name' => $_POST['login']]);
			
			$templater->putDynVar(['message' => $login_error]);
			
			$templater->putScriptName($_SERVER['PHP_SELF']);	// Передаем в шаблонизатор имя скрипта
			
			$templater->handlerTemplate("interface");	// Передаем шаблонизатору имя шаблона, которое нужно использовать
			
			//$getFileData = $Files->getFileData(); // Данные по файлам в папке пользователя в массиве в строковых типах
}
//------- Функция для показа пользователю домашнего каталога



// Для выхода из учетной записи
if ((isset($_GET['logout'])) && ($_GET['logout'] == 'go')) {
    session_destroy();
    unset($_SESSION['logged_user']);
}

// Проверяем залогинен ли пользователь
if (isset($_SESSION['logged_user'])) {

    // Если залогинен, проверяем хочет ли удалить файл
    if ((isset($_GET['delete'])) && ($_GET['delete'] == 'true')) {
        $file_name = $_SESSION['logged_user']['user_home_dir'] . $_GET['name'];
        if (is_file($file_name)) {
            unlink($file_name);
            $login_error = '<br /><br /><font color="#cd0000">Файл удален!</font><br /><br />';
        }
    }

    // Для загрузки файла
	$login_error = '';
    if (isset($_FILES['f']) && ($_FILES['f']['error'] == 0)) {
        $file_name = $_SESSION['logged_user']['user_home_dir'] . $_FILES['f']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
		
		if (isset($_SESSION['logged_user']['extension'][$ext])) {
            
			if ($_SESSION['logged_user']['extension'][$ext] * 1048576 >= $_FILES['f']['size']) {
                
				if (round(($_SESSION['logged_user']['user_home_dir_real_size'] + $_FILES['f']['size']) / 1048576, 2) <= $_SESSION['logged_user']['limit_all']) {
                    move_uploaded_file($_FILES['f']['tmp_name'], $file_name);
                    $login_error = '<br /><br /><font color="#cd0000">Файл загружен!</font><br /><br />';
                } else {
                    $login_error = '<br /><br /><font color="#cd0000">Файл не загружен, т.к. превышен общий лимит.</font><br /><br />';
                }
				
            } else {
                $login_error = '<br /><br /><font color="#cd0000">Файл не загружен, т.к. превышен размер файла.</font><br /><br />';
            }
			
        } else {
            $login_error = '<br /><br /><font color="#cd0000">Файл не загружен. Недопустимое расширение.</font><br /><br />';
        }
    }
	user_interface($MySQL, $templater, $login_error, $Files);
	
} else {	// Если пользователь не залогинен
    if ((isset($_POST['login'])) && (isset($_POST['password']))) {
        $login_error = '<br /><br /><font color="#cd0000">Неверное имя или пароль!</font>';
        foreach ($users as $user) {
            if (($user['login'] === $_POST['login']) && ($user['password'] === $_POST['password'])) {
                $user_home_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $user['directory'] . '/';
                if (!is_dir($user_home_dir)) {
                    $login_error = '<br /><br /><font color="#cd0000">Для данного пользователя не существует папки.</font><br /><br />';
                } else {
                    $_SESSION['logged_user'] = $user;
                    $_SESSION['logged_user']['user_home_dir'] = $user_home_dir;
                    $login_error = '';
                }
                break;
            }
        }
        if ($login_error !== '') {
            log_pas($MySQL, $templater, $login_error);
		

		
        } else {
            user_interface($MySQL, $templater, $login_error, $Files);

        }
    } else {
		log_pas($MySQL, $templater);
		

    }
}

/*
echo "<pre>";
print_r($Files->getFileData());
echo "</pre>";
*/