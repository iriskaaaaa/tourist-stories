<?php
session_start();
 define('tourist-stories',true);
    include('include/db_connect1.php');
if ($_SESSION['auth_admin'] == "yes_auth")
{
   
    mysql_query("SET NAMES 'utf8'");
    mysql_query("SET CHARACTER SET 'utf8'");
       
       if (isset($_GET["logout"]))
    {
        unset($_SESSION['auth_admin']);
        header("Location: login.php");
    }

  $_SESSION['urlpage'] = "<a href='index.php' >Главная</a> \ <a href='reviews.php' >Истории</a>";
  
  include("include/functions.php"); 
   
    $id_story = clear_string($_GET["id_story"]);   
    $sort = $_GET["sort"];
	
   switch ($sort) {

	    case 'accept':

	    $sort = "moderat='1' DESC";
        $sort_name = 'Проверенные';

	    break;

	    case 'no-accept':

	    $sort = "moderat='0' DESC";
        $sort_name = 'Не проверенные';

	    break;
        
	    default:
        
        $sort = "id_reviews DESC";
        $sort_name = 'Без сортировки';
        
	    break;

	} 
    
               
$action = $_GET["action"];
if (isset($action))
{

   switch ($action) {

	    case 'accept':
        $update = mysql_query("UPDATE story SET moderat='1' WHERE id_story = '$id_story'",$link);  
    
   
   		   
	    break;
     
        case 'delete':
  

        $delete = mysql_query("DELETE FROM reviews WHERE id_reviews = '$id'",$link);      
       
  
	    break;
        
	} 
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta http-equiv="content-type" content="text/html; />
    <link href="css/reset.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
    <script type="text/javascript" src="js/script.js"></script> 
    <script type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script> 
    
	<title>Панель Управления - Отзывы</title>
</head>
<body>
<div id="block-body">
<?php
	include("include/block-header.php");

?>
<div id="block-content">
<div id="block-parameters">
</div>
<div id="block-info">
<p>Модерация истории</p>
</div>
<?php
if (isset($msgerror)) echo '<p id="form-error" align="center">'.$msgerror.'</p>';

$result = mysql_query("SELECT * FROM story, user wHERE story.id_user=user.id_user and story.id_story=$id_story",$link);
 
 If (mysql_num_rows($result) > 0)
{
$row = mysql_fetch_array($result);
do
{
    if  (strlen($row["img"]) > 0 && file_exists("../upload/".$row["img"]))
{
$img_path = "../upload/".$row["img"];
$max_width = 350; 
$max_height = 350; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
// New dimensions 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "../upload/no_image.jpg";
$width = 182;
$height = 182;
}

if ($row["moderat"] == '0'){ $link_accept = '<a class="green" href="moderat.php?id_mstory='.$row["id_story"].'&moderat=1" >Опубликовать</a> | ';  } else { $link_accept = '';  }
    
 echo '
 <div class="block-reviews">
 <div class="block-title-img">
 <p>'.$row["name_story"].'</p>
 <center>
 <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
 </center>
 </div> 
<p class="author-date"><strong>'.$row["username"].'</strong>, '.$row["date"].'</p>
<p class="reviews-comment" >'.nl2br($row["text_story"]).'</p>          
 <p class="links-actions" align="right" >'.$link_accept.'<a class="delete" href="moderat.php?id_mstory='.$row["id_story"].'&moderat=2" >Отклонить</a> </p>
 </div>
 ';   
    
} while ($row = mysql_fetch_array($result));
}   
   

    	    
?>
</div>
</div>
</body>
</html>
<?php
}else
{
    header("Location: login.php");
}
?>