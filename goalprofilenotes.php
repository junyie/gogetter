<?php
if (isset($goalde_id)){
 echo '<div class="col-md-30">
 <hr style="border: 0px;border-top: 1px solid #ddd; ">
 <div itemprop="review" itemscope itemtype="http://schema.org/Review">
   <div class="w3-bar w3-blue">
     <a href="#" class="w3-bar-item w3-button">Notes</a></div>';
  $retrievedGoalRecords = retrieveallGoalRecords($conn, $goalde_id);

  if ($retrievedGoalRecords != 0){
    foreach ($retrievedGoalRecords as $row){
        $goaldate = $row['checked_date'];
        $goaldesc = $row['goal_desc'];
        if ($goaldesc == ""){
            $goaldesc = "No comments";
        }
        echo "
        <meta itemprop='datePublished' content='2018-11-28 01:19:17'><em style='color: #555;'>".$goaldate."</em><br />
        <p><span itemprop='reviewBody'>".$goaldesc."</span></p><hr>
        <meta itemprop='itemReviewed' content='Person'>";
    }
  }

}

?>