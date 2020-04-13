<?php
require_once("relationshipcontroller.php");

$resName = $_SESSION["username1"];
if ($mytotalfriend >0){
   $showmytotalfriend = $mytotalfriend;
}else {$showmytotalfriend ="";
    header("location:searching.php");}
?>
<!DOCTYPE html>
 
<meta charset="UTF-8">
<html>
    <head>
    <!-- Title Page-->
    <title>Create Challenge - GoGetter</title>
</head>
<style>
.center {
  margin: auto;
  width: 60%;
  /*height:100%;*/
  border: 3px;
  padding: 10px;
}/* solid #73AD21*/
</style>

    
    <!-- Fontfaces CSS
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="css/w3_2.css">


<body class="animsition">
    <!-- Navbar -->
    <?php require_once("userdashnav2.html"); ?>
<!--<div class="w3-bar w3-blue w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <!--<a href="index.php" class="w3-bar-item w3-button w3-padding-large" data-ajax="false"><img src="uploads/gogetter.png" style="width:180px; height:40px" title="GoGetter" alt="GoGetter"></a>->
    <a href="index.php" style="background-color: #d5f4e6;" class="w3-bar-item w3-button w3-padding-large"><img src="uploads/gogetter.png" style="width:180px; height:40px" title="GoGetter" alt="GoGetter"></a>
    <div class="topnav" style="float: right">
    <div class="login-container w3-hide-small">
    <form action="#" data-ajax="false">
    <a href="userdashboard.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small" data-ajax="false">Main Menu</a>
      </form>
    </div></div>
      </div>-->
    <div style="margin-right: 89px; margin-left: 89px; margin-bottom: 5px;">
        <ul class="breadcrumb" style="margin: 0px !important">
            <li><a data-ajax="false" href="index.php"><i class="fa fa-home"></i> / </a></li>
            <li><a data-ajax="false" href="userdashboard.php"> DASHBOARD / </a></li>
            <li><a data-ajax="false" href="createchallenge.php"> CREATE NEW CHALLENGE</a></li>
        </ul>
    </div>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <div class="center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card text-center offset-*" style="height:97%">
                        <div class="card-header">
                            <h3 class="text-center title-2">Create New Challenge</h3></div>
                        <div class="card-body">
                            
                            <form action="challengehandler.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="file-input" class=" form-control-label">Image input</label>
                                          </div>
                                           <div class="col-12 col-md-9">
                                         <input type="file" id="file-input" name="uploadedc" class="form-control-file" accept="image/*">
                                     </div>
                                 </div>
                                <div class="form-group has-success">
                                    <label for="cc-name" class="control-label mb-1">Name of Challenge</label>
                                    <input id="c_challangename" name="c_challangename" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                </div>
                                <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Reward</label>
                                        <input type="hidden" name="mypoints" id="mypoints" value="<?php echo $mypoints?>" />
                                        <input data-ajax="false" id="c_payment" onkeyup="checkIfValuenotSmallerthanDateRange()" placeholder="0.00" name="c_payment" type="number" class="form-control" aria-required="true" aria-invalid="false" value="">
                                </div>
                                <div class="form-group">
                                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Add Description</button>
                                        <div id="demo" class="collapse">
                                            <textarea rows = "5" cols = "60"id="cc-number" name="c_describe" type="tel" class="form-control cc-number identified visa" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" autocomplete="cc-number"></textarea><br>
                                        </div>
                                </div>
                                <div class="form-group ">
                                    <label for="cc-payment" class="control-label mb-1" style="float: left; padding-left: 50px;">Invite Expiration</label>
                                    <input id="c_expiredate_err" style="color: red; width: 70%;" type="text"> </input>
                                    </label>
                                                <div class="col-sm-10">
                                                <div class="input-group">
                                                <div class="input-group-addon">
                                            <div class="fa fa-calendar">📅
                                           </div>
                                          </div>
                                    <input class="form-control" id="c_expiredate" name="c_expiredate" placeholder="DD/MM/YYYY" type="date" />
                                  </div>
                                </div>
                                <div class="form-group ">
                                    <label for="cc-payment" class="control-label mb-1" style="float: left; padding-left: 50px;">Challenge Start Day</label>
                                    <input id="c_startdate_err" style="color: red; width: 70%;" type="text"> </input>
                                    </label>
                                                <div class="col-sm-10">
                                                <div class="input-group">
                                                <div class="input-group-addon">
                                            <div class="fa fa-calendar">📅
                                           </div>
                                          </div>
                                    <input class="form-control" id="c_startdate" name="c_startdate" placeholder="DD/MM/YYYY" type="date" />
                                  </div>
                                </div>
                                <div class="form-group ">
                                    <label for="cc-payment" class="control-label mb-1" style="float: left; padding-left: 50px;">Due Date</label>
                                    <input id="c_duedate_err" style="color: red; width: 70%;" type="text"> </input>
                                    </label>
                                                <div class="col-sm-10">
                                                <div class="input-group">
                                                <div class="input-group-addon">
                                            <div class="fa fa-calendar">📅
                                           </div>
                                          </div>
                                    <input class="form-control" id="c_duedate" name="c_duedate" placeholder="DD/MM/YYYY" type="date" />
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Select Challenger 2</label>
                                            <select name="c_ppl1" class="form-control" id="c_ppl1">
                                              <option>None</option>
                                              <?php showListOfFriends($result,$result2) ?>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Select Challenger 3</label>
                                            <select name="c_ppl2" class="form-control" id="c_ppl2">
                                              <option>None</option>
                                              <?php showListOfFriends($result,$result2) ?>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Select Challenger 4</label>
                                            <select name="c_ppl3" class="form-control" id="c_ppl3">
                                              <option>None</option>
                                              <?php showListOfFriends($result,$result2) ?>
                                            </select>
                                          </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Select Challenger 5</label>
                                            <select name="c_ppl4" class="form-control" id="c_ppl4">
                                              <option>None</option>
                                              <?php showListOfFriends($result,$result2) ?>
                                            </select>
                                          </div>
                                    </div>
                                </div>
                                <div>
                                    <button onkeyup="success()" id="submit" disabled type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                                        <i class="fa fa-share fa-lg"></i>&nbsp;
                                        <span id="payment-button-amount">Send Invitation</span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                    </button>
                                </div>
                                <div>
                                        <button id="payment-button" type="button" class="btn btn-lg btn-danger btn-block" onclick="window.location.href = 'userdashboard.php';" >
                                            <i class="fa fa-times fa-lg"></i>&nbsp;
                                            <span id="payment-button-amount">Cancel</span>
                                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                                        </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
    </div>
</body>
</html>
    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script>

    function checkIfValuenotSmallerthanDateRange(){
        console.log("bello");
        var value1 = parseInt(document.getElementById("c_payment").value);
        var value2 = parseInt(document.getElementById("mypoints").value);
        if (!isNaN(document.getElementById("c_payment").value)){
            if (value1 > value2){ $("#c_payment").val(value2);
                console.log("bigger than val2="+ value1 +"    value2="+ value2);  
            }
        }
    }
 //focus(function() {  .focusout(function() { .mouseleave(function() {
    $( "#c_payment" ).change(function() {    
    checkIfValuenotSmallerthanDateRange();  
    success();
    });
    $( "#c_expiredate" ).change(function() {    
    checkIfValuenotSmallerthanDateRange();  
    success();
    });
    $( "#c_duedate" ).change(function() {    
    checkIfValuenotSmallerthanDateRange();  
    success();
    });
    $( "#c_startdate" ).change(function() {    
    checkIfValuenotSmallerthanDateRange();  
    success();
    });
    $( "#c_challangename" ).change(function() {    
    success();
    });
    $( "#c_ppl1" ).change(function() {    
    success();
    });
    $( "#c_payment" ).mouseleave(function() {  
    checkIfValuenotSmallerthanDateRange();  
    success();
    });
    $( "#c_payment" ).focus(function() {
        checkIfValuenotSmallerthanDateRange();
        success();
    });

    /*$("submit").change(function(){
        differentChallenger();
    });*/

//c_challangename  c_ppl1   || document.getElementById("c_ppl1").value==="None"
    function success() { 
	 if(document.getElementById("c_expiredate").value==="" || document.getElementById("c_startdate").value==="" || 
     document.getElementById("c_duedate").value==="" || isNaN(document.getElementById("c_payment").value) ||
     document.getElementById("c_payment").value==="" || document.getElementById("c_payment").value < 0 
        || document.getElementById("c_challangename").value==="" ) { 
            document.getElementById('submit').disabled = true;
            if(document.getElementById("c_expiredate").value==="" || document.getElementById("c_startdate").value==="None" || 
                 document.getElementById("c_duedate").value===""){
            }else{//document.getElementById("alart").style.display = "block";
            }            
        } else { 
            console.log("Yes");
            document.getElementById('submit').disabled = false;
           // document.getElementById("alart").style.display = "none";
        }
        
    }

    //validation date
    $("#c_duedate").change(function () {
        var startDate = document.getElementById("c_startdate").value;
        var expireDate = document.getElementById("c_expiredate").value;
        var endDate = document.getElementById("c_duedate").value;

        if ((Date.parse(startDate) >= Date.parse(endDate))) {
            document.getElementById("c_duedate_err").value = "End date should be greater than Start date";
            document.getElementById("c_duedate").value = "";
        }
        else if(Date.parse(expireDate) >= Date.parse(endDate)){
            document.getElementById("c_duedate_err").value = "End date should be greater than Expiration date";
            document.getElementById("c_duedate").value = "";
        }else{
            document.getElementById("c_duedate_err").value = "";
        }
    });

    $("#c_expiredate").change(function(){
        var startDate = document.getElementById("c_startdate").value;
        var expireDate = document.getElementById("c_expiredate").value;

        if(Date.parse(startDate) < Date.parse(expireDate)){
            document.getElementById("c_expiredate_err").value = "Expiration date accept only before or equal Start Date";
            document.getElementById("c_expiredate").value = "";
        }
    });

    $("#c_startdate").change(function(){
        var startDate = document.getElementById("c_startdate").value;
        var expireDate = document.getElementById("c_expiredate").value;

        if(Date.parse(startDate) < Date.parse(expireDate)){
            document.getElementById("c_startdate_err").value = "";
            if (Date.parse(startDate) !=  Date.parse(expireDate)){
            document.getElementById("c_startdate_err").value = "Start date should be greater than Expiration Date";
            document.getElementById("c_startdate").value = "";}
        }
    });

    //validate select challenger, first challenger selected only can select the next challenger
    $("select").click(function() { 
        var value = $(this).val(); 
        $("select").not(this).find("option[value ="+value+"]").attr('disabled',true);//.remove(); //.prop('disabled', true);
        $("select").not(this).selectpicker('refresh');
    }); 

    //select challenger
    $(function () {
        var sel_c_ppl2 = $('select[name="c_ppl2"]');
        sel_c_ppl2.prop('disabled', true); //disable c_ppl2 select
        $('select[name ="c_ppl1"]').change(function () {
        sel_c_ppl2.prop('disabled', false); //enable when value of c_ppl1 select is changed
        });
    });

    $(function () {
        var sel_c_ppl3 = $('select[name="c_ppl3"]');
        sel_c_ppl3.prop('disabled', true); //disable c_ppl3 select
        $('select[name ="c_ppl2"]').change(function () {
        sel_c_ppl3.prop('disabled', false); //enable when value of c_ppl2 select is changed
        });
    });

    $(function () {
        var sel_c_ppl4 = $('select[name="c_ppl4"]');
        sel_c_ppl4.prop('disabled', true); //disable c_ppl4 select
        $('select[name ="c_ppl3"]').change(function () {
        sel_c_ppl4.prop('disabled', false); //enable when value of c_ppl3 select is changed
        });
    });

    </script>

