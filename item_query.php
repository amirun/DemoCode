<?php
    include_once('../../include/connection.php');
    !empty($_POST['task'])?$task = mysqli_real_escape_string ( $con, $_POST['task'] ):$task =null;
    if($task != null){
        if($task == 'categorySelect'){
            $sql = "SELECT DISTINCT(`category`) FROM `category` ";
            $query_result = mysqli_query($con,$sql);
            $queryallrows = mysqli_fetch_all($query_result);
            echo json_encode($queryallrows);
        }
		else if($task == 'getSubCat'){
			$category = mysqli_real_escape_string ( $con, $_POST['category'] );
			$sql = "SELECT * FROM `category` WHERE `category` = '$category'";
			$query_result = mysqli_query($con,$sql);
            $queryallrows = mysqli_fetch_all($query_result);
            echo json_encode($queryallrows);
		}
        else if($task == 'categoryInsert'){
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
	else{
		!empty($_POST['nameEn'])?$nameEn = mysqli_real_escape_string ( $con, $_POST['nameEn'] ):$nameEn =null;
		!empty($_POST['txtHindi3'])?$nameHi = "'".mysqli_real_escape_string ( $con, $_POST['txtHindi3'] )."'":$nameHi = 'NULL';
		!empty($_POST['subID'])?$catID = mysqli_real_escape_string ( $con, $_POST['subID'] ):$catID =null;
		!empty($_POST['cost'])?$cost = mysqli_real_escape_string ( $con, $_POST['cost'] ):$cost =null;
		if($nameEn!=null){
			$sql = "INSERT INTO `item`(`item_name`, `item_name_hi`, `categoryid`, `cost_price`, `DOC`, `DOM`) "
					." VALUES ('$nameEn',$nameHi,$catID,$cost,CURDATE(),CURDATE())";
			$query_result = mysqli_query($con,$sql);
            if($query_result){
				echo "ITEM INSERTED SUCCESSFULLY";
                header( "refresh:2;url=add_item.php" );
			}
		}
	}
?>
