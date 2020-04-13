<?php
require_once("sessionchecker.php");
$target_path   = 'uploads/';
$val ="";
$fk_1="";
$fk_2="";
$fk_status1="";
$fk_status2="";
if ( isset($_GET['profile']) )
{ 
    $stmt = $conn->prepare("SELECT  `inviter_fk`, `addperson_fk`, `inviter_status`, `acceptbyperson` 
    FROM `relationship` WHERE `inviter_fk` = :myself AND `addperson_fk` =:thatprofile or `inviter_fk` = :thatprofile AND `addperson_fk`=:myself");
    $stmt->bindParam(":thatprofile",$_GET['profile'], PDO::PARAM_STR);
    $stmt->bindParam(":myself",$_SESSION["identity"], PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    $Relationresults = $stmt->fetch(PDO::FETCH_ASSOC);
	if($Relationresults > 0){
		$fk_1 = $Relationresults['inviter_fk'];
		$fk_2 = $Relationresults['addperson_fk'];
		$fk_status1 = $Relationresults['inviter_status'];
		$fk_status2 = $Relationresults['acceptbyperson'];
	}
   // echo "get profile =".$_GET['profile'];
  ///  echo "first count ".$count."<br>";
    //echo "session_id".$_SESSION["identity"];

    if($count ==0){ $val="Send Friend Request";}  
    else  { 
      /*if  ($fk_1 !=$_SESSION["identity"]){
        echo 'checked';
      }else{echo 'false';}*/
      //echo  "<input type='hidden' name='fname' value=   fk_1     ".$fk_1."    fk_2    ".$fk_2 ."   fk_status1   ".$fk_status1."    fk_status2   ".$fk_status2.
      //$val="     Show Accepted>";}  
    }


       $stmt_ = $conn->prepare("SELECT * FROM user WHERE user_id=:id");
       $stmt_->bindParam(':id', $_GET['profile'], PDO::PARAM_STR);
       $stmt_->execute();
       $results1 = $stmt_->fetch(PDO::FETCH_ASSOC);
       $res = $results1['username'];
       $res2 = $results1['uemail'];
       $res3 = $results1['bio_data'];
       $res4 = $results1['uprof_pic'];
      
       if ($res4 =="" || !file_exists( $target_path."/".$res4 )){
         $res4 = $target_path."default.png";                                   //for showing basic profile of tutor
       }
  
   if ($results1 ==0){
     print_r( $results1 );
     header("location:error.php"); 
   }
  }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("userdashheader.html");?> 
<head>
    <title>Friend: <?php echo "$res";?> - GoGetter</title>
</head>

<link href="css/userprofile.css" rel="stylesheet">

    </head>
    <body>
        <!-- Navbar -->
        <?php require_once("userdashnav2.html"); ?>
        <div style="margin-left: 105px; margin-right: 105px; margin-bottom: 5px;">
            <ul class="breadcrumb" style="margin: 0px !important">
                <li><a href="index.php"><i class="fa fa-home"></i></a></li>
                <li><a href="userdashboard.php">DASHBOARD</a></li>
                <li><a href="userdashfriend.php">FRIENDS</a></li>
                <li><a href="#">FRIEND: <?php echo "$res";?></a></li>
            </ul>
        </div>
        
        <!--================Total container Area =================-->
        <div class="container main_container">
            <div class="content_inner_bg row m0">
                <section class="about_person_area pad" id="about">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="person_img">
                                <img src="uploads/<?php echo $res4;?>" style="width:612px;height:400;" alt="">
                                <?php 
                                $canrate = ""; $canrate2 = ""; $canrate3= "";
                                if ($_GET['profile'] !==$_SESSION["identity"]) {
                                  if ($count >0 && $fk_2 !=$_SESSION["identity"] && $fk_status2 =='P' && $fk_status1 =='A'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='profile.php?profile=".$_GET['profile']."'><span>Waiting for Accept</span></a>";
                                  }else if($count >0 && $fk_2 ==$_SESSION["identity"] && $fk_status2 =='P' && $fk_status1 =='A'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='relationshiphandler.php?accept=".$_GET['profile']."'><span>Accept Now</span></a>";
                                  }else if($count >0  && $fk_status2 =='A' && $fk_status1 =='A'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='profile.php?profile=".$_GET['profile']."'><span>Accepted</span></a>";
                                  }else if($count >0 && $fk_status2 =='B'&& $fk_1 ==$_SESSION["identity"] && $fk_status1 =='A'){ 
                                    $canrate = "<a id='myDiv' class='download_btn' href='#'><span>You Have Been Block :{</span></a>";
                                  }else if ($count >0 && $fk_status1 =='B'&& $fk_2 ==$_SESSION["identity"] && $fk_status2 =='A' ){
                                    $canrate = "<a id='myDiv' class='download_btn' href='#'><span>You Have Been Block :{</span></a>";
                                  }else if ($count >0 && $fk_status1 =='B'&& $fk_1 ==$_SESSION["identity"] && $fk_status2 !='B'){
                                        $canrate = "<a id='myDiv' class='download_btn' href='#'><span>You Blocked him</span></a>";
                                  }else if ($count >0 && $fk_status2 =='B'&& $fk_2 ==$_SESSION["identity"] && $fk_status1 !='B'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='#'><span>You Blocked him</span></a>";  
                                  }else if ($count >0 && $fk_status2 =='B'&& $fk_status1 =='B' ){
                                      $canrate = "<a id='myDiv' class='download_btn' href='#'><span>Both have Blocked</span></a>";     
                                  }else if ($count ==0){
                                    $canrate = "<a id='myDiv' class='download_btn' href='relationshiphandler.php?request=".$_GET['profile']."'><span>Sent Friend Request</span></a>";
                                  }else{
                                    $canrate = "";
                                  }

//$canrate = "<a id='myDiv' class='download_btn' href='relationshiphandler.php?request=".$_GET['profile']."'><span>Sent Friend Request</span></a>";
                                 } 
                                // $fk_2 ==$_SESSION["identity"]
                                if ($count >0 ){
                                  if ($fk_2 ==$_SESSION["identity"] && $fk_status2 =='A'){
                                    $canrate2 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?block=".$_GET['profile']."'><span>Block</span></a>";
                                    $canrate3 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?remove=".$_GET['profile']."'><span>Remove</span></a>";
                                  }else if ($fk_1 ==$_SESSION["identity"] && $fk_status1 =='A'){
                                    $canrate2 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?block=".$_GET['profile']."'><span>Block</span></a>";
                                    $canrate3 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?remove=".$_GET['profile']."'><span>Remove</span></a>";
                                  }else if ($fk_2 ==$_SESSION["identity"] && $fk_status2 =='B'){
                                    $canrate2 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?unblock=".$_GET['profile']."'><span>unBlock</span></a>";
                                  }else if ($fk_1 ==$_SESSION["identity"] && $fk_status1 =='B'){
                                    $canrate2 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='relationshiphandler.php?unblock=".$_GET['profile']."'><span>unBlock</span></a>";
                                  }else{$canrate2 = "";}
                                }//https://fontawesome.com/v4.7.0/icon/user-times
                                echo $canrate.$canrate2.$canrate3;
                                //echo $count;
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row person_details">
                                <h3>Hi I'm <span><?php echo "$res";?></span></h3><br>
                                <h4>Info</h4>
                                <p><pre>     <?php echo $res2;?>      </pre></p>
                                <div class="person_information">
                                    <ul>
                                         <li><a href="#">Bio Data</a><?php echo $res3;?></li>
                                    </ul>
                                </div>
                              </div>
                            </div>
                          </div> 
                </section>
                <section class="education_area pad" id="education">
                    <div class="main_title">

                    </div>
                    <div class="education_inner_area">
                        <div class="education_item wow fadeInUp animated" data-line="H">
                            <!--<h6>2005-2007</h6>
                            <a href="#"><h4>Secondary School</h4></a>-->
                        </div>
                       
                    </div>
                      </div>
                </section>

                <br>
              <hr>
            
                <meta itemprop="itemReviewed" content="Person">	
                    </div>
                    </div>
            </div>
              </div>

              
        </div>

        <script>
        function myFunction() {
        var x = document.getElementById("myDIV");
         if (x.style.display === "none") {
        x.style.display = "block";
         } else {
         x.style.display = "none";
        }
      }
</script>
</body>
</html>