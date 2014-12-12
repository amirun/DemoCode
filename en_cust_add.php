<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<?php
    include_once('../../include/connection.php');
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: ' . "../../index.php");
    }
    //echo '>'.empty($_POST['amtp'])."=====".empty($_POST['amtr']).'<' ;
    
    !empty($_POST['nameEn'])?$nameEn= mysqli_real_escape_string ( $con, $_POST['nameEn'] ):$nameEn='NULL';
    //!empty($_POST['nameHi'])?$nameHi= mysqli_real_escape_string ( $con, $_POST['nameHi'] ):$nameHi='NULL';
    !empty($_POST['addr'])?$addr= mysqli_real_escape_string ( $con, $_POST['addr'] ):$addr='NULL';
    !empty($_POST['local'])?$local= mysqli_real_escape_string ( $con, $_POST['local'] ):$local='NULL';
    !empty($_POST['city'])?$city= mysqli_real_escape_string ( $con, $_POST['city'] ):$city='NULL';
    !empty($_POST['vill'])?$vill= mysqli_real_escape_string ( $con, $_POST['vill'] ):$vill='NULL';
    !empty($_POST['state'])?$state= mysqli_real_escape_string ( $con, $_POST['state'] ):$state='NULL';
    !empty($_POST['pin'])?$pin= mysqli_real_escape_string ( $con, $_POST['pin'] ):$pin='NULL';
    !empty($_POST['amtp'])?$amtp= mysqli_real_escape_string ( $con, $_POST['amtp'] ):$amtp='NULL';
    !empty($_POST['amtr'])?$amtr= mysqli_real_escape_string ( $con, $_POST['amtr'] ):$amtr='NULL';
    !empty($_POST['phone'])?$phone= mysqli_real_escape_string ( $con, $_POST['phone'] ):$phone='NULL';
    !empty($_POST['comnt'])?$comnt= mysqli_real_escape_string ( $con, $_POST['comnt'] ):$comnt='NULL';
    $insertSTATUS=false;
    if($nameEn != 'NULL'){
        $get_custid = "SELECT MAX(`custid`) AS lastcust FROM `customer`";
        $query_result1 = mysqli_query($con,$get_custid);

        $next_custid = intval(mysqli_fetch_assoc($query_result1)['lastcust'])+1;
        echo 'next custid='.$next_custid;
        $insertSTATUS = TRUE;
        //echo '>'.$_POST['amtp']."=====".$_POST['amtr'].'<' ;
        $cust_insert_query="INSERT INTO `customer`(`custid`,`cust_name`, `cust_name_hi`, `amount_remaining`, `amount_payable`, `DOC`, `DOM`, `comment`, `phone`) "
                    ."VALUES ($next_custid,'$nameEn',NULL,$amtr,$amtp,CURDATE(),CURDATE(),'$comnt','$phone')";
        $query_result2 = mysqli_query($con,$cust_insert_query);
        echo 'cust_insert_query ='.$cust_insert_query;
        if(!$query_result2){
           $insertSTATUS = FALSE;
        }

        if($insertSTATUS){
            $addr_insert_query = "INSERT INTO `address`(`custid`, `address`, `locality`, `village`, `city`, `state`, `pincode`) "
                            ."VALUES ($next_custid,'$addr','$local','$vill','$city','$state','$pin')";
            $query_result3 = mysqli_query($con,$addr_insert_query);
            echo 'addr_insert_query='.$addr_insert_query;
            if(!$query_result3){
               $insertSTATUS = FALSE;
               //$_POST = array();
            }
        }
    }
    if($insertSTATUS){
        header('Location: ' . "success.php?page=addcust");
    }
?>
<head>
<title>ADD CUST PHP</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="../../js/jquery-1.11.1.min.js"></script>
<style>
    #textHi1,#textHi2{
        position: relative;
    }
    .input{
       width:250px;
       height:25px;
       border: 1px solid black;
    }
    .label{
       height:25px;
       /*border: 1px solid black;*/
       padding-top: 5px;
    }
    .asterik{
        color: red;
    }
</style>
</head>

<body>
    <div id="formDiv" style="z-index:1;position: absolute;">
        <p>ADD CUSTOMER:</p>
        <div id="labelDiv" style="float: left;">
            <div class="label">Customer Name [ENGLISH]:<span class="asterik">*</span> </div><br/>
            <!--div class="label">Customer Name [HINDI]:<span class="asterik">*</span></div><br/-->
            <div class="label">Address:<span class="asterik">*</span></div><br/>
            <div class="label">Locality:</div><br/>
            <div class="label">City: </div><br/>
            <div class="label">Village:</div><br/>
            <div class="label">State:<span class="asterik">*</span></div><br/>
            <div class="label">PINCODE:<span class="asterik">*</span></div><br/>
            <div class="label">Amount Payable:</div><br/>
            <div class="label">Amount Receive:</div><br/>
            <div class="label">Contact Phone No.:</div><br/>
            <div class="label">Comment:</div>
            <span class="asterik">*</span> Fields are mandatory 
        </div>
        <form action="add_cust.php" id="form" name="form" method="POST">
            
            <input type="text" id="nameEn" name="nameEn" class="input" maxlength="30" required />
            <br/> <br/>
            <!--input type="text" class="input" id="txtHindi" name="nameHi" onfocus="showKeyboard('txtHindi','textHi1','in');" onblur="showKeyboard('txtHindi','textHi1','out');" required />
            <div id="textHi1" style="visibility: hidden; border-collapse: collapse;float: right; "></div>
            <br/> <br/-->
            <input id="addr" name="addr" class="input" type="text" maxlength="50" required />
            <br/> <br/>
            <input id="local" name="local" class="input" type="text" maxlength="50" />
            <br/> <br/>
            <input id="city" name="city" class="input" type="text" maxlength="30" />
            <br/> <br/>
            <input id="vill" name="vill" class="input" type="text" maxlength="30" />
            <br/> <br/>
            <input id="state" name="state" class="input" type="text" maxlength="30" required />
            <br/> <br/>
            <input id="pin" name="pin" class="input" type="text"  maxlength="6" required />
            <br/> <br/>
            <input id="amtp" name="amtp" class="input" type="text"/>
            <br/> <br/>
            <input id="amtr" name="amtr" class="input" type="text"/>
            <br/> <br/>
            <input id="phone" name="phone" class="input" type="text" maxlength="40"/>
            <br/> <br/>
            <input id="comnt" name="comnt" class="input" type="text" maxlength="100"/>
        </form>
		<br/><br/>
        <button onclick="submitForm();">SUBMIT</button>
        
    </div>
    
    <script>
        function submitForm(){
                if(validator() == true)
                 $("#form").submit();
            }
            function validator(){
                valid = true;
                city = $("#city").val();
                village = $("#vill").val();
                //console.log(city.length==0+" === "+village.length==0);
                if((city.length == 0 && village.length == 0)){
                    valid=false;
                    alert("Must Enter City or Village!!!");
                }
                else if((city.length > 0 && village.length > 0)){
                    valid=false;
                    alert("Do not enter both City and Village!!!");
                }
                
                pin = $("#pin").val().toString();
                if(pin.match(/^[1-9]\d{5}/) == null){
                    valid=false;
                    alert("Invalid Pin!!!");
                }
                
                phone = $("#phone").val().toString();
                //console.log(phone.match(/[a-zA-z]/));
                if(phone.match(/[a-zA-z]/)!=null){
                    valid=false;
                    alert("Invalid Phone Number(s) entered!!!");
                }
                
                return valid;
            }
    </script>
    
</body>
</html>

