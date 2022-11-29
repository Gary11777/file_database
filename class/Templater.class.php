<?php

declare(strict_types=1);

class Templater
{
	private $template = []; // Массив с шаблонами
	private $currentTemplateName = ''; // Имя текущего шаблона
	private $ScriptName = '';
	private $FileLinks = '';
	private $DynVar = [
				'user_name' => 'Имя_пользователя',	// Не успел доделать
				'used_mb' => '23 Мб',	// Не успел доделать
				'size_of_storage' => '100 Мб',	// Не успел доделать
				'number_of_users' => '123',	// Не успел доделать
				'number_of_files' => '1234',
				'size_all_files' => '1245,23 Мб',	// Не успел доделать
				'size_to_users' => '10,12 Мб',	// Не успел доделать
				'fileName' => 'archive.zip',	// Не успел доделать
				'fileSize' => '5 Мб',	// Не успел доделать
				'dateUpload' => '05.09.2019',	// Не успел доделать
				'message' => '',	// Не успел доделать
				'extFile1' => 'txt',	// Не успел доделать
				'fileSize1' => '20 Мб',	// Не успел доделать
				'extFile2' => 'php',	// Не успел доделать
				'fileSize2' => '30 Мб',	// Не успел доделать
				'extFile3' => 'jpg',	// Не успел доделать
				'fileSize3' => '50 Мб',	// Не успел доделать
				];
	private $Label = [];
	private $ConstNote = [];
	private $Code = [];
	private $Button = [];
	
	// Записываем имя и тело шаблона в массив с шаблонами
	public function putTemplate (string $TemplateName, string $FileTemplateName) : void
	{
		$this->template[$TemplateName] = file_get_contents($FileTemplateName);
	}
	
	// Записываем код для form
	public function putScriptName(string $script_name) : void
	{
		$this->ScriptName = "action=\"{$script_name}\"";
	}
	
	public function putFileLinks(string $directory, string $filen, int $file_size, string $date_of_file) : void
	{
		$this->FileLinks .= "<tr>
		<td><a href=\" {$directory}/{$filen}\">{$filen}</a></td>
		<td>{$file_size}</td>
		<td>{$date_of_file}</td>
		<td><a href=\"?delete=true&name={$filen}\">Удалить</a></td>
		</tr>";
	}
	
	// Записываем данные для Button
	public function putDynVar(array $arr) : void
    {
        $key = key($arr);
        $value = current($arr);
        $this->DynVar[$key] = $value;
    }
	
	// Записываем данные для Button
	public function putButton(array $arr) : void
    {
        $key = key($arr);
        $value = current($arr);
        $this->Button[$key] = "value=\"{$value}\"";
    }
	
	// Записываем данные для Label
	public function putLabel(array $arr) : void
    {
        $key = key($arr);
        $value = current($arr);
        $this->Label[$key] = $value;
    }
	
	// Записываем данные для ConstNote
	public function putConstNote(array $arr) : void
    {
        $key = key($arr);
        $value = current($arr);
        $this->ConstNote[$key] = $value;
    }
	
	
	// Функция-обработчик шаблона
	public function handlerTemplate(string $ArrTemplateName) : void
    {
        $this->currentTemplateName = $ArrTemplateName;
		while (preg_match("/{DynVar=\'(\w+)\'}/u", $this->template[$ArrTemplateName]) ||
               preg_match("/{Label=\'(\w+)\'}/u", $this->template[$ArrTemplateName]) ||
               preg_match("/{ConstNote=\'(\w+)\'}/u", $this->template[$ArrTemplateName]) ||
			   preg_match("/{ScriptName=\'(\w+)\'}/u", $this->template[$ArrTemplateName]) ||
			   preg_match("/{Button=\'(\w+)\'}/u", $this->template[$ArrTemplateName]) ||
			   preg_match("/{FileLinks=\'(\w+)\'}/u", $this->template[$ArrTemplateName])) {
                
				$this->template[$ArrTemplateName] = preg_replace_callback("/{DynVar=\'(\w+)\'}/u", [$this, 'callbackDynVar'], $this->template[$ArrTemplateName]);
        
                $this->template[$ArrTemplateName] = preg_replace_callback("/{Label=\'(\w+)\'}/u", [$this, 'callbackLabel'], $this->template[$ArrTemplateName]);
        
                $this->template[$ArrTemplateName] = preg_replace_callback("/{ConstNote=\'(\w+)\'}/u", [$this, 'callbackConstNote'], $this->template[$ArrTemplateName]);
				
				$this->template[$ArrTemplateName] = preg_replace_callback("/{Button=\'(\w+)\'}/u", [$this, 'callbackButton'], $this->template[$ArrTemplateName]);
				
				$this->template[$ArrTemplateName] = preg_replace("/{FileLinks=\'(\w+)\'}/u", $this->FileLinks, $this->template[$ArrTemplateName]);
				
				$this->template[$ArrTemplateName] = preg_replace("/{ScriptName=\'(\w+)\'}/u", $this->ScriptName, $this->template[$ArrTemplateName]);
               }    
    }
	
	
	// callback-функция для DynVar
	private function callbackDynVar($matches) : string
	{
		$ArrDynVarName = $matches[1];
		if (isset($this->DynVar[$ArrDynVarName])) {
		return $this->DynVar[$ArrDynVarName];
		} else {
            throw new Exception('No dynamic var [' . $ArrDynVarName . '] detected!');
        }
        return '';
	}
	
	// callback-функция для Label
	private function callbackLabel($matches) : string
	{
		$ArrLabelName = $matches[1];
		return $this->Label[$ArrLabelName];
	}
	
	// callback-функция для ConstNote
	private function callbackConstNote($matches) : string
	{
		$ArrConstNote = $matches[1];
		return $this->ConstNote[$ArrConstNote];
	}
	
		// callback-функция для Button
	private function callbackButton($matches) : string
	{
		$ArrButton = $matches[1];
		return $this->Button[$ArrButton];
	}
	
	// callback-функция для Code
	//private function callbackCode($matches) : string
	//{
	//	$ArrCodeNote = $matches[1];
	//	return $this->Code[$ArrCodeNote];
	//}
	
	// Возвращаем обработанный шаблон
	public function viewTemplate() : string
	{
		return $this->template[$this->currentTemplateName];
	}
}