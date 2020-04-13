<?php
//require_once("sessionchecker.php");
require_once("db.php");

//for creating new category
if (isset($_POST['submit']) && isset($_POST['category_name'])){
    $category_name  = $_POST['category_name'];
	
    try{
        $conn->beginTransaction();
        $insertNewCategory = insertNewCategory($conn, $category_name);
        if ($insertNewCategory[0]=="false"){
            $conn->rollBack();     
        }else{
            $conn->commit();
            header("location:admin_categories_list.php");
        }
    }
    catch(PDOException $e){
        $conn->rollback();
        echo "Error Occur>".$e;
    }

}

if (isset($_POST['updateid']) && isset($_POST['updateCategoryName'])){
    $category_id  = $_POST['updateid'];
    $category_name  = $_POST['updateCategoryName'];

    try{
        $conn->beginTransaction();
        $updateCategory = updateCategory($conn, $category_id, $category_name);
        if ($updateCategory[0]=="false"){
            $conn->rollBack();     
        }else{
            $conn->commit();
            header("location:admin_categories_list.php");
        }
    }
    catch(PDOException $e){
        $conn->rollback();
        echo "Error Occur>".$e;
    }

}

if (isset($_POST['deleteid'])){
    $category_id  = $_POST['deleteid'];
	
    try{
        $conn->beginTransaction();
        $deleteCategory = deleteCategory($conn, $category_id);
        if ($deleteCategory[0]=="false"){
            $conn->rollBack();     
        }else{
            $conn->commit();
            header("location:admin_categories_list.php");
        }
    }
    catch(PDOException $e){
        $conn->rollback();
        echo "Error Occur>".$e;
    }	
}

function insertNewCategory($conn, $category_name){

    $createdate = date("Y-m-d H:i:s"); 
    $queryIns = "INSERT INTO `categories`( `category`, `date_created`)
        VALUES (:category, :created_date)"; 
    $insert=$conn->prepare($queryIns);
    $insert->bindParam(':category', $category_name, PDO::PARAM_STR);
    $insert->bindParam(':created_date', $createdate, PDO::PARAM_STR);

    $insert->execute();

    if($insert == true){ 
        $lastinsertedrow = $conn->lastInsertId();
        return  array("true", $lastinsertedrow);
    }else{
        array("false", $lastinsertedrow); $conn->rollBack();
    }   
}

function listAllCategory($conn, $sessionid){
    $query1= "SELECT * FROM categories";
    $search=$conn->prepare($query1);
    $search->bindParam(':sid', $sessionid, PDO::PARAM_STR);
    $search->execute();
    $search1 = $search->fetchAll(PDO::FETCH_ASSOC);
    return $search1;
}

function updateCategory($conn, $category_id, $category_name){
    $updateCategory = "UPDATE `categories` SET `category`=:category WHERE `category_id` =:category_id";

        $updateTT_=$conn->prepare($updateCategory);
        $updateTT_->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $updateTT_->bindParam(':category', $category_name, PDO::PARAM_STR);
        $updateTT_->execute();
}

function deleteCategory($conn, $category_id){
    $deleteCategory = "DELETE FROM `categories` WHERE `category_id` =:category_id";
    $deleteTT_=$conn->prepare($deleteCategory);
    $deleteTT_->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $deleteTT_->execute();
}

function listCategory($conn, $category_id){
    $query1= "SELECT category FROM categories WHERE category_id = :category_id";
    $search=$conn->prepare($query1);
    $search->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $search->execute();
    $search1 = $search->fetchAll(PDO::FETCH_ASSOC);
    return $search1;
}

?>