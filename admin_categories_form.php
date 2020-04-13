<?php
require_once("admin_categories_controller.php");
require_once("sessionchecker.php");

$resName = $_SESSION["admin_username"];


if(isset($_GET['uid'])){
	$uid = $_GET['uid'];
	echo '<script>console.log("'.$uid.'"); </script>';
	echo $uid;
}

?>

<head>
    <!-- Title Page-->
    <title>Category Section - GoGetter</title>
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
            <li><a data-ajax="false" href="index.php"><i class="fa fa-home"></i> / </a></li>
            <li><a data-ajax="false" href="admin_dashboard.php"> DASHBOARD / </a></li>
            <li><a data-ajax="false" href="admin_categories.php">CATEGORY SECTION</a></li>
        </ul>
    </div>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <div class="center">
        <div class="container-fluid" style="padding: 50px;">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card text-center offset-*" style="height:97%">
                        <div class="card-header">
                            <h3 class="text-center title-2">Category Section</h3>
                        </div>
                        <div class="card-body">
                 
                        <form action="admin_categories_controller.php" method="post" novalidate="novalidate">
                                
                                <div>
                                    <!-- Category name field -->
                                    <div class="form-group has-success">
                                        <label for="cc-name" class="control-label mb-1">Category Name</label>
                                        <input id="category_name" name="category_name" type="text" class="form-control cc-name valid" data-val="true" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                    </div>

                                    <?php
                                        if(isset($uid)){
                                            echo '<button class="update btn btn-lg btn-info btn-block" type="button" name="update" id="'.$uid.'">Update</button>';
                                            echo '<span id="payment-button-sending" style="display:none;">Sending…</span>';
                                            
                                        }else{
                                            echo '<button type="submit" class="btn btn-lg btn-info btn-block" name="submit">';
                                            echo '<span id="payment-button-amount">Create Category</span>';
                                            echo '<span id="payment-button-sending" style="display:none;">Sending…</span>';
                                            echo '</button>';

                                        }
                                    ?>
                                    


                                    
                                </div>
                                <br>
                                <div>
                                        <button id="payment-button" type="button" class="btn btn-lg btn-danger btn-block" onclick="window.location.href = 'admin_categories_list.php';" >
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
    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
    <script>
        //update function
        $(document).ready(function(){
		/*	
		var queryString = decodeURIComponent(window.location.search);
		queryString = queryString.substring(1);
		var queries = queryString.split("&");
		for (var i = 0; i < queries.length; i++)
		{
		  console.log(queries[i]);
		}
		*/
        $(".update").click(function(){
            var id = $(this).attr("id");
            var categoryName = $("#category_name").val();
            console.log(categoryName);
            console.log(id);
            $.ajax(
                {
                url: "admin_categories_controller.php",
                type: "POST",

                data: { updateid: id, updateCategoryName: categoryName},
                success: function (result) {
                        alert('Record Updated!');
                        window.location.href = 'admin_categories_list.php';
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Update fail");
                }
            });     
        });
        });	
    </script>


