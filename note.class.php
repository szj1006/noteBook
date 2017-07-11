<?php
include 'config.php';
date_default_timezone_set('PRC');
class note{
   var $messageDir = 'nosql';
   var $dateFormat = 'Y-m-d H:i:s';
   var $itemsPerPage = 5;
   var $messageList;
   
function processGuestbook(){
   if (isset($_POST['submit'])) {
      $this->insertMessage();
   }
   $page = isset($_GET['page']) ? $_GET['page'] : 1;
   
   $this->displayGuestbook($page);
}
   
function getMessageList(){
	
   $this->messageList = array();
   
	if ($handle = @opendir($this->messageDir)) {
		while ($file = readdir($handle))  {
		    if (!is_dir($file)) {
		       $this->messageList[] = $file;
      	}
		}
	}	
	
	rsort($this->messageList);
	
	return $this->messageList;
}

function displayGuestbook($page=1){
      $list = $this->getMessageList();
      echo '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">查看区</h3></div><div class="panel-body"><div class="list-group">';
      $startItem = ($page-1)*$this->itemsPerPage;
      if (($startItem + $this->itemsPerPage) > sizeof($list)) $endItem = sizeof($list);
      else $endItem = $startItem + $this->itemsPerPage; 
      
      for ($i=$startItem;$i<$endItem;$i++){
        $value = $list[$i];
      	$data = file($this->messageDir.DIRECTORY_SEPARATOR.$value);
      	$name = trim($data[0]);
		$time = trim($data[1]);
         unset ($data['0']);
		 unset ($data['1']);
         $content = "";
         foreach ($data as $value) {
    	       $content .= $value;
         }
      	echo "<a href=\"#\" class=\"list-group-item\"><h4 class=\"list-group-item-heading\">[&nbsp;$name - $time&nbsp;]";
      	echo "</h4><p class=\"list-group-item-text\">".nl2br(htmlspecialchars($content))."</p></a>";
      }
      echo "</div></div></div>";
      if (sizeof($list) == 0){
         echo "<div class=\"alert alert-dismissable alert-info\">当前还木有任何东西呢！</div>";
      }
      if (sizeof($list) > $this->itemsPerPage){
         echo '<ul class="pager">';
         if ($startItem == 0) {
            if ($endItem < sizeof($list)){
               echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\" >旧的留言 &raquo;</a></li>";
            } else {
            }
         } else {
            if ($endItem < sizeof($list)){
               echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\" >&laquo; 新的留言</a></li>";
               echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\" >旧的留言 &raquo;</a></li>";
            } else {
               echo "<li><a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\" >&laquo; 新的留言</a></li>";
            }
         }
         
         echo "</ul>";
      }
      //$this->displayAddForm();
}

function displayAddForm(){
?>
<div class="panel panel-success">
   <div class="panel-heading">
	<h3 class="panel-title">发表区</h3>
   </div>
   <div class="panel-body">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<p><input type="text" class="form-control" name="name" placeholder="姓名"/></p>
	<p><textarea class="form-control" name="message" rows="7" placeholder="内容"></textarea></p>
	<p><input type="submit" class="btn btn-success btn-block" name="submit" value="提交" /></p>
	</form>
   </div>
</div>
<?php   
}
function insertMessage(){
   $name   = isset($_POST['name']) ? $_POST['name'] : 'Anonymous';
   $submitDate  = date($this->dateFormat);
   $content = isset($_POST['message']) ? $_POST['message'] : '';
   
   if (trim($name) == '') $name = 'Anonymous';
   if (strlen($content)<5) {
      exit();
   }
   
   $filename = date('YmdHis');
   if (!file_exists($this->messageDir)){
      mkdir($this->messageDir);
   }
   $f = fopen($this->messageDir.DIRECTORY_SEPARATOR.$filename.".txt","w+");         
   fwrite($f,$name."\n");
   fwrite($f,$submitDate."\n");
   fwrite($f,$content."\n");
   fclose($f);
   
}
}
?>