<!-- tabs -->
<div class="card" style="width: 750px;">
    <div class="container1">
        <h4><?php echo " &nbsp Challenges <br>";?></h4>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Current Challenges</a></li>
            <li><a data-toggle="tab" href="#menu1">Challenges in the past</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <p><?php require_once("challenginglist.php");
                ?></p>
            </div><!--end of div_id="home"-->
            <div id="menu1" class="tab-pane fade">
            <p><?php require_once("challenginglistpast.php");

                ?></p>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<link rel="stylesheet" type="text/css" href="css/tab_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>