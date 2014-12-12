<?php
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page == 'addcust'){
            //header('Location: ' . "add_cust.php");
            echo "<h2>Succesfully Inserted Customer.</h2>";
            header( "refresh:2;url=add_cust.php" );
        }
        if($page == 'modcust'){
            //header('Location: ' . "add_cust.php");
            echo "<h2>Succesfully Modified Customer Details.</h2>";
            header( "refresh:2;url=modify_cust.php" );
        }
    }
?>
