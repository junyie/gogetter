
<?php
 require_once("sessionchecker.php");
 $target_path   = 'uploads/';
 $val ="";$recresult="";
 $total = 0;

/*UPDATE `goal_target` SET `targeted_times` = (SELECT COUNT(`following_goal_fk`) FROM `goal_record` WHERE `checked_date` >= 2020-02-20  AND `following_goal_fk` = 120  ) WHERE `goal_target_id` = 2
);*/
require_once("goalprofilecontroller.php");

if ( isset($_GET['goal']) && is_numeric($_GET['goal']) && $_GET['goal'] >'0'){
$followinggoalId = searchFollowedgoal($conn, $_GET['goal'], $s_id);
}

//print_r($followinggoalId);
if ($followinggoalId != '0'){
    findTargetAndUpdateTargetedTimes($conn, $followinggoalId['goal_followed_id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("userdashheader.html");?>
<head>
    <title>Goal: <?php echo "$res2";?> - GoGetter</title>
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
                <li><a href="#">GOAL: <?php echo "$res2";?></a></li>
            </ul>
        </div>
        
        <!--================Total container Area =================-->
        <div class="container main_container">
            <div class="content_inner_bg row m0">
                <section class="about_person_area pad" id="about">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="person_img">
                                <img src="uploads/<?php echo $res5;?>" style="width:612px;height:400;" alt="">
                                <?php 
                                if ($recresult >0){
                                    $valuee = "<a id='myDiv' class='download_btn' href='#'><span>Checked ✓</span></a>";
                                }else{$valuee = "<a id='myDiv' class='download_btn' href='#' data-toggle='modal' data-target='#myModal'><span>Check For Today</span></a>";}

                                $canrate = ""; $canrate2 = "";
                                if ($search1 >0) {
                                    $canrate = $valuee."
                                    <a id='myDiv' class='download_btn' href='#'><span>Following</span></a>";
                                  }else{
                                    $canrate = "<a id='myDiv' class='download_btn' href='goalshandler.php?follow=".$_GET['goal']."'><span>Add Goal to List</span></a>";
                                  }

//$canrate = "<a id='myDiv' class='download_btn' href='relationshiphandler.php?request=".$_GET['profile']."'><span>Sent Friend Request</span></a>";
                                 
                                // $fk_2 ==$_SESSION["identity"]
                                  if ($search1 >0){
                                    $canrate2 ="<a id='myDiv' onclick='myFunction();' class='contact_btn' href='goalshandler.php?reset=".$_GET['goal']."'><span>Reset</span></a>";
                                  }else{$canrate2 = "";}
                                //https://fontawesome.com/v4.7.0/icon/user-times
                                echo $canrate.$canrate2;
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row person_details">
                                <h3><span><?php echo "$res2";?></span></h3><br>
                                <h4>Info</h4>
                                <p><pre>     <?php echo "Followers";?>      </pre></p>
                                <div class="person_information">
                                    <ul>
                                        <li><a href="#"> </a><?php echo $res4;?></li>
                                    </ul>
                                    <br><br>  <?php
                                    if ($search1 >0){
                                    echo '
                                    <h4>Set Routine</h4>
                                    <ul class="social_icon">
                                      <li '.$sun1.'><a href="goalshandler.php?sun='.$sun.'&follow='.$_GET["goal"].'"><i class="">Sun</i></a></li>
                                      <li '.$mon1.'><a href="goalshandler.php?mon='.$mon.'&follow='.$_GET["goal"].'"><i class="">Mon</i></a></li>
                                      <li '.$tue1.'><a href="goalshandler.php?tue='.$tue.'&follow='.$_GET["goal"].'"><i class="">Tue</i></a></li>
                                      <li '.$wed1.'><a href="goalshandler.php?wed='.$wed.'&follow='.$_GET["goal"].'"><i class="">Wed</i></a></li>
                                      <li '.$thus1.'><a href="goalshandler.php?thus='.$thus.'&follow='.$_GET["goal"].'"><i class="">Thus</i></a></li>
                                      <li '.$fri1.'><a href="goalshandler.php?fri='.$fri.'&follow='.$_GET["goal"].'"><i class="">Fri</i></a></li>
                                      <li '.$sat1.'><a href="goalshandler.php?sat='.$sat.'&follow='.$_GET["goal"].'"><i class=""></i>Sat</a></li>
                                    </ul>';
                                   require_once("timepicker/timepicker.php");}
                                    if ($search1 >0){
                                        $today = date("Y-m-d");
                                        if ($checkcurrentTarget >0 && $targetend >= $today){ //$targetend
                                            echo "<br><h4>Current Target</h4>Start Date:&nbsp".$targetstart."&nbsp&nbsp End Date:&nbsp".
                                            $targetend."&nbsp&nbsp Expectation ✖️".
                                            $targetexptime."&nbsp&nbsp Achieved:&nbsp".
                                            $target_done." times";
                                        }else{ echo '<button type="button" id="myDiv" data-toggle="modal" data-target="#myModal2" class="btn btn-warning" style="background-color:#fec608";>Set New Target</button>'; }
                                        //echo "<br>Goal ID". $goalde_id;
                                    }
                                   ?>

                                    <!-- Modal1 -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Check Routine</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="usr"></label>
                                                    <form action = "goalshandler.php?<?php echo 'record='.$_GET["goal"]?>" method = "POST">
                                                    <input type="text" class="form-control" id="usr" name="notes">
                                                    <input type="hidden" name="follow" value="<?php echo $_GET["goal"];?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-default" >Save</button>
                                                    <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- Modal 1 End -->
                                    <!-- Modal2 --><br><br><br><br><br>
                                    <div class="modal fade" id="myModal2" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Goal Target</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="usr">Expected perform times</label>
                                                    <div class="alert alert-danger" role="alert" id="alart" style="display: none;">
                                                        Field consist invalid values!
                                                    </div>
                                                    <form action = "goalshandler.php" method = "POST">
                                                    <input type="text" onkeyup="success()" class="form-control" id="usr1" name="exp" autocomplete="off">
                                                    <?php require_once("date_picker.html");?> 
                                                    <input type="hidden" name="follow" value="<?php echo $_GET["goal"]; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit2" name="set_target" value="<?php echo $_GET["goal"]?>" disabled id="button" class="btn btn-default" >Create</button>
                                                    <button type="button" class="btn btn-default" onclick="clearfield()" data-dismiss="modal">Close</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- Modal 2 End -->
                                </div>
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
                            <?php require_once("goalprofilenotes.php");?>
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