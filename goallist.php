<?php
 require_once("sessionchecker.php");
$query = "SELECT * FROM `categories`"; 
$searchcateg=$conn->prepare($query);
$searchcateg->execute();
$totalcateg = $searchcateg->rowCount();
$totalresult='0';

if (isset($_POST["submit"])){
 $val1 ="Types &amp; ".$_POST["subject"];
 //echo "submited post".$val1;

 $desubject ="";
 foreach ($searchcateg as $rowcate) {
   if ($rowcate['category'] ==$_POST["subject"]){
     $desubject = $rowcate['category_id'] ;
   }
 }
 //echo "De subject = ".$desubject;

 // searching by zip code= "d.t_zip";


 if ($_POST["subject"] == ""){
  $query1 = "SELECT m.`goals_id`, m.`goals_name`, m.`category`, m.`goals_desc`, m.`goals_picture`, c.goal_followed_id FROM
   common_goals m INNER JOIN goals_followed c ON c.goals_fk = m.goals_id WHERE c.goals_follower_fk = ".$_SESSION['identity'];
   $val1 = "My Added Goals";
 }else{
  $query1 = "SELECT * FROM `common_goals` WHERE `category` = :sub"; 
 }
 $search_=$conn->prepare($query1);
 if ($_POST["subject"] != ""){$search_->bindParam(':sub', $desubject, PDO::PARAM_STR);}
 $search_->execute();
 $totalresult = $search_->rowCount(); 
 //echo "Rowcount= ".$totalresult;
}
?>
<html>
<head>
  <title>Goal List - GoGetter</title>
  </head>
  <!-- Header -->
<?php require_once('header.html'); ?>
<?php require_once("userdash_searchheader.html");?>   
<body>

<!-- Navbar -->
<?php require_once("userdashnav2.html"); ?>
<div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
  <ul class="breadcrumb" style="margin: 0px !important">
        <li><a data-ajax="false" href="index.php"><i class="fa fa-home"></i></a></li>
        <li><a data-ajax="false" href="userdashboard.php">DASHBOARD</a></li>
        <li><a data-ajax="false" href="goallist.php">GOAL LIST</a></li>
    </ul>
</div>
  <div style="margin-top: 20px;">
    <h1 align="center">Search Goals</h1>
  </div>
   <div id="hello1">
  <div data-role="main" class="ui-content">
    <form method="post" action="goallist.php"  class="search-container" data-ajax="false">
    <div id="box">
      <label for="usr">Goals</label>
      <input list="browsers" name="subject" data-ajax="false">
        <datalist id="browsers" data-ajax="false">
          <?php 
           $searchcateg->execute();
            foreach ($searchcateg as $rowcate) {
              echo '<option value="'.$rowcate['category'].'">';
            }
          ?>
        </datalist>
      <input type="submit" class="search-icon"  name="submit" id="search" alt="search" value="&#x1F50D;" data-ajax="false">
    </div>
      <?php
       echo "<input type='hidden' name='csrf' value='$csrf'>" ;
        ?> 
        
        
        <p>
        
        </p>
      </form>
  </div>
  <div>
  </div>
  <?php require_once("common_goal.php");            
  ?>
  
</div> 


</body>
</html>
<!--/
SELECT 
    m.`goals_id`, 
    m.`goals_name`,
    m.`category`,
    m.`goals_desc`,
    m.`goals_picture`,
    c.goal_followed_id
FROM
    common_goals m
INNER JOIN goals_followed c 
    ON c.goals_fk = m.goals_id
WHERE c.goals_follower_fk =    ;

/-->