<?php
include 'note.class.php';
if (@$_GET['pw'] != $pass){
header("Content-type:text/html;charset=utf-8");
echo '<title>后台管理</title>';
echo '<form method="get" action="admin.php">';
echo '密码:<input type="password" name="pw">';
echo '<input type="submit" value="提交">';
echo '</form>';
exit;
}
$note = new note();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>后台管理</title>
<link rel="stylesheet" href="style/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container">
 <div class="panel panel-primary">
  <div class="panel-heading"><h3 class="panel-title">设置区</h3></div>
   <div class="panel-body">
    <div class="alert alert-dismissable alert-info">
    <p>Tips：本站既可作为留言板，也可作为日记本哦！</p>
    </div>
	<form method="post" action="admin.php?pw=<?php echo $pass; ?>">
	<div class="input-group">
		<span class="input-group-addon">网站名称</span>
		<?php echo '<input type="text" class="form-control" name="site" value="'.$site.'">'; ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon">管理密码</span>
		<?php echo '<input type="text" class="form-control" name="pass" value="'.$pass.'">'; ?>
	</div>
	<div class="input-group">
		<span class="input-group-addon">类型设置</span>
		<span align="center">
		<p><input type="radio" name="module" value="note" <?php if($module == 'note') echo 'checked=""'; ?>>【日记本】 - 发表区会设置上密码(密码为管理员密码)</p>
		<p><input type="radio" name="module" value="message" <?php if($module == 'message') echo 'checked=""'; ?>>【留言板】 - 任意用户均可在发表区留言(无密码设置)</p>
		</span>
	</div>
	<input type="submit" class="btn btn-default btn-block" name="set" value="提交">
	</form>
<?php
if(isset($_POST['set'])){
$txt="<?
\$site = \"$_POST[site]\"; //网站名称
\$pass = \"$_POST[pass]\"; //管理密码
\$module = \"$_POST[module]\"; //网站类型
?>";
$fp=fopen('config.php','w');
flock($fp,LOCK_EX);
$write=fputs($fp,$txt);
flock($fp,LOCK_UN);
fclose($fp);
if($write){
header("location: admin.php?pw=$pass");
}else{
echo '<center><p>保存配置失败，请开启0777权限！</p></center>';
}}
?>
  </div>
 </div>
<div class="panel panel-success">
<div class="panel-heading"><h3 class="panel-title">管理区</h3></div>
<div class="panel-body">
<div class="alert alert-dismissable alert-info">
<p>Tips：请对应留言时间来选择文件进行删除，一旦删除，不可恢复！</p>
</div>
<?php
$list = $note->getMessageList();
foreach ($list as $value){
echo '<p>'.$value.'<a href="admin.php?pw='.$pass.'&del='.$value.'">【删除】</a></p>';
}
unset($value);
if (isset($_GET['del'])){
unlink($note->messageDir."/".$_GET['del']);
header("location: admin.php?pw=$pass");
}
?>
</div>
</div>
<footer>
<p>
Made by <a href="https://sangsir.com">SangSir</a>, Version: V2.0, Based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>, <a href="index.php" rel="nofollow">Go Back</a>.
<img src="style/icon.gif" />
</p>
</footer>
</div>
</body>
</html>