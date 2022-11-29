<?php

declare(strict_types=1);

class Auth
{
		
	public function getUsersData(): array 
	{
		// Устанавливаем соединение
		try 
		{
			$pdo = new PDO('mysql:host=' . CONFIG_DB_HOST . '; dbname=' . CONFIG_DB_NAME . '; charset=' . CONFIG_DB_CHAR, 
			CONFIG_DB_USER, 
			CONFIG_DB_PASS, 
			array( PDO::ATTR_PERSISTENT => false));
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}	   
 

		// Подготавливаем и выполняем запрос
		$r = $pdo->prepare("SELECT `login`, `password`, `directory`, `limit_all` FROM `users`");
		$r->execute();
 
		// Обрабатываем результаты
		$number_of_user = 1;
		while ($user = $r->fetch(PDO::FETCH_ASSOC))
		{
			$users[$number_of_user] = $user;
			$users[$number_of_user]['extension'] = [];
			$number_of_user++;
		}
		--$number_of_user;

		// Цикл для добавления пользователям разрешенных расширений файлов
		for ($i = 1; $i <= $number_of_user; $i++) {
	
			// Подготавливаем и выполняем запрос
			$r = $pdo->prepare("SELECT `extension`, `limit` FROM `files` WHERE `login_id` = {$i} ");
			$r->execute();

			// +++++ Создаем массив с расширениями и лимитами для пользователя
			while ($file = $r->fetch(PDO::FETCH_ASSOC))
			{
				$files[] = $file;
			}
			for ($n = 0; $n < count($files); $n++) {
				foreach ($files[$n] as $k => $v) {
					$data_extension[] = $v;
				}
			}
			foreach ($data_extension as $v) {
				if (!is_numeric($v)) {
					$arr_ext[] = $v;
				}		
			}
			foreach ($data_extension as $v) {
				if (is_numeric($v)) {
					$arr_lim[] = $v;
				}
			}
			$arr_extension = array_combine($arr_ext, $arr_lim);
			// ----- Создаем массив с расширениями и лимитами для пользователя
	
	
			// +++++ Добавляем каждому пользователю его разрешения и лимиты
			$users[$i]['extension'] = $arr_extension;
			// ----- Добавляем каждому пользователю его разрешения и лимиты
	
		}
	
			// Закрываем соединение
			$r->closeCursor();
			$pbo = null;
	
		return $users;
	
	}

}