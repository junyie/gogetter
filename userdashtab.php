<?php
require_once("sessionchecker.php");
?>

<!-- tabs -->
<div class="card" style="width: 750px;">
    <div class="container1">
    <h4><?php echo " &nbsp" . date("l j<\s\up>S F Y") . "<br>";?></h4>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Today's Goal</a></li>
        <!--li ><a data-toggle="tab" href="#menu1">Today's Challenge</a></li-->
        <li><a data-toggle="tab" href="#menu2">My Profile</a></li>
        <li><a data-toggle="tab" href="#menu3">Settings</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <p><?php require_once("goaltodaylist.php");?></p>
        </div><!--end of div_id="home"-->
        <div id="menu1" class="tab-pane fade">
          <h3>Menu 1</h3>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
         <!--<h2 class="page-header">User Profile</h2>-->
         <section class="comment-list">
                      <!-- First Comment -->
                      <article class="row">
                        <div class="col-md-100 col-sm-80">
                          <div class="panel panel-default arrow left">
                            <div class="panel-body">
                              <header class="text-left">
                              <div class="comment-post">
                              <?php 
                                    echo '<div class="container" style="width: 100%;">
                                    <form action="profilehandler.php" method="post">
                                      <div class="row">

                                      <div class="row">
                                        <div class="col-25">
                                          <label for="subject">Bio data</label>
                                        </div>
                                        <div class="col-75">
                                          <textarea id="biodata" name="subject" placeholder="Write something.." style="height:200px">'.$mybiodata.'</textarea>
                                        </div>
                                      </div>
                                      <div class="row">
                                      <a href="profile.php?profile='.$s_id.'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">View my profile</a>
                                      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                      <input class="btn" type="button" value="Submit" name="submit" id = "saveusers">
                                      </div>
                                    </form>
                                  </div>';
                                    
                                    echo "<input type='hidden' name='csrf' value='$csrf'>" ;
                                    echo  "<hr>";
                                    if ( isset($_GET['fail']) && $_GET['fail'] == 1 ){
                                        echo '<script language="javascript">';
                                        echo 'alert("Only Accept PNG or JPG format with 2,000,000KB")';
                                        echo '</script>';
                                    }
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </article>      
                    </section>
        </div><!--End of div_id"menu2"-->
        <div id="menu3" class="tab-pane fade">
        <article class="row">
            <div class="col-md-2 col-sm-2 hidden-xs">   
              <form method="POST" action="upload_image.php" enctype="multipart/form-data">  
                <img class="w3-hover-opacity" width="128" height="128" id="imgFileUpload" alt="Select File" title="Select File" src="<?php echo $myprofilepic;?>" style="cursor: pointer" />
                <span id="spnFilePath"></span>
                <input type="file" name="uploaded" style="display: none">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                <input type="file" formmethod="post" name="uploaded" id="FileUpload1" style="display: none"  accept="image/x-png,image/jpeg"/>
                <h3><span class="label label-default">Profile Picture</span></h3>
                <p class="text-right"><br />
                <button type="submit" id="submit" name="Upload" formmethod="post" class="btn btn-default" aria-label="Left Align" title="Save Changes">
                <span class="far fa-save fa-lg fa-3x" aria-hidden="true"></span>
                </button> </p>  
              </form>                   
            </div>
         </article> 
        </div>
    </div>
    </div>
</div><!--div class="card" style="width: 940px;"-->
        <!-- tabs -->
        
    </div>
</div>

  
<?php
require_once("sessionchecker.php");
$resName = $_SESSION["username1"];
?>

<script type="text/javascript">
    $(function(){
        var fileupload = $("#FileUpload1");
        var filePath = $("#spnFilePath");
        var image = $("#imgFileUpload");
        image.click(function () {
            fileupload.click();
        });
        fileupload.change(function () {
            var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
            filePath.html("<b>Selected File: </b>" + fileName);
        });

        $("#saveusers").on('click', function(){
            var biodata       = $("#biodata").val();

            $.ajax({
              method: "POST",
              url:    "profilehandler.php",
              data: { "subject": biodata},
             }).done(function( data ) {
                var result = $.parseJSON(data);
                var str = '';
                var cls = '';
                if(result == 1) {
                  str = 'User record saved successfully.';
                  cls = 'success';
                }else{
                  str = 'User data could not be saved. Please try again';
                  cls = 'error';
                }
              //$("#message").show(3000).html(str).addClass('success').hide(5000);
          });
       });
     });

  </script>

<link rel="stylesheet" type="text/css" href="css/tab_style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>