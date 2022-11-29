<!DOCTYPE html>
<html lang="ru">
 <head>
  <title>{Label='site_name'}</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="templates/style.css" />
 </head>
 <body>
 <div id="container">
  <div id="header_first">{Label='site_name'}</div>
  <div id="header_second">{ConstNote='user_name_stat'}</div>
  <div id="leftColumn"></div>
  <div id="rightColumn">{ConstNote='statistic'}</div>
  <div id="main">
	<div id="login_form">
		<div id="first">
			{ConstNote='login'}:<br />
			{ConstNote='password'}:
		</div>
		<div id="second">
			<form {ScriptName='action_script_name'} method="post">
			<input type="text" name="login" value="" /><br />
			<input type="password" name="password" /><br />
			<input type="submit" name="go" {Button='enter'} /> 
			</form>
		</div>
	</div>
	<div id="message">
	  {DynVar='message'}
	</div>
  </div>
  <div id="footer">&copy; {ConstNote='year'}</div>
 </div>
 </body>
</html>