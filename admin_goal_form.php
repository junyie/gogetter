<?php
require_once("relationshipcontroller.php");
require_once("admin_categories_controller.php");
require_once("admin_goal_controller.php");


if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
	echo '<script>console.log("'.$uid.'"); </script>';
}
?>

    <head>
    <!-- Title Page-->
    <title>Goal Section - GoGetter</title>
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
    <?php require_once("userdashnav2.html"); ?>
    <!--
<div class="w3-bar w3-blue w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>

    <a href="index.php" style="background-color: #d5f4e6;" class="w3-bar-item w3-button w3-padding-large"><img src="uploads/gogetter.png" style="width:180px; height:40px" title="GoGetter" alt="GoGetter"></a>
    <div class="topnav" style="float: right">
    <div class="login-container w3-hide-small">
    <form action="#" data-ajax="false">
    <a href="userdashboard.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small" data-ajax="false">Main Menu</a>
      </form>
    </div></div>
      </div>-->
    <div style="padding-right: 89px; padding-left: 89px; padding-bottom: 5px; background-color: #e5e5e5">
        <ul class="breadcrumb" style="margin: 0px !important">
            <li><a href="index.php"><i class="fa fa-home"></i> / </a></li>
            <li><a href="admin_dashboard.php"> DASHBOARD / </a></li>
            <li><a href="admin_goal.php">GOAL SECTION</a></li>
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
                            <h3 class="text-center title-2">Goal Section</h3></div>
                        <div class="card-body">
                            
                            <form action="admin_goal_controller.php" method="post" novalidate="novalidate" enctype="multipart/form-data">
								<div id="image_preview"><img id="previewing" src="noimage.png" /></div></br>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="file" class=" form-control-label">Goal Image</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="file" name="file" class="form-control-file" accept="image/*">
                                    </div>
                                 </div>

                                <div class="form-group has-success">
                                    <label for="cc-name" class="control-label mb-1">Goal Name</label>
                                    <input id="goals_name" name="goals_name" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                </div>

                                <div class="form-group">
                                        <label for="cc-name" class="control-label mb-1">Goal Description</label>
                                        <textarea rows = "5" cols = "60" id="goal_description" name="goal_description" type="tel" class="form-control cc-number identified visa" value="" data-val="true" data-val-required="Please enter the card number" data-val-cc-number="Please enter a valid card number" autocomplete="cc-number"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="cc-name" class="control-label mb-1">Goal Category</label>
                                    
                                    <select name="category" id="category">
                                        <option value="">---Please Select the Category---</option>
                                        
                                        <?php
                                        $category_lists = listAllCategory($conn, $s_id);
                                        // echo  '<pre>';
                                        // print_r($category_lists);
                                        // echo '</pre>';

                                        foreach($category_lists as $category_list){
                                            echo '<option name="category_id" value="'.$category_list['category_id'].'">'.$category_list['category'].'</option>';
                                        }

                                        ?>

                                    </select>
     
                                        
                                </div>

                               
                                <div>
                                    <!-- <button type="submit" class="btn btn-lg btn-info btn-block" name="submit">
                                        <i class="fa fa-share fa-lg"></i>&nbsp; -->
                                        <?php
                                            if(isset($uid)){
											echo '<input type="hidden" name="updateid" id="updateid" value="'.$uid.'">';
                                            echo '<button class="update btn btn-lg btn-info btn-block" type="submit" name="update" id="'.$uid.'">Update</button>';
                                            echo '<span id="payment-button-sending" style="display:none;">Sending…</span>';
                                                                                    
                                            }else{
                                            echo '<button type="submit" class="btn btn-lg btn-info btn-block" name="submit">';
                                            echo '<span id="payment-button-amount">Create Goal</span>';
                                            echo '<span id="payment-button-sending" style="display:none;">Sending…</span>';
                                            echo '</button>';
                                        
                                            }

                                        ?>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                    </button>
                                </div>
                                
                                <br>
                                
                                <div>
                                        <button id="payment-button" type="button" class="btn btn-lg btn-danger btn-block" onclick="window.location.href = 'admin_goal_list.php';" >
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
    //update function
    $(document).ready(function(){
		// Function to preview image after validation
		$(function() {
		$("#file").change(function() {
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
		$('#previewing').attr('src','noimage.png');
		$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
		return false;
		}
		else
		{
		var reader = new FileReader();
		reader.onload = imageIsLoaded;
		reader.readAsDataURL(this.files[0]);
		}
		});
		});
		function imageIsLoaded(e) {
		$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
		};
		/*
        $(".update").click(function(){
            var id = $(this).attr("id");
            var goalName = $("#goals_name").val();
            var goalDescription = $("#goal_description").val();
            var goalCategory = $("#category").val();
            console.log(id);
            console.log(goalName);
            console.log(goalDescription);
            console.log(goalCategory);

            $.ajax(
                {
                url: "admin_goal_controller.php",
                type: "POST",

                data: { updateid: id, updategoalName: goalName, updateGoalDescription: goalDescription, updateGoalCategory: goalCategory},
                success: function (result) {
                        alert('Record Updated!');
                        window.location.href = 'admin_goal_list.php';
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Update fail");
                }
            });     
        });
		*/
    });	

    </script>

