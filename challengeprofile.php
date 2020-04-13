<?php
 require_once("sessionchecker.php");
 require_once("challengecontroller.php");
 $target_path   = 'uploads/';
 $val ="";
 $today = date("Y-m-d");
 $showAbleRatinghtmlButton ="";
 function convertstatus($character){
    switch ($character) {
        case 'E':
            return "Expired";
            break;
        case 'P':
            return "Pending";
            break;
        case 'Q':
            return "Quitted";
            break;
        case 'A':
            return "Accepted";
            break;

        default:
            //mieow
            return "";
    }
 }

 function finduserPicture($conn, $usrid){
    $query =" SELECT `uprof_pic` FROM `user` WHERE `user_id` =:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$usrid, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results['uprof_pic'];
 }

 function finduser($conn, $usrid){
    $query =" SELECT `user_id`, `username` FROM `user` WHERE `user_id` =:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$usrid, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results['username'];
 }

 function ifIdentical($s_id,  $player1, $player2, $player3, $player4, $player5){
    $belongshere =0;
    if ($s_id == $player1) {$belongshere =$belongshere+1;}
    if ($s_id == $player2) {$belongshere =$belongshere+2;}
    if ($s_id == $player3) {$belongshere =$belongshere+3;}
    if ($s_id == $player4) {$belongshere =$belongshere+4;}
    if ($s_id == $player5) {$belongshere =$belongshere+5;}
    return $belongshere;
}

function challengeUserStatus($numberIget, $ppl1, $ppl2, $ppl3, $ppl4, $ppl5 ){
    switch ($numberIget) {
        case 1:
            return $ppl1;
            break;
        case 2:
            return $ppl2;
            break;
        case 3:
            return $ppl3;
            break;
        case 4:
            return $ppl4;
            break;
        case 5:
            return $ppl5;
            break;
        
        default:
            //mieow;
    }
}

if ( isset($_GET['challengeprofile']) )
{ 
    //echo "ChallengeProfile=".$_GET['challengeprofile'];
    $stmt = $conn->prepare("SELECT * FROM `challenges` WHERE `chall_id` = :thatprofile ");
    $stmt->bindParam(":thatprofile",$_GET['challengeprofile'], PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    $challengeresults = $stmt->fetch(PDO::FETCH_ASSOC);
    // ['chall_creator_fk']; ['chall_invite2'];  ['chall_invite3']; ['chall_invite4']; ['chall_invite5'];
    $challengeID = $challengeresults['chall_id']; 
    $challTitle = $challengeresults['chall_name'];
    $challDesc = $challengeresults['chall_desc'];
    $challPic = $challengeresults['chall_picture'];
    $challStart = $challengeresults['chall_start_day'];
    $challExp = $challengeresults['chall_invite_expire'];
    $challEnd = $challengeresults['chall_due_date'];
    $player1 = $challengeresults['chall_creator_fk'];
    $player2 = $challengeresults['chall_invite2'];
    $player3 = $challengeresults['chall_invite3'];
    $player4 = $challengeresults['chall_invite4'];
    $player5 = $challengeresults['chall_invite5']; 
    $statusppl1 = convertstatus($challengeresults['chall_accept1']);
    $statusppl2 = convertstatus($challengeresults['chall_accept2']); 
    $statusppl3 = convertstatus($challengeresults['chall_accept3']);
    $statusppl4 = convertstatus($challengeresults['chall_accept4']); 
    $statusppl5 = convertstatus($challengeresults['chall_accept5']); 

    $belongs = ifIdentical($_SESSION["identity"], $player1, $player2, $player3, $player4, $player5 );
    $mystatus = challengeUserStatus($belongs, $statusppl1, $statusppl2, $statusppl3, $statusppl4, $statusppl5 );
    //<li><a href="#">Players</a>   Pending/Accepted</li>

    $retrievename1 =  ($player1!="0") ? finduser($conn, $player1) : "";
    $_retrievename1 = ($retrievename1!="") ? '<li><a href="profile.php?profile='.$player1.'">Host Inviter &nbsp'.$retrievename1.'</a>  '.$statusppl1.' </li>' : "";
    $retrievename2 = ($player2!="0") ? finduser($conn, $player2) : "";
    $_retrievename2 = ($retrievename2!="") ? '<li><a href="profile.php?profile='.$player2.'">Player  &nbsp'.$retrievename2.'</a>  '.$statusppl2.' </li>' : "";
    $retrievename3 = ($player3!="0") ? finduser($conn, $player3) : "";
    $_retrievename3 = ($retrievename3!="") ? '<li><a href="profile.php?profile='.$player3.'">Player &nbsp'.$retrievename3.'</a>  '.$statusppl3.' </li>' : "";
    $retrievename4 = ($player4!="0") ? finduser($conn, $player4) : "";
    $_retrievename4 = ($retrievename4!="") ? '<li><a href="profile.php?profile='.$player4.'">Player &nbsp'.$retrievename4.'</a>  '.$statusppl4.' </li>' : "";
    $retrievename5 = ($player5!="0") ? finduser($conn, $player5) : "";
    $_retrievename5 = ($retrievename5!="") ? '<li><a href="profile.php?profile='.$player5.'">Player &nbsp'.$retrievename5.'</a>  '.$statusppl5.' </li>' : "";

    $retrieveProfpic1 =  ($player1!="0") ? finduserPicture($conn, $player1) : "";
    $retrieveProfpic2=  ($player2!="0") ? finduserPicture($conn, $player2) : "";
    $retrieveProfpic3 =  ($player3!="0") ? finduserPicture($conn, $player3) : "";
    $retrieveProfpic4 =  ($player4!="0") ? finduserPicture($conn, $player4) : "";
    $retrieveProfpic5 =  ($player5!="0") ? finduserPicture($conn, $player5) : "";



    //Use for debugging
    //echo "<br>retrieveName1=&nbsp".$_retrievename1."<br>retrieveName2=&nbsp".$_retrievename2."<br>retrieveName3=&nbsp".$_retrievename3.
    //"<br>retrieveName4=&nbsp".$_retrievename4."<br>retrieveName5=&nbsp".$_retrievename5;
    //echo "My status = ".$mystatus;
    //print_r($challengeresults);
    //echo "count=".$count;
    //echo "<br>belongs".$belongs;
    if ($count ==1 && $belongs>0 && $today < $challEnd ){
        //echo "belongs= &nbsp".$belongs; 
        $value = "0";
        $value = checkTodayHad_RatedNot($conn, $s_id, $challengeID);
        if ($challStart <= $today && $challEnd >= $today && $mystatus == "Accepted" ){
            if ($value=="1"){ $showAbleRatinghtmlButton =
                 "<a id='myDiv' class='download_btn' data-toggle='modal' data-target='#myModal' href='#'><span>Rating⭐</span></a>";
            }else{$showAbleRatinghtmlButton =
                    "<a id='myDiv' class='download_btn' href='#'><span>Rated Today 👍</span></a>";}
     }else{
        $showAbleRatinghtmlButton ="";  
        // header("location:error.php");
     }
    }


    if(true){ $val="Send Friend Request";}//$count ==0  
    else  { 
      /*if  ($fk_1 !=$_SESSION["identity"]){
        echo 'checked';
      }else{echo 'false';}*/
      //echo  "<input type='hidden' name='fname' value=   fk_1     ".$fk_1."    fk_2    ".$fk_2 ."   fk_status1   ".$fk_status1."    fk_status2   ".$fk_status2.
      //$val="     Show Accepted>";}  
    }

    if ($challPic =="" || !file_exists( $target_path."/".$challPic )){
        $challPic = $target_path."default.jpg";                                   //for showing basic profile of tutor
    }else{
        $challPic = $target_path.$challPic ; 
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once("userdashheader.html");?> 
<head>
    <title>CHALLENGE: <?php echo "$challTitle";?> - GoGetter</title>
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
                <li><a href="challengeshow.php">CHALLENGES LIST</a></li>
                <li><a href="#">CHALLENGE: <?php echo "$challTitle";?></a></li>
            </ul>
        </div>

        <!--================Total container Area =================-->
        <div class="container main_container">
            <div class="content_inner_bg row m0">
                <section class="about_person_area pad" id="about">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="person_img">
                                <img src=<?php echo $challPic;?> style="width:612px;height:400;" alt="">
                                <?php 
                                $canrate = ""; $showQuitformButton = "";
                                if ($today >= $challEnd ){
                                    $showQuitformButton = "";
                                }else{ $showQuitformButton = "<a id='myDiv' style='width:50%' class='download_btn' data-toggle='modal' data-target='#myModal2' href='#'><span>🏳️ Quit</span></a>"; }
                                if ($count ==1) {
                                  if ($mystatus =='Pending'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='challengehandler.php?acceptchallenge=".$_GET['challengeprofile']."&playerN=".$belongs."'><span>Accept Now</span></a>
                                    <a id='myDiv' class='download_btn' href='challengehandler.php?quitchallenge=".$_GET['challengeprofile']."&playerN=".$belongs."'><span>Decline</span></a>";    
                                  }else if ($mystatus =='Quitted'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='#'><span>You Quit🏳️</span></a>";
                                  }else if ($mystatus =='Expired'){
                                    $canrate = "<a id='myDiv' class='download_btn' href='#'><span>Expired🕗</span></a>";
                                  }else if ($mystatus =='Accepted'){
                                    if ($today > $challEnd){
                                        $canrate = "<a id='myDiv' class='download_btn' href='#'><span>Challenge End👋</span></a>";//bug here not showing
                                      }else{
                                        $canrate = "<a id='myDiv' class='download_btn' href='#'><span>Challenge Accepted</span></a>".$showAbleRatinghtmlButton."
                                    ".$showQuitformButton;
                                      }
                                  }else {}

                                }

//$canrate = "<a id='myDiv' class='download_btn' href='relationshiphandler.php?request=".$_GET['profile']."'><span>Sent Friend Request</span></a>";
                                echo $canrate;
                                //echo   $count;
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row person_details">
                                <h3>Challenge <span><?php echo "$challTitle";?></span></h3><br>
                                <h4>Description</h4>
                                <p><pre>     <?php echo $challDesc.'<br>Start date🥊 '.$challStart.'&nbsp End date✨ '.$challEnd .'<br>Invite expiration⛔ '.$challExp;?>     </pre></p>
                                <div class="person_information">
                                    <ul>
                                         <!--li><a href="#">Players</a></li-->
                                         <?php echo $_retrievename1.$_retrievename2.$_retrievename3.$_retrievename4.$_retrievename5?>
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
                        <div class="education_item wow fadeInUp animated" data-line="H" style="margin-bottom: 10px; margin-top: 10px;">
                            <?php if ($challStart <= $today  && $mystatus == "Accepted"){
                                require_once("rateresult.php");
                            }
                            ?>
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
                <!-- Modal1 For Rating-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ratings</h4>
                    </div>
                    <div class="modal-body">
                        <!--label for="usr">Notes</label-->
                        <form action ="challengehandler.php?<?php echo 'rating='.$_GET["challengeprofile"]?>" method = "POST">
                        <?php require_once("ratingform.php");?>
                        <input type="hidden" name="challengeprofile" value="<?php echo $_GET["challengeprofile"];?>">
                        <input type="hidden" name="csrf" value="<?php //echo $csrf ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submitarating" class="btn btn-default" >Save</button>
                        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- Modal 1 End -->

                        <!-- Modal2 For Confirm Quit-->
        <div class="modal fade" id="myModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Quit the challenge</h4>
                    </div>
                    <div class="modal-body">
                        <label for="usr">Exit this challange, are you sure?</label>
                    </div>
                    <div class="modal-footer">
                    <?php echo '<a href="challengehandler.php?quitchallenge='.$_GET['challengeprofile'].'&playerN='.$belongs.'"';?><button type="submit" class="btn btn-default"  >Confirm</button></a>
                        <button type="button" class="btn btn-default"  data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div><!-- Modal 2 End -->

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