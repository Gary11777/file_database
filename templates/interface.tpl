<!DOCTYPE html>
<html lang="ru">
 <head>
  <title>{Label='site_name'}</title>
  <meta charset="utf-8" />
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/load.js"></script>
  <link rel="stylesheet" href="templates/style.css" />
 </head>
 <body>
 <div id="container">
  <div id="header_first">{Label='site_name'}</div>
  <div id="header_second">{ConstNote='user_name_in'} <span class="bold">{DynVar='user_name'}</span> | <a href="?logout=go"><b>{ConstNote='exit'}</b></a></div>
  <div id="leftColumn">
	<ul>{ConstNote='allowed_to_upload'}
		<li>{DynVar='extFile1'} - {DynVar='fileSize1'}</li>
		<li>{DynVar='extFile2'} - {DynVar='fileSize2'}</li>
		<li>{DynVar='extFile3'} - {DynVar='fileSize3'}</li>
	</ul>
	<ul>{ConstNote='used_of_storage'}
		<li>{DynVar='used_mb'} {DynVar='size_of_storage'}</li>
	</ul>
  </div>
  <div id="rightColumn">
	<ul>{ConstNote='statistic'}
		<li>{ConstNote='number_of_users'} {DynVar='number_of_users'}</li>
		<li>{ConstNote='number_of_files'} {DynVar='number_of_files'}</li>
		<li>{ConstNote='size_all_files'} {DynVar='size_all_files'}</li>
		<li>{ConstNote='size_to_users'} {DynVar='size_to_users'}</li>
	</ul>
  </div>
  <div id="main">
	<table class="tbl">
	 <tr id="point">
	  <th width="35%">{ConstNote='fileName'}</th>
	  <th width="15%">{ConstNote='fileSize'}</th>
	  <th width="35%">{ConstNote='dateUpload'}</th>
	  <th width="15%">{ConstNote='action'}</th>
	 </tr>
	  {FileLinks='FileLinks'}
	</table>
	<!-- +++ Jquery form-->
	<div class="form">
		<form method="post" enctype="multipart/form-data">
		<span class="bold">{ConstNote='upload_new_file'}</span> (Jquery)<br />
		<input type="file" name="f" /><br />
		<input type="submit" name="upload" class="submit_button" />
		</form>
	</div>
	<div class="ajax-respond"></div>
	<!-- --- Jquery form -->

	<div id="message">
	  {DynVar='message'}
	  <br />
	</div>
	<div><button class="delete">Удалить сгенерированную TR</button></div>
  </div>
  <div id="footer">{ConstNote='year'}</div>
 </div>
 </body>
</html>