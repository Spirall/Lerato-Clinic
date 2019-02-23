<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk'){
    header("Location: signout.php");
}
}
?>

<!DOCTYPE html>
<!--
This is the to see patient request by the clerk
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        include './Classes/CssLink.html';
        ?>

    </head>
    <?php
    //call navigation 
    include './Clerk/ClerkHeader.php';
    //call connection to mysql
    include './Classes/connection.php';
    ?>
    
    <body>
        <?php
        if(isset($_POST['Register'])){
            $id = $_POST['id'];
            $surname = $_POST['surname'];
            $firstname = $_POST['firstname'];
            $title = $_POST['title'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $cellno = $_POST['cellno'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $postalcode = $_POST['postalcode'];
            $fullname = "$surname $firstname";
            $Selectquery = "insert into patient(patientid,surname,firstname,title, gender,dob,cellno,email,address,postalcode) value('$id','$surname','$firstname','$title','$gender','$dob','$cellno','$email','$address','$postalcode')";
            $queryresults = mysql_query($Selectquery);
            
            $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','patient')";
            $insertquery = mysql_query($Selectquery); 
                  
            $Selectquery = "insert into account(patientid) value('$id')";
            $insertquery = mysql_query($Selectquery);
            
            $Selectquery = "delete from requestpatient where patientid = '$id' ";
            $queryresults = mysql_query($Selectquery);
            
            $response ="Your Account has been activated, Please use your Email Address as Username,"
                    . "and ID Number as default password that need to be changed in the first log in";
            $response = wordwrap($response, 50,"<br>\n");
            $mail = mail($email, 'Response From Lerato Clinic', $response);
            
        }
        if(isset($_POST['Decline'])){
             $id = $_POST['id'];
            $Selectquery = "delete from requestpatient where patientid = '$id'";
            $queryresults = mysql_query($Selectquery);
        }
        
        ?>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-md-1"></div>
               <div class="panel panel-default col-md-10" style="border: solid; margin-top: -20px;">
                    <div class="panel-body" style="">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Registration Request</h4>
                                </div>
                                <?php
                                //get all appointments
                                  $Selectquery = "select * from requestpatient";
                                  $queryresults = mysql_query($Selectquery);
                                  
                                ?>
                        <div style="height: 350px;overflow:scroll;font-size: 14px">
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 100%;" align="center">
                                   <tr align="center">
                                     <td>Patient ID</td>
                                     <td>Full Name</td>
                                     <td>Title</td>
                                     <td>Gender</td>
                                     <td>Age</td>
                                     <td>Cell Phone Number</td>
                                     <td>Email Address</td>
                                     <td>Home Address</td>
                                     <td>Postal Code</td>
                                     <td>Accept</td>
                                     <td>Decline</td>
                                    </tr>
                                    
                                    <?php
                                    date_default_timezone_set('Africa/Johannesburg');
                                    while($rows = mysql_fetch_row($queryresults)){
                                        $fullname = "$rows[1] $rows[2]";
                                        //if appointment is still available display it in red
                                    ?>
                                    
                                    <tr align="center">
                                    <td>&nbsp;<?php echo $rows[1]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $fullname; ?>&nbsp;</td>
                                    <td><?php echo $rows[3];?></td>
                                    <td><?php echo $rows[4]; ?></td>
                                    <td>&nbsp;<?php 
                                    $age =  date('Y-m-d') - $rows[5];
                                    echo $age." Years Old";
                                    ?>&nbsp;</td>
                                    <td><?php echo $rows[6]; ?></td>
                                    <td><?php echo $rows[7]; ?></td>
                                    <td><?php echo $rows[8]; ?></td>
                                    <td style="width:8%"><?php echo $rows[9]; ?></td>
                                    <td style="background-color: #286090;width:9%">
                                        <form action="PatientRequest.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $rows[0]?>">
                                            <input type="hidden" name="surname" value="<?php echo $rows[1]?>">
                                            <input type="hidden" name="firstname" value="<?php echo $rows[2]?>">
                                            <input type="hidden" name="title" value="<?php echo $rows[3]?>">
                                            <input type="hidden" name="gender" value="<?php echo $rows[4]?>">
                                            <input type="hidden" name="dob" value="<?php echo $rows[5]?>">
                                            <input type="hidden" name="cellno" value="<?php echo $rows[6]?>">
                                            <input type="hidden" name="email" value="<?php echo $rows[7]?>">
                                            <input type="hidden" name="address" value="<?php echo $rows[8]?>">
                                            <input type="hidden" name="postalcode" value="<?php echo $rows[9]?>">
                                            <input type="submit" name ="Register" value="Register">      
                                        </form> 
                                    </td>
                                    <td style="background-color: #F80000;width:9%">
                                        <form action="PatientRequest.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $rows[0]?>">
                                            <input type="submit" name ="Decline" value="Decline">      
                                        </form> 
                                    </td>
                                    </tr>   
                                    <?php
                                    }
                                    ?>
                                    
                                </table>
                            </div>
                    </div>
                </div>
            </div>
            <?php
            if(isset($_POST['Register'])){          
           echo "<script>".
                "alert('Request for $fullname successfully Processed')".
                "</script>";
            }
           ?>
            </div>
       <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
