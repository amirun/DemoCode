<?php
    include_once('../../include/connection.php');
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: ' . "../../index.php");
    }
    !empty($_POST['input'])?$input = mysqli_real_escape_string($con,$_POST['input']):$input=null;
    //echo "input:".$input;
    $query_result = null;
    $result_rows = 0;
    if($input != null){
        $sql = "Select * from customer c, address a where c.custid = a.custid and ".(is_numeric($input)?"c.custid = '$input'":"cust_name like '%$input%'");
        //echo $sql;
    /* @var $query_result type */
        $query_result = mysqli_query($con,$sql);
        $result_rows = mysqli_num_rows($query_result);
//        echo $result_rows;
    }
//        echo "ROWS RETURNED:".mysqli_num_rows($query_result);
//        if(mysqli_num_rows($query_result)>1){
//            echo "<table>";
//            while ($row = mysqli_fetch_row($query_result)) {
//                echo "<tr><td>";
//                echo implode("</td><td>",$row)."</td>";
//                echo "</tr>";
//            }
//            echo "</table>";
//        }
//        else if(true)
//        {
//        
//        }
        
   
?>
<html>
    <head>
        <script type="text/javascript" src="../../js/jquery-1.11.1.min.js"></script>
        <style>
            table{
                border-collapse: collapse;
            }
            td{
                border: 1px solid black;
                padding: 2px;
                 /*border-collapse: collapse;*/
            }
            /*  Define the background color for all the ODD background rows  */
            table tr:nth-child(odd){ 
                background: #b8d1f3;
            }
            /*  Define the background color for all the EVEN background rows  */
            table tr:nth-child(even){
                background: #dae5f4;
            }
            #headRow tr{
                font-size: 20px; font-weight: bold; background-color: #d6d6d6;
            }
            input{
                width:250px;
                height:25px;
             }
            input[readonly]{
                cursor: pointer;
                background-color: lightgrey;
            }
        </style>
    </head>
    <body>
        <form action="modify_cust.php" method="POST" id="form">
            Enter Customer name/id: <input id="input" name="input" type="text"/>
            <input type="submit"/>
        </form>
        <div>
            <?php
                if($result_rows > 1)
                    echo '<p><h3>Multiple Results for entered value. Click on ony customer to edit.</h3></p>';
                else if($result_rows == 1)
                    echo '<p><h3>Modify Required Customer Data.</h3></p>';
                    //echo '<p><h3>'.($result_rows>1?'Multiple Results for entered value.':'').'</h3></p>';
            ?>
            <form id="modify">
            <table id="result">
            <?php
                if($input!=null){
                    
                    if($result_rows>1){
                        echo '<thead id="headRow" style="font-size: 20px; font-weight: bold; background-color: #d6d6d6;">';                        
                        echo "<td>Cutomer ID</td>";
                        echo "<td>Name</td>";
                        echo "<td>Amount Remaining</td>";
                        echo "<td>Amount Payable</td>";
                        echo "<td>Created On</td>";
                        echo "<td>Address</td>";
                        echo "<td>Locality</td>";
                        echo "<td>Village</td>";
                        echo "<td>City</td>";
                        echo "<td>State</td>";
                        echo "<td>Pincode</td>";
                        echo "<td>Phone</td>";
                        echo "<td>Comment</td>";
                        echo "</thead>";
                        
                        while ($row = mysqli_fetch_assoc($query_result)) {
                            echo '<tr onclick="selectThis('.$row["custid"].')">';
                            echo '<td>'.$row["custid"].'</td>';
                            echo '<td>'.$row['cust_name'].'</td>';
                            //echo '<td>'.$row[''].'</td>';
                            echo '<td>'.$row['amount_remaining'].'</td>';
                            echo '<td>'.$row['amount_payable'].'</td>';
                            echo '<td>'.$row['DOC'].'</td>';
                            echo '<td>'.$row['address'].'</td>';
                            echo '<td>'.$row['locality'].'</td>';
                            echo '<td>'.$row['village'].'</td>';
                            echo '<td>'.$row['city'].'</td>';
                            echo '<td>'.$row['state'].'</td>';
                            echo '<td>'.$row['pincode'].'</td>';
                            echo '<td>'.$row['phone'].'</td>';
                            echo '<td>'.$row['comment'].'</td>';
                        }
                    }
                    else if($result_rows==1){
                        $row = mysqli_fetch_assoc($query_result);
                        //echo '<tr id="details">';
                        echo '<tr><td>Cutomer ID</td><td><input name="custid" type="text" readonly value="'.$row["custid"].'"/></td></tr>';
                        echo '<tr><td>Name</td><td><input type="text" readonly value="'.$row["cust_name"].'"/></td></tr>';
                        echo '<tr><td>Amount Remaining</td><td><input id="amtr" name="amtr" type="text" value="'.$row["amount_remaining"].'"/></td></tr>';
                        echo '<tr><td>Amount Payable</td><td><input id="amtp name="amtp" type="text" value="'.$row["amount_payable"].'"/></td></tr>';
                        echo '<tr><td>Created On</td><td><input type="text" readonly value="'.$row["DOC"].'"/></td></tr>';
                        echo '<tr><td>Address</td><td><input id="addr" name="addr" type="text" value="'.$row["address"].'"/></td></tr>';
                        echo '<tr><td>Locality</td><td><input id="local" name="local" type="text" value="'.$row["locality"].'"/></td></tr>';
                        echo '<tr><td>Village</td><td><input id="vill" name="vill" type="text" value="'.$row["village"].'"/></td></tr>';
                        echo '<tr><td>City</td><td><input id=="city" name="city" type="text" value="'.$row["city"].'"/></td></tr>';
                        echo '<tr><td>State</td><td><input id="state" name="state" type="text" value="'.$row["state"].'"/></td></tr>';
                        echo '<tr><td>Pincode</td><td><input id=="pin" name="pin" type="text" value="'.$row["pincode"].'"/></td></tr>';
                        echo '<tr><td>Phone</td><td><input id=="phone" name="phone" type="text" value="'.$row["phone"].'"/></td></tr>';
                        echo '<tr><td>Comment</td><td><input id="comnt" name="comnt" type="text" value="'.$row["comment"].'"/></td></tr>';
                        //echo '</tr>';
                    }
                }
            ?>
            </table>
            </form>
            <br/>
            <?php if($result_rows == 1)
                    echo '<button onclick="submitForm();">SUBMIT</button>';
            ?>
            
        </div>
        <script>
            function selectThis(custid){
//                alert(custid);
                $("#input").val(custid.toString());
                $("#form").submit();
            }
            function submitForm(){
                if(validator() == true)
                 $("#modify").submit();
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
