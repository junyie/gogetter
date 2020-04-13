<?php 
 require_once("userdashheader.html");
 require_once('db.php');

 $resName = $_SESSION["admin_username"];

echo '
<div class="container" style="background-color: #f2f2f2; padding-top: 20px;">
<div class="row">
    <div class="col-sm-3">
    
        <ul class="nav nav-pills nav-stacked nav-email shadow mb-20">
            <li class="active">
                <a href="userdashboard.php">
				'.$resName.'
                </a>
            </li>

            <li>
                <a href="admin_goal.php"> <i class="fa fa-plus-square"></i> New Goal</a>
			</li>
			
			<li>
				<a href="admin_goal_list.php"> <i class="fa fa-calendar-o"></i>Goal List</a>
			</li>

			<li>
                <a href="admin_categories.php"> <i class="fa fa-plus-square"></i>New Category</a>
			</li>
			
			<li>
				<a href="admin_categories_list.php"> <i class="fa fa-calendar-o"></i>Category List</a>
			</li>
            
            <li>
            <a href="logout.php"> <i class="fa fa-sign-out"></i> Exit</a></li>
           
        </ul><!-- /.nav -->
    </div>
    <div class="col-sm-9">

        <!--  Another part for Nav -->
        <div class="row">
 
			
        </div>';


 ?>