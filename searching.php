<?php
 require_once("sessionchecker.php");

 if (isset($_POST["submit"])){
  $val1 = $_POST["subject"];

  $query1 = "SELECT `user_id`, `username`, `uemail`, `uprof_pic`,  `bio_data` FROM `user` WHERE `username` LIKE :subject"; 

  // searching by zip code= "d.t_zip";

  $search=$conn->prepare($query1);
  $search->bindParam(':subject', $val1, PDO::PARAM_STR);
  $search->execute();
  $total = $search->rowCount(); 
 }

?>
<html>
<?php require_once("userdash_searchheader.html");?>
<head><title>Search Friends - GoGetter</title></head>
<body>

<!-- Navbar -->
<?php require_once("userdashnav2.html"); ?>
<div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
  <ul class="breadcrumb" style="margin: 0px !important;">
        <li><a href="index.php" data-ajax="false"><i class="fa fa-home"></i></a></li>
        <li><a href="userdashboard.php" data-ajax="false">DASHBOARD</a></li>
        <li><a href="searching.php" data-ajax="false">SEARCH FRIENDS</a></li>
    </ul>
</div>

<div>
    <h1 align="center">Search Friends</h1>
  </div>
   <div id="hello1">
  <div data-role="main" class="ui-content">
    <form method="post" action="searching.php" data-ajax="false" class="search-container">
    <div id="box">
      <label for="usr">Username</label>
      <input type="text" id="subject" name="subject" id="search-bar" placeholder="John Doe">
      <input type="submit" class="search-icon"  name="submit" id="search" alt="search" value="&#x1F50D;" >
    </div>
      <?php
       echo "<input type='hidden' name='csrf' value='$csrf'>" ;
        ?> 
        <p>
        please put something in order to search
        </p>
      </form>
  </div>
  <div>
                    <?php 
                    if (isset($_POST["submit"])  && !empty( $_POST["subject"])){
                      echo "<h3>".$total."  total results</h3>";
                      foreach ($search as $row) {
                        echo "<div id='hello'>";
                        echo "<div class='well well-sm' >";
                        echo "<div class='media'>";
                        echo "<a class='thumbnail pull-left' href='#'>";
                        echo "<img class='media-object' src=uploads/$row[uprof_pic] style='width:120px; height:80px'></a>";
                        echo "<div class='media-body'>";
                        echo "<h3 class='media-heading'>$row[uemail] </h3>";
                        $sub = substr($row['bio_data'], 2, 300);
                        echo "<!--p><span class='label label-info'>10 Best Review</span> <span class='label label-primary'>89 Students</span></p--><p>
                            ";
                            echo "<a href=profile.php?profile=$row[user_id] class='btn btn-default btn-sm'   data-ajax='false'><span class='glyphicon glyphicon-eye-open'></span> More Info</a></p>
                            <h5>$sub....</h5>
                    </div>
                </div>
            </div>
         </div>";
                    } 
                    }
                      
                    ?>
  </div>
</div> 
<!-- Footer -->
<?php require_once('footer.html'); ?>

</body>
</html>
