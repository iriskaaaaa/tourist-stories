<?php
// ����� ��������� � ������� � ��������� ��������
header('Content-Type: text/html; charset=utf-8');
// ��������� ������
setlocale(LC_ALL, 'ru_RU.65001', 'rus_RUS.65001', 'Russian_Russia. 65001', 'russian');
// ��������� ����������� � ���� ������
//mysql_query('SET names "utf8"');

session_start();
define('tourist_stories_db',true);
if($_SESSION['session_username']){
    $id = ($_GET["id_user"]);
	if(isset($_GET["logout"]))
    {
       unset($_SESSION['session_username']);;//���������� ������
       header("Location:index.php");
	}

    }
include ("/include/db_connect.php");
include ("/include/functions.php"); 
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
$sorting=$_GET["sort"];
switch($sorting){
        case 'popular-acs';
        $sorting='count_like ASC';
        break;
        
        case 'popular-desc';
        $sorting='count_like DESC';
        break;
        
        case 'date-acs';
        $sorting='date ASC';
        break;
        
        case 'date-desc';
        $sorting='date DESC';
        break;
        
        default:
        $sorting_city='id_city DESC'
        $sorting='id_story DESC';
        break;
    } 

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8" />

	<title>Tourist Stories</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css"/>

	<link rel="stylesheet" href="css/style1style.css" />
	<link rel="stylesheet" href="css/media.css" />
	<link rel="stylesheet" href="css/fonts.css" />
    <script type="text/javascript" src="js/shop-script.js"></script>

</head>

<body>

 <header>
 	<nav>
 		<div class="container">
 			<div class="row">
 				<div class="navbar-header ">
 					<button class="navbar-toggle collapsed menu_btn" data-toggle="collapse" data-target="#top_menu">
 						<span class="glyphicon glyphicon-menu-hamburger">	</span>	
 					</button>

 					<a href="index.html">
 						<img src="" alt=""/>
 					</a>
 				</div>
                <div class="collapse navbar-collapse navbar-right" id="top_menu">
<?php

                if($_SESSION['session_username'] && $_SESSION['session_id_user'])
               {
                $id = $_SESSION['session_id_user'];
                $result=mysql_query("SELECT * FROM user WHERE id_user = $id",$link);
                $row=mysql_fetch_array($result);
                   echo '<ul class="menu">
 						<li><a href="index.php">�������</a></li>
 						<li><a href="#">��������</a></li>
 						<li><a href="profile.php?id_user='.$row['id_user'].'">������ �������</a></li>
                        <li><a href="?logout">�����</a></li>
 				  	</ul>'; }
else{
 
  echo '<ul class="menu">
 						<li><a href="index.php">�������</a></li>
 						<li><a href="#">��������</a></li>
 						<li><a href="login.php">�����</a></li>
 					</ul>';   
    
}	
?>
     </div>           
 			</div>

 			<!-- <div class="top_line">
 				
 			</div> -->
 		</div>
 	</nav>

 	<div class="container">
 		<div class="row">
 			<div class="coll-md-8 coll-offset-2">
 				<div class="tittle_block">
 					<h1>Tourist Stories</h1>
 					<p class="tittle_block_text">����� - ��� �����, ��� �� ������������, ��� ������ ������ ���� ��������!</p>
 				</div>
 			</div>
 		</div>
 	</div>
 </header>

<div class="container-fluid text-center">    
  	<div class="row content">
    	<div class="col-sm-2 sidenav">
<div class=" filtr-city">
<p class="navbar-text text_sort">������</p>

<div class="accordion">
<ul>
<?php
include ("/include/db_connect.php"); 
$result = mysql_query("SELECT  * FROM country  INNER JOIN city ON country.id_country = city.id_country", $link); 
if(mysql_num_rows($result)>0){
$myrow=mysql_fetch_array($result);
   echo'<li><a href="index.php"><strong>��� ������</strong></a></li>';
    do{
        $name_country=$myrow['name_country'];
       if($name_country1 != $name_country){
    
    $id_country=$myrow['id_country'];
	echo '
  <li><a href="filtr_city.php?country='.strtolower($myrow["name_country"]).'"><strong>'.$myrow["name_country"].'</strong> </a> ';
$res = mysql_query("SELECT name_city, id_city FROM city  WHERE id_country = '$id_country'", $link);
             $row=mysql_fetch_array($res);
             echo '<ul class="category-section">
             <li><a href="filtr_city.php?country='.strtolower($myrow["name_country"]).'">��� ������</a></li>';
                do{ 
                    $name_city=$row['name_city'];
                    $id_city=$row['id_city'];
                    echo'
                        <li><a href="filtr_city.php?city='.strtolower($myrow["name_city"]).'">'.$name_city.'</a></li>
                    
                    ';
                   } while ($row = mysql_fetch_array($res));
            echo '</ul>';       
    }
    echo '
    </li>';
    $name_country1 = $name_country;
    } while ($myrow = mysql_fetch_array($result));
    }
	
?>
</div>
</div>   
  

<div class="btn-group-vertical filtr-city">
<p class="navbar-text text_sort">��� ������</p>
<div class="accordion">
<ul>
  <li><a href="index.php?type_trip=all_type"><strong>��� ����</strong></a></li>
  <li><a href="filtr_city.php?type_trip=active"><strong>��������</strong></a></li>
  <li><a href="filtr_city.php?type_trip=passive"><strong>���������</strong></a></li>
  <li><a href="filtr_city.php?type_trip=family"><strong>��������</strong></a> </li>
  </ul>  
 </div>
</div>
    	</div>
        
		
   		 <div class="col-sm-8 contain">
    		<div class="navbar-header" >
      			<p class="navbar-text text_sort">����������� ��:</p>
      <!-- <button class="navbar-toggle collapsed menu_btn" data-toggle="collapse" data-target="#sort">
 						<span class="glyphicon glyphicon-menu-hamburger">	</span>	
 					</button> -->
    	    </div>

    
     		 <ul class="nav navbar-nav sort" >
       			 <li class="dropdown">
         			 <a href="#" class="dropdown-toggle sort_a" data-toggle="dropdown">������������<b class="caret"></b></a>
         	 		<ul class="dropdown-menu">
            			<li><a href="index.php?sort=popular-acs">�����������</a></li>
            			<li><a href="index.php?sort=popular-desc">��������</a></li>
         	 		</ul>
       			 </li>
        		<li class="dropdown">
         			 <a href="#" class="dropdown-toggle sort_a" data-toggle="dropdown">����<b class="caret"></b></a>
         			 <ul class="dropdown-menu">
           				 <li><a href="index.php?sort=date-acs">�����������</a></li>
          				  <li><a href="index.php?sort=date-desc">��������</a></li>
        		    </ul>
       		   </li>
      		</ul>
      		<form class="navbar-form navbar-right " role="search" id="search_form" name="search" action="search.php?q" method="GET">
        		<div class="form-group search">
          			<input type="text" class="form-control" name="q" placeholder="Search"/>
        		</div>
       		   <input type="submit" name="submit-search" value="������"/>
      		</form>  
		<div class="line1"></div>
		<div class="line2"></div>

  		
            <?php
            $num=9;//������� �������� ������� �� ��������
    $page=(int)$_GET['page'];
    $count=mysql_query("SELECT COUNT(*) FROM city ORDER BY $sorting_city ",$link);
    $temp=mysql_fetch_array($count);
    $post=$temp[0];
    //������� ����� ����� �������
    $total = (($post-1)/$num)+1;
    $total=intval($total);
    //���������� ������ ��������� ��� ������� ��������
    $page=intval($page);
    //���� ��������  $page ������ ��� ������������
    // ��������� �� ������ ��������
    //� ���� ������� �������, �� ��������� �� ���������
    if(empty($page) or $page<0)$page=1;
    if($page>$total)$page=$total;
    //��������� ������� � ������ ������ ������� �������� ���������
    $start=$page*$num-$num;
    
    if($temp[0]>0){
        $result=mysql_query("SELECT * from city, city_in_story WHERE city_in_story.id_city=city.id_city  GROUP BY city.id_city",$link);
        if(mysql_num_rows($result)>0){
            $row=mysql_fetch_array($result);
            do{
                    
            $id=$row['id_city'];
    echo'
    <table class="table table-striped">
<tr>
    <td>����� � ��������</td>
    <td>�����</td>
    <td>���������� �������</td>
</tr>
</table>
    <section class="story">
      		<div class="story_block">
    <a href="story.php?id_story='.$row['id_story'].'"><img src="'.$img_path.'" class="img-responsive" /></a>
   	<div class="example_text">
      			 <h5>'.$row['name_story'].'</h5>
        		<span>'.$string.'</br></span>
        		<p class="glyphicon glyphicon-heart"> '.$row['count_like'].' | ���� ����������: '.$row['date'].'</p></br>
                <p class="glyphicon"> ��� ������: '.$row['name_type'].'</p></br>';
$res1 = mysql_query("SELECT * from city, city_in_story where city.id_city=city_in_story.id_city and city_in_story.id_story= $id;",$link);
If (mysql_num_rows($res1) > 0)
{
$myrow1 = mysql_fetch_array($res1);
echo'<p class="glyphicon">������:';
do

{ 
    echo'
    '.$myrow1["name_city"].'
    ';
 }while ($myrow1 = mysql_fetch_array($res1));
 echo'</p>';
 }      echo'
                </div>
      		</div>
            </section>
    '; 
    } while ($row = mysql_fetch_array($result));
   
 
} 
}  
if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="index.php?'.$url.'page='. ($page - 1) .'" />&laquo;</a></li>';

if ($page != $total) $nextpage = '<li><a class="pstr-next" href="index.php?'.$url.'page='. ($page + 1) .'"/>&raquo;</a></li>';

// ������� ��� ��������� ������� � ����� �����, ���� ��� ����
if($page - 5 > 0) $page5left = '<li><a href="index.php?'.$url.'page='. ($page - 5) .'">'. ($page - 5) .'</a></li>';
if($page - 4 > 0) $page4left = '<li><a href="index.php?'.$url.'page='. ($page - 4) .'">'. ($page - 4) .'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="index.php?'.$url.'page='. ($page - 3) .'">'. ($page - 3) .'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="index.php?'.$url.'page='. ($page - 2) .'">'. ($page - 2) .'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="index.php?'.$url.'page='. ($page - 1) .'">'. ($page - 1) .'</a></li>';

if($page + 5 <= $total) $page5right = '<li><a href="index.php?'.$url.'page='. ($page + 5) .'">'. ($page + 5) .'</a></li>';
if($page + 4 <= $total) $page4right = '<li><a href="index.php?'.$url.'page='. ($page + 4) .'">'. ($page + 4) .'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="index.php?'.$url.'page='. ($page + 3) .'">'. ($page + 3) .'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="index.php?'.$url.'page='. ($page + 2) .'">'. ($page + 2) .'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="index.php?'.$url.'page='. ($page + 1) .'">'. ($page + 1) .'</a></li>';

if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="index.php?'.$url.'page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}

	if ($total > 1)
{
    echo '
    <ul class="pagination">   
    ';
    echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='index.php?".$url."page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$nextpage;
    echo '
    </ul>
    ';
} 
?>

      
   </div>

    <div class="col-sm-2 sidenav">
      <section class="new_story">
      <p class="navbar-text text_sort">����� �������</p>
<?php
        $result=mysql_query("SELECT * FROM `story` ORDER BY date DESC limit 5;",$link);
        if(mysql_num_rows($result)>0){
            $row=mysql_fetch_array($result);
            do
            {
                if  (strlen($row['img']) > 0 && file_exists("./upload/".$row["img"]))
                    {
                        $img_path = "/upload/".$row['img']; 

                    }
                 else
                    {
                        $img_path = "/upload/no_image.jpg"; 

                    }
             echo'
      	<div class="new_story_block">
      			
      			<a href="story.php?id_story='.$row['id_story'].'"><img src="'.$img_path.'" class="img-responsive" /></a>
      			<div class="example_text">
      			 <h5>'.$row['name_story'].'</h5>
        		<p>  ���� ����������:'.$row['date'].'</p>
          </div>
      	</div></br></br>';
        }while ($row = mysql_fetch_array($result));
        }
        ?>
       </section>


    </div>
</div>
</div>



<footer class="container-fluid text-center">
<div class="top_line"></div>

<span class="glyphicon glyphicon-copyright-mark"> Designed by Ira Klinkova</span>
</footer>


<script src="libs/jquery/jquery-2.1.4.min.js"></script>
<script src="libs/bootstrap/js/bootstrap.min.js"></script>

<script src="js/common.js"></script>

	
</body>
</html>