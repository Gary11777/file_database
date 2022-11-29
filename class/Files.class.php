<?php

declare(strict_types=1);

class Files
{
	public function getFileData() : array {
		
		$datafiles = array();
		
		if (isset($_SESSION['logged_user'])) {
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
							
					//for($i=0; $i<4; $i++) {
					$datafiles[] = strval($_SESSION['logged_user']['directory'] . '/' . $filen);
					$datafiles[] = strval($filen);
					$datafiles[] = strval($file_size);
					$datafiles[] = strval(date('j M Y H:i:s', filemtime($file_name)));
					//}
					return $datafiles;
					continue;
			}
			return $datafiles;
		} else {
			return $datafiles;
		}
	
	}
	
}