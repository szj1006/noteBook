<?php
include 'note.class.php';
$note = new note();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $site; ?></title>
<link rel="stylesheet" href="style/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
<?php
$note->processGuestbook();
if ($module == "note"){
if (@$_GET['pw'] == $pass){
$note->displayAddForm();
}else{
?>
<form method="get" action="index.php">
<div class="input-group">
<span class="input-group-addon">密码</span><input type="password" class="form-control" name="pw">
<span class="input-group-btn"><input type="submit" class="btn btn-default" value="登录"></span>
</div>
</form>
<?php
}}else{
$note->displayAddForm();
}
?>
<footer>
<p>
Made by <a href="https://sangsir.com">SangSir</a>, Version: V2.0, Based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>, <a href="admin.php" rel="nofollow">Login Admin</a>.
<img src="style/icon.gif" />
</p>
</footer>
</div>
</body>
</html>