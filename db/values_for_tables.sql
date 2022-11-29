INSERT INTO `files`
			(`login_id`, `extension`, `limit`)
VALUES		('1', 'txt', '20'),
			('1', 'php', '30'),
			('1', 'jpg', '50'),
			('2', 'txt', '5'),
			('2', 'php', '10'),
			('2', 'jpg', '15');

INSERT INTO `users`
			(`login`, `password`, `directory`, `limit_all`)
VALUES		('name1', '123', 'user1', 100),
			('name2', '456', 'user2', 100);

INSERT INTO `label`
			(`l_key`, `l_value`)
VALUES		('site_name', 'База файлов');
			
INSERT INTO `const`
			(`c_key`, `c_value`)
VALUES		('statistic', 'Статистика'),
			('login', 'Имя'),
			('password', 'Пароль'),
			('year', '2022'),
			('user_name_stat', 'Вам необходимо войти в систему'),
			('exit', 'Выйти'),
			('user_name_in', 'Вы находитесь в системе как '),
			('allowed_to_upload', 'Можно загружать:'),
			('used_of_storage', 'Использовано:'),
			('number_of_users', 'Пользователей: '),
			('number_of_files', 'Файлов: '),
			('size_all_files', 'Объем'),
			('size_to_users', 'Объем/польз.: '),
			('fileName', 'Имя файла'),
			('fileSize', 'Размер (Кб)'),
			('dateUpload', 'Дата'),
			('action', 'Действие'),
			('upload_new_file', 'Загрузить новый файл: ');

INSERT INTO `button`
			(`b_key`, `b_value`)
VALUES		('enter', 'Войти'),
			('chose_file', 'Выбрать файл'),
			('upload', 'Загрузить');