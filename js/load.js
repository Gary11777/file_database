$(document).ready(function($){

// Глобальная переменная куда будут располагаться данные файлов. С ней будем работать
var files;

// Вешаем функцию на событие
// Получим данные файлов и добавим их в переменную
$('input[type=file]').change(function(){
	files = this.files;
});


// Вешаем функцию на событие click и отправляем AJAX запрос с данными файлов
$('.submit_button').click(function( event ){
	event.stopPropagation(); 
	event.preventDefault();  

	// Создадим данные формы и добавим в них данные файлов из files
	var data = new FormData();
	$.each( files, function( key, value ){
		data.append( key, value );
	});

	// Отправляем запрос
	$.ajax({
		url: './submit.php?uploadfiles',
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false, 
		contentType: false, 
		success: function( respond, textStatus, jqXHR ){

			if( typeof respond.error === 'undefined' ){

				var filename = new Array();
				file_data = respond.files;
				console.log(typeof(file_data));
				console.log(file_data);

				file_dir = file_data[1];
				file_name = file_data[2];
				file_size = file_data[3];
				file_date = file_data[4];
	
				
				$('<tr id="target"><td class="green"><a href="http://localhost/'+file_dir+'/'+ file_name +'">'+ file_name +'</a></td><td class="green">'+ file_size +'</td><td class="green">'+ file_date +'</td><td class="green"><button name='+ file_name +'  class="delete">Удалить</button></td></tr>').insertAfter('#point');
			}
			else{
				console.log('Ошибка ответа сервера: ' + respond.error );
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			console.log('Ошибка Ajax запроса: ' + textStatus );
		}
	});
	
});

// Меняем цвет при добавлении файла
setInterval(changeColor, 1500);
function changeColor()
{
	
	if ($('td').hasClass('green'))
		{
			$('td').removeClass('green');
			$('td').addClass('white');
			return;
		}
	
};

// Удаление файла
$('.delete').bind('click', function() {
	console.log('1');
    $.ajax({
		type: 'GET',
        url: './delfile.php?delete=true&name='+file_name,
        async: false,
        contentType: 'application/json',
        dataType: 'jsonp',
	    success: function(json) {
				//console.log(json);
				//$('#target').text(json.a);
			}
		});
		
	});

// Удаление строчки
$('.delete').click(function(){$('#target').remove();});

});