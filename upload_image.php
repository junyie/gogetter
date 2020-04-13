<?php
require_once("sessionchecker.php");
debugPost();


if (isset($_POST['Upload'])) {
    //echo "heyyay";
    /**/$uploaded_name = $_FILES[ 'uploaded' ][ 'name' ];
        $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
    /**/$uploaded_size = $_FILES[ 'uploaded' ][ 'size' ];
    /**/$uploaded_type = $_FILES[ 'uploaded' ][ 'type' ];
    /**/$uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ];
    
        // Where are we going to be writing to?
        $target_path   = 'uploads/';
    //    $target_file   = basename( $uploaded_name, '.' . $uploaded_ext ) . '-';
        $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
        $temp_file     = $target_path; 
    /**/$temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
    
    
    if( ( strtolower( $uploaded_ext ) == 'jpg'  || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) 
        && ( $uploaded_size < 2000000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) 
        && getimagesize( $uploaded_tmp ) ) {
        // Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD)
        if( $uploaded_type == 'image/jpeg' ) {
            $img = imagecreatefromjpeg( $uploaded_tmp );
            imagejpeg( $img, $temp_file, 100);
        }
        else {
            $img = imagecreatefrompng( $uploaded_tmp );
            imagepng( $img, $temp_file, 9);
        }
        imagedestroy( $img );
    
        // Can we move the file to the web root from the temp folder?
        if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file ) ) ) {
            // Yes!
            try{
                if ($_SESSION["identity"] ===$s_id){
                    $stmt_FIND = $conn->prepare("SELECT `uprof_pic` FROM `user`  WHERE `user_id` =:id");
                    $stmt_t = $conn->prepare("UPDATE `user` SET `uprof_pic`=:pic WHERE `user_id` =:id");
                    $stmt_t->bindParam(':pic', $target_file , PDO::PARAM_STR);
                    $stmt_t->bindParam(':id', $_SESSION["identity"] , PDO::PARAM_STR);
                    $stmt_FIND ->bindParam(':id', $_SESSION["identity"] , PDO::PARAM_STR);
                    $stmt_FIND->execute();
                    $stmt_t->execute();
                    $res = $stmt_FIND->fetch(PDO::FETCH_ASSOC);
                    $del = $target_path;                        //delete path set
                    $del .=$res['uprof_pic'];
                 }
                }
                    catch(PDOException $e){
                    {
                    echo "Error: " . $e->getMessage();
                    }
                  }
            if( file_exists( $del ) && $del != "uploads/default.jpg"){
              unlink( $del );  
            }
            
          // execute query
          header('location: userdashboard.php');
                }
        else {
            // No
            header('location: error.php');
        }
        echo $uploaded_tmp;
        // Delete any temp files
        if( file_exists( $temp_file ))
            unlink( $temp_file );
    }
        else {
        // Invalid file
    /**/  header('location: error.php');
    }
}  /*Upload for user profile image end */

/*upload for challenge picture */

    if (isset($_FILES['uploadedc']) && $_SESSION['post_challid_result'] !="false" && isset($_SESSION['post_challid']) ) {
        //echo "heyyay";
        /**/$uploaded_name = $_FILES[ 'uploadedc' ][ 'name' ];
            $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
        /**/$uploaded_size = $_FILES[ 'uploadedc' ][ 'size' ];
        /**/$uploaded_type = $_FILES[ 'uploadedc' ][ 'type' ];
        /**/$uploaded_tmp  = $_FILES[ 'uploadedc' ][ 'tmp_name' ];
        
            // Where are we going to be writing to?
            $target_path   = 'uploads/';
        //    $target_file   = basename( $uploaded_name, '.' . $uploaded_ext ) . '-';
            $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
            $temp_file     = $target_path; 
        /**/$temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
        
        
        if( ( strtolower( $uploaded_ext ) == 'jpg'  || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) 
            && ( $uploaded_size < 2000000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) 
            && getimagesize( $uploaded_tmp ) ) {
            // Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD)
            if( $uploaded_type == 'image/jpeg' ) {
                $img = imagecreatefromjpeg( $uploaded_tmp );
                imagejpeg( $img, $temp_file, 100);
            }
            else {
                $img = imagecreatefrompng( $uploaded_tmp );
                imagepng( $img, $temp_file, 9);
            }
            imagedestroy( $img );
        
            // Can we move the file to the web root from the temp folder?
            if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file ))) {
                // Yes!
                try{
                    if ($_SESSION["identity"] ===$s_id){
                        $stmt_t = $conn->prepare("UPDATE `challenges` SET `chall_picture`=:pic WHERE `chall_id` =:cid");
                        $stmt_t->bindParam(':pic', $target_file , PDO::PARAM_STR);
                        $stmt_t->bindParam(':cid', $_SESSION['post_challid']  , PDO::PARAM_STR);
                        $stmt_t->execute();
                        echo "running update". $_SESSION['post_challid'];
                        }
                    }
                    catch(PDOException $e){
                        echo "Error: " . $e->getMessage();
                    }
            }
        }
    }

//code for uploading the goal image
if (isset($_FILES['goal_image']) && isset($_SESSION['post_goal_id'])) {
    //echo "heyyay";
    /**/$uploaded_name = $_FILES[ 'goal_image' ][ 'name' ];
        $uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1);
    /**/$uploaded_size = $_FILES[ 'goal_image' ][ 'size' ];
    /**/$uploaded_type = $_FILES[ 'goal_image' ][ 'type' ];
    /**/$uploaded_tmp  = $_FILES[ 'goal_image' ][ 'tmp_name' ];
    
        // Where are we going to be writing to?
        $target_path   = 'uploads/';
    //    $target_file   = basename( $uploaded_name, '.' . $uploaded_ext ) . '-';
        $target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
        $temp_file     = $target_path; 
    /**/$temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
    
    
    if( ( strtolower( $uploaded_ext ) == 'jpg'  || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) 
        && ( $uploaded_size < 2000000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) 
        && getimagesize( $uploaded_tmp ) ) {
        // Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD)
        if( $uploaded_type == 'image/jpeg' ) {
            $img = imagecreatefromjpeg( $uploaded_tmp );
            imagejpeg( $img, $temp_file, 100);
        }
        else {
            $img = imagecreatefrompng( $uploaded_tmp );
            imagepng( $img, $temp_file, 9);
        }
        imagedestroy( $img );
    
        // Can we move the file to the web root from the temp folder?
        if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file ))) {
            // Yes!
            try{
                if ($_SESSION["identity"] ===$s_id){
                    $stmt_t = $conn->prepare("UPDATE `common_goals` SET `goals_picture`=:pic WHERE `goals_id` =:cid");
                    $stmt_t->bindParam(':pic', $target_file , PDO::PARAM_STR);
                    $stmt_t->bindParam(':cid', $_SESSION['goals_id']  , PDO::PARAM_STR);
                    $stmt_t->execute();
                    echo "running update". $_SESSION['goals_id'];
                    }
                }
                catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                }
        }
    }
}



?>