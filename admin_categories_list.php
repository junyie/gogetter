<?php
 require_once("sessionchecker.php");
$query = "SELECT * FROM `categories`"; 
$searchcateg=$conn->prepare($query);
$searchcateg->execute();
$totalcateg = $searchcateg->rowCount();
$totalresult='0';


?>

<html>
<?php require_once("userdash_searchheader.html");?>  
<head><title>Category Lists - GoGetter</title></head> 
<body>

<!-- Navbar -->
<?php require_once("userdashnav2.html"); ?>
  <div style="padding-right: 89px; padding-left: 89px; padding-bottom: 5px;">
        <ul class="breadcrumb" style="margin: 0px !important">
            <li><a data-ajax="false" href="index.php"><i class="fa fa-home"></i></a></li>
            <li><a data-ajax="false" href="admin_dashboard.php">DASHBOARD</a></li>
            <li><a data-ajax="false" href="admin_categories_list.php">CATEGORY LISTS</a></li>
        </ul>
    </div>

  <div style="padding-right: 89px; padding-left: 89px; padding-bottom: 5px;"><h1 align="center">Category Lists</h1>
    <input type="button" value="Back" onclick="window.location.href = 'admin_dashboard.php'" style="float: right;">
    <input type="button" value="Create New" id="createNew" style="float: right;">
  </div>
    

  </div>
   <div id="hello1">
  <div data-role="main" class="ui-content">
    <form method="post" action="admin_categories_form.php"  class="search-container" data-ajax="false">
    <div id="box">
      <label for="usr">Lists</label>
        <?php require_once("admin_categories_controller.php");

        $s_id = $_SESSION["admin_identity"];
        $category_results = listAllCategory($conn, $s_id);

        foreach($category_results as $category_result){
            echo '<input type="hidden" name="category_id" id="'.$category_result['category_id'].'" value="'.$category_result['category_id'].'">';
			//echo "<script>console.log(".$category_result['category_id']."); </script>"; 
            $category_name = $category_result['category'];
            echo $category_name. '<button class="update" type="button" name="update" id="'.$category_result['category_id'].'">Update</button>';
            echo '<button class="delete" type="button" name="delete" id="'.$category_result['category_id'].'">Delete</button>';
        }

        ?> 
    </div>
        
        
      </form>
  </div>
  <div>
  </div>
  
</div> 
</body>

<script>
  // delete function
$(document).ready(function(){
$(".delete").click(function(){
	var id = $(this).attr("id");
	$.ajax(
		{
		url: "admin_categories_controller.php",
		type: "POST",

		data: { deleteid: id},
		success: function (result) {
				alert('Record Deleted!');
				location.reload(true);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			alert("Delete fail");
		}
	});     
});
});	


//pass the id that selected
$(document).ready(function(){
$(".update").click(function(){
	var id = $(this).attr("id");
	var queryString = "?uid="+id;
	window.location.href = "admin_categories_form.php"+queryString;
});
});	

//lead to create categories page
    var createBtn = document.getElementById('createNew');
    createBtn.addEventListener('click', function() {
      document.location.href = 'admin_categories_form.php';
    });
  </script>
</html>