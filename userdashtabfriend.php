<div class="card" style="width: 750px;">
    <div class="container1">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Friends</a></li>
        <li ><a data-toggle="tab" href="#home2">Accept Friends Request</a></li>
        <li ><a data-toggle="tab" href="#home3">Pending Request</a></li>
    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <p> 
                <div class="wrapper">

<?php
 require_once("sessionchecker.php");
   // search friend that me invited
require_once("relationshipcontroller.php");

$myfriendrequest = findNewFriendRequest($conn, $s_id);
$myfriendpending = findNewFriendRpending($conn, $s_id);

if ($mytotalfriend ==0){
    echo '<div><a class="btn btn-primary" href="searching.php" role="button">Search For New Friends</a></div>';
}
//print_r($result);
//echo "count".$totalresult;
showallMyFriends($result,$result2);

?>
                </div>
            </p>
        </div><!-- end of div id="home"--> 

        <!--show all available request sent by others-->
        <div id="home2" class="tab-pane fade">
            <p>
                <div class="wrapper">
                    <?php showallMyFriends('0',$myfriendrequest);
                    //print_r($myfriendrequest);
                    ?>
                </div>
            </p>
        </div>
       <!--show pending request that still waiting for the opposite site to accept-->
       <div id="home3" class="tab-pane fade">
            <p>
                <div class="wrapper">
                    <?php showallMyFriends($myfriendpending,'0');
                    //print_r($myfriendrequest);
                    ?>
                </div>
            </p>
        </div>

    </div><!--tab content-->
    
    <link rel="stylesheet" type="text/css" href="css/tab_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
img {
    border-radius: 20%;
}
.box {
  background-color: #444;
  color: #fff;
  border-radius: 10px;
  padding: 5px;
  font-size: 150%;
}

.box:nth-child(even) {
  background-color: #ccF;
  color: #000;
}
    .wrapper {
    display: grid;
    border:1px solid #FFF;
    grid-gap: 5px;
    grid-template-columns: repeat(auto-fill, minmax(100px,1fr) minmax(200px,2fr));
    }
/****Table****/
</style>