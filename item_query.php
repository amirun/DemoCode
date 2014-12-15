<?php
    include_once('../../include/connection.php');
    !empty($_POST['task'])?$task = mysqli_real_escape_string ( $con, $_POST['task'] ):$task =null;
    if($task != null){
        if($task == 'categorySelect'){
            $sql = "Select * from `category`";
            $query_result = mysqli_query($con,$sql);
            $queryallrows = mysqli_fetch_all($query_result);
            echo json_encode($queryallrows);
        }
        if($task == 'categoryInsert'){
            !empty($_POST['catEn'])?$catEn = mysqli_real_escape_string ( $con, $_POST['catEn'] ):$catEn =null;
            !empty($_POST['catHi'])?$catHi = mysqli_real_escape_string ( $con, $_POST['catHi'] ):$catHi =null;
            !empty($_POST['subEn'])?$subEn = mysqli_real_escape_string ( $con, $_POST['subEn'] ):$subEn =null;
            !empty($_POST['subHi'])?$subHi = mysqli_real_escape_string ( $con, $_POST['subHi'] ):$subHi =null;
            $sql = "INSERT INTO `category`(`category`, `category_hi`, `sub_category`, `sub_category_hi`) "
                    . "VALUES ('$catEn','$catHi','$subEn','$subHi')";
            $query_result = mysqli_query($con,$sql);
            if($query_result)
                echo "success";
            else
                echo "fail";
        }
    }
?>
