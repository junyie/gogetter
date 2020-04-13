<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome Icon Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>


<p>Challenges Progress</p>
<hr style="border:3px solid #f1f1f1">
<div class="row">
<?php
require_once("challengecontroller.php");
function scoresTopercentage($score, $maximumPoints ){
  if ($maximumPoints != 0){
  $percentage = round(($score / $maximumPoints) * 100 );/// $totalpeople);
  }else{$percentage = 0;}
  //$percentage = $percentage * 100;
  return $percentage;
}


$Challengerstotalcount = countChallengersTotal($retrievename1,$retrievename2,$retrievename3,$retrievename4,$retrievename5);

$challengersScore = json_decode(returnAllChallengeScore($conn,$challengeID));
//print_r($challengersScore);
//var_dump($challengersScore);

$scorecpp1 = $challengersScore->ppl1;
$scorecpp2 = $challengersScore->ppl2;
$scorecpp3 = $challengersScore->ppl3;
$scorecpp4 = $challengersScore->ppl4;
$scorecpp5 = $challengersScore->ppl5;
$sumEvyOne = $scorecpp1 + $scorecpp2 + $scorecpp3 + $scorecpp4 + $scorecpp5;
$ratingstotalRecords = json_decode(checkHowmanyRatings($conn, $challengeID));
$ratingRecords = $ratingstotalRecords->countR;

 $maximumPoints =( $ratingRecords * 5  );//;
if ($Challengerstotalcount >0 && $Challengerstotalcount > 0){
    $scoreppl1 = scoresTopercentage($scorecpp1, $maximumPoints );
    $scoreppl2 = scoresTopercentage($scorecpp2, $maximumPoints );
    $scoreppl3 = scoresTopercentage($scorecpp3, $maximumPoints );
    $scoreppl4 = scoresTopercentage($scorecpp4, $maximumPoints );
    $scoreppl5 = scoresTopercentage($scorecpp5, $maximumPoints );
}
//echo "<br>Percentage 1 =".$scoreppl1;

//echo "<br>Max points".$maximumPoints;

if ($retrievename1 != ""){
  echo '
  <div class="side">
    <div>'.$retrievename1.'</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div>'.$scoreppl1.'%</div>
  </div>';
}
if ($retrievename2 != ""){
  echo '
  <div class="side">
    <div>'.$retrievename2.'</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div>'.$scoreppl2.'%</div>
  </div>';
}

if ($retrievename3 != ""){
  echo '
  <div class="side">
    <div>'.$retrievename3.'</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div>'.$scoreppl3.'%</div>
  </div>';
}

if ($retrievename4 != ""){
  echo '
  <div class="side">
    <div>'.$retrievename4.'</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div>'.$scoreppl4.'%</div>
  </div>';
}

if ($retrievename5 != ""){
  echo '
  <div class="side">
    <div>'.$retrievename5.'</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div>'.$scoreppl5.'%</div>
  </div>';
}
  ?>
</div>
<style>
* {
  box-sizing: border-box;
}



.fa {
  font-size: 25px;
}

.checked {
  color: orange;
}

/* Three column layout */
.side {
  float: left;
  width: 15%;
  margin-top:10px;
}

.middle {
  margin-top:10px;
  float: left;
  width: 70%;
}

/* Place text to the right */
.right {
  text-align: right;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* The bar container */
.bar-container {
  width: 100%;
  background-color: #f1f1f1;
  text-align: center;
  color: white;
}

/* Individual bars */
<?php echo "
.bar-5 {width: $scoreppl1%; height: 18px; background-color: #4CAF50;}
.bar-4 {width: $scoreppl2%;; height: 18px; background-color: #2196F3;}
.bar-3 {width: $scoreppl3%; height: 18px; background-color: #00bcd4;}
.bar-2 {width: $scoreppl4%; height: 18px; background-color: #ff9800;}
.bar-1 {width: $scoreppl5%;; height: 18px; background-color: #f44336;}";
?>
/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
  .side, .middle {
    width: 100%;
  }
  .right {
    display: none;
  }
}
</style>
</body>
</html>
