<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk') {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<!--
This is a page to add or update clerk, we got two options here, add or update
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        //call navigation 
        include './Clerk/ClerkHeader.php';
        //call connection to mysql
        include './Classes/connection.php';
        ?>

        <!--Jquery API To Hide And Show Pop Up Windows-->
        <script src="bootstrap/js/jquery-1.11.2.min.js"> </script>
        <script>
            $(document).ready(function(){
                $("#btncash").click(function(){
                    $("#medaid").fadeOut("fast");
                    $("#medaidup").fadeOut("fast");
                    $("#cash").fadeIn("fast");
                });

                $("#btnmedaid").click(function(){
                    $("#cash").fadeOut("fast");
                    $("#medaidup").fadeOut("fast");
                    $("#medaid").fadeIn("fast");
                });
                
                $("#btnmedaidup").click(function(){
                    $("#cash").fadeOut("fast");
                    $("#medaid").fadeOut("fast");
                    $("#medaidup").fadeIn("fast");
                });
            });
        </script>
    </head>


    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-md-1">
                </div>
                <div class="panel panel-default col-md-6" style="margin-top: -20px">
                    <div class="panel-body">
                        <div class="page-header" style="margin-bottom: 0;">
                            <b>Enter Patient ID</b>
                        </div>
                        <form action="" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-7 navbar-form navbar-left" role="search" >
                                <div class="form-group">
                                    <input type="text" class="form-control" name= 'patientid' placeholder="Patient ID" required>
                                </div>
                                <button type="submit" name= 'search' class="btn btn-default form-control" onclick="">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div>
                        </form>

                        <br>

                        <?php
                        //if button search press, search for the particular patient
                        if(isset($_POST['search'])) {
                            
                            
                            //check if trying to update medicalaid from pop window
                            if(!empty($_POST['mediclaaidno']) && !empty($_POST['name']) && !empty($_POST['expiredate']) && !empty($_POST['telno'])){
                            $patientid = $_POST['patientid'];
                            $mediclaaidno = $_POST['mediclaaidno'];
                            $name = $_POST['name'];
                            $expiredate = $_POST['expiredate'];
                            $telno = $_POST['telno'];
                            $UpdateMedicalAidmessage;
                            
                            //check if medicalaid exist
                            $Selectquery = "select medicalaidno from medicalaid where medicalaidno = '$mediclaaidno'";
                            $queryresults = mysql_query($Selectquery);
                            $rows = mysql_fetch_row($queryresults);
                            $checkmedno = $rows[0];
                            
                            if(empty($checkmedno)){
                                //if doesnt exist insert new and update patient medicalaidno 
                            $Selectquery = "insert into medicalaid values('$mediclaaidno','$name','$telno','$expiredate')";
                            $queryresults = mysql_query($Selectquery);
                            
                            $Selectquery = "update patient set medicalaidno = '$mediclaaidno' where patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery); 
                            if($queryresults){
                              $UpdateMedicalAidmessage = "Medical Aid For Patient $patientid Updated Successful" ; 
                            }else{
                             $UpdateMedicalAidmessage = "Error Occured Please Try Again";    
                            }
                            }else{
                                //if exist update expiring date and tel no and patient medicalaid 
                                $Selectquery = "update medicalaid set expiry_date = '$expiredate', Tel = '$telno' where medicalaidno = '$mediclaaidno'";
                                $queryresults = mysql_query($Selectquery);
                                
                                $Selectquery = "update patient set medicalaidno = '$mediclaaidno' where patientid = '$patientid'";
                                $queryresults = mysql_query($Selectquery);
                                
                                if($queryresults){
                                $UpdateMedicalAidmessage = "Medical Aid For Patient $patientid Updated Successful" ; 
                                }else{
                                $UpdateMedicalAidmessage = "Error Occured Please Try Again";
                                }
                            }
                            
                            }
                            
                            
                            
                            //get patient details
                            $patientid = $_POST['patientid'];
                            //check if request is from payment
                            if(!empty($_POST['Appointmentno'])){
                            $appointmentno = $_POST['Appointmentno'];
                            }
                            
                            $Selectquery = "select a.accountno, a.outstandingbalance,p.surname,p.firstname,p.dob from account a, patient p where a.patientid = p.patientid and p.patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery);
                            $rows = mysql_fetch_row($queryresults);

                            $Selectquery = "select p.medicalaidno, m.name from patient p,medicalaid m where m.medicalaidno = p.medicalaidno and p.patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery);
                            $medicalaidrows = mysql_fetch_row($queryresults);

                            //if patient exist in the db
                            if (!empty($rows[0])) {
                                $ownmoney = FALSE;
                                $fullname = "$rows[2] $rows[3]";
                                $dob = $rows[4];
                                ?>
                            <!-- display patient payment details plus medical aid-->
                                <div class="form-group" align='center'>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label for="fullname" style="margin-bottom:0px;font-weight:400;"><?php echo $fullname;?></label>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fullname" style="margin-bottom:0px;font-weight:400;"><?php echo $patientid;?></label>
                                        </div>
                                    </div>
                                </div>

                                <p></p>
                                <table border="0" class="table-responsive" style="border-radius:0px;width: 100%;font-size: 14px;margin-left: 20px;">
                                        <tr>
                                            <td style="" align="left">
                                                <b>Account No:</b>  <?php echo $rows[0]?>
                                            </td>
                                            <td style="" align="center">
                                               <?php if($rows[1] <= 0){?>
                                                <b style="margin-left:-10px">Outstanding Balance:
                                                R<?php echo "0.00"; ?></b>

                                                <?php }else{ $ownmoney = TRUE;?>
                                                   <b style="margin-left:-10px;color: #E80000">Outstanding Balance:
                                                    R<?php
                                                    $outstandbal = $rows[1];
                                                    echo $rows[1]?></b>

                                                <?php }?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="" align="left">
                                                <b>Medical Aid No:</b> <?php echo $medicalaidrows[0]?>
                                            </td>
                                            <td style="" align="center">
                                                <b>Medical Aid Name:</b> <?php echo $medicalaidrows [1]?>
                                            </td>
                                        </tr>
                                 </table>

                                 <br>

                            <!-- Display button on click event that will call a pop up windows for payment cash or medical aid-->
                                     <div class="row">
                                        <div class="col-md-5">
                                            <?php
                                            if($ownmoney == FALSE){
                                            if(!empty($medicalaidrows[0])) {
                                                ?>
                                                <button type="button" id="btnmedaid"
                                                        class="btn btn-default form-control">Medical Aid
                                                </button>
                                                <?php
                                            }else {
                                                ?>
                                                <button type="button" id="btnmedaidup"
                                                        class="btn btn-default form-control"> Add Medical Aid
                                                </button>

                                                <?php
                                            }}else{
                                             echo  "<button type='button' id='btnmedaid'".
                                                        "class='btn btn-default form-control' disabled>Medical Aid Disabled".
                                                "</button>";
                                            }
                                                ?>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-5">
                                            <button  id="btncash" class="btn btn-default form-control">Cash Payment</button>
                                        </div>
                                    </div>
                                <br>

                                <!--Back Button-->
                                    <div class="">
                                        <p align="center" style="margin-left: -70px;"><a href="Payment.php">
                                                <button type="button" name="back" class="btn btn-default" onclick=""> << Back</button>
                                            </a></p>
                                    </div>

                                <?php
                            } else {
                                echo "Patient does not exist, Please enter a correct ID Number";
                            }
                            
                            
                         }
                        ?>

                <!--  Call The Pop Up Windows-->
                    <?php
                    if(isset($_POST['search'])) {
                        include './Clerk/Popmedaidwindow.php';
                        include './Clerk/Popmedaidupdatewindow.php';
                        include './Clerk/Popcashwindow.php';
                    }
                    ?>

                </div>
                </div>   
            </div>

<!--            if medical aid payment pop up window button processed-->
            <?php
            if(isset($_POST['submitmedaidpayment'])){
                date_default_timezone_set('Africa/Johannesburg');

                $medicalaidno = $_POST['mediclaaidno'];
                $patientid = $_POST['patientid'];
                $clerkemail = $_SESSION['email'];
                $message;
                $paymenttype = "Medical Aid";
                $activatebuttonreport = false;

                //get clerk id
                $Selectquery = "select clerkid from clerk where email = '$clerkemail'";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $clerkid = $rows[0];

                //get patient last consultation number
                $Selectquery = "select max(consultationno) from consultation where patientid = '$patientid'";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $consultationno = $rows[0];

                if(!empty($consultationno)){
                //get doctorid from last consultation
                $Selectquery = "select doctorid from consultation where consultationno = $consultationno";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $docid = $rows[0];
                }
                
                if(!empty($docid) || empty($consultationno)){
                    //get patient last consultation number
                    $Selectquery = "select max(consultationno) from consultation";
                    $queryresults = mysql_query($Selectquery);
                    $result = mysql_fetch_row($queryresults);
                    $consultationno = $result[0];
                    
                    $consultationno = $consultationno + 1;
                    
                    $Selectquery = "insert into consultation(consultationno,consultationdate,patientid) value($consultationno,curdate(),'$patientid')";
                    $queryresults = mysql_query($Selectquery);


                    //insert the medicalaid payment
                    $Selectquery = "insert into payment(paymentdate,paymenttime,paymenttype,patientid,clerkid,consultationno) value(curdate(),curtime(),'$paymenttype','$patientid','$clerkid',$consultationno)";

                    if ($queryresults = mysql_query($Selectquery)) {
                        $Selectquery = "select surname, firstname from patient where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);
                        $rows = mysql_fetch_row($queryresults);
                        $Fullname = "$rows[0] $rows[1]";

                        $message = " Payment with medical aid for patient $Fullname processed sucessfully";
                        $activatebuttonreport = true;
                    } else {
                        $message = "An Error Ocurred please try again";
                    }
                
                }else{
                   $message = "Patient already made a payment but hasn't consulted yet, Please send patient to the consultation room"; 
                }
                
                //check if request was from appointment, and delete that appointment after being processed
                if(!empty($_POST['Appointmentno'])){
                     $appointmentno = $_POST['Appointmentno'];
                     $Selectquery = "update appointment set status = 'Proccessed' where appointmentno = '$appointmentno'";
                     $queryresults = mysql_query($Selectquery);
                }
                
                
                ?>

                <p></p>
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-md-1">
                </div>
                <div class="panel panel-default col-md-6" style="margin-top: -20px">
                    <div class="panel-body">
                        <div class="" style="margin-top: 15px;color: #E80000;font-size: 14px">
                            <?php echo "<div align='center'>$message</div>"; ?>
                     </div>
                        <?php
                        if($activatebuttonreport == true){
                            ?>
                        <form action="PrintPayment.php" target="_blank" method="POST">
                                <input type="hidden" name="patientid" value="<?php echo $patientid?>">
                                <button type="submit" name="submit" class="btn btn-default form-control" class="AlignLeft">Print Payment</button>
                            </form><?php

                        }
                        ?>

                    </div>
                </div>
            </div>




             <?php
            }
            ?>






<!--            if Cash payment pop up window button processed-->
            <?php
            if(isset($_POST['submitcashpayment'])){
                date_default_timezone_set('Africa/Johannesburg');

                $patientid = $_POST['patientid'];
                $clerkemail = $_SESSION['email'];
                $amount = $_POST['amount'];
                $message;
                $paymenttype = "Cash";
                $activatebuttonreport = false;

                //get clerk id
                $Selectquery = "select clerkid from clerk where email = '$clerkemail'";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $clerkid = $rows[0];


                //get amount own
                $Selectquery = "select accountno,outstandingbalance from account where patientid = '$patientid'";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $accountno = $rows[0];
                $outstandingbalance = $rows[1];

                //get patient last consultation number
                    $Selectquery = "select max(consultationno) from consultation where patientid = '$patientid'";
                    $queryresults = mysql_query($Selectquery);
                    $rows = mysql_fetch_row($queryresults);
                    $consultationno = $rows[0];
                    
                if(!empty($consultationno)){
                //get doctorid from last consultation
                $Selectquery = "select doctorid from consultation where consultationno = $consultationno";
                $queryresults = mysql_query($Selectquery);
                $rows = mysql_fetch_row($queryresults);
                $docid = $rows[0];
                }
                
                if(!empty($docid) || empty($consultationno)){
                // if patient does not own any money
                if($outstandingbalance == 0) {
                    
                    //get patient last consultation number
                    $Selectquery = "select max(consultationno) from consultation";
                    $queryresults = mysql_query($Selectquery);
                    $result = mysql_fetch_row($queryresults);
                    $consultationno = $result[0];
                    
                    $consultationno = $consultationno + 1;
                    
                    
                    
                    $Selectquery = "insert into consultation(consultationno,consultationdate,patientid) value($consultationno,curdate(),'$patientid')";
                    $queryresults = mysql_query($Selectquery);

                    //insert the cash payment
                    $Selectquery = "insert into payment(amountpaid,paymentdate,paymenttime,paymenttype,patientid,clerkid,consultationno) value($amount,curdate(),curtime(),'$paymenttype','$patientid','$clerkid',$consultationno)";
                    $queryresults = mysql_query($Selectquery);

                    $outstandingbalance = $outstandingbalance - $amount;

                    $Selectquery = "update account set outstandingbalance = $outstandingbalance  where patientid = '$patientid'";


                    if($queryresults = mysql_query($Selectquery)){
                        $Selectquery = "select surname, firstname from patient where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);
                        $rows = mysql_fetch_row($queryresults);
                        $Fullname = "$rows[0] $rows[1]";

                        $message = " Payment by cash for patient $Fullname processed sucessfully";
                        $activatebuttonreport = true;
                    }
                    else{
                        $message = "An Error Ocurred please try again";
                    }
                    
                }else{
                    $Selectquery = "select max(consultationno) from consultation where patientid = '$patientid'";
                    $queryresults = mysql_query($Selectquery);
                    $rows = mysql_fetch_row($queryresults);
                    $consultationno = $rows[0];

                    //insert the cash payment
                    $Selectquery = "insert into payment(amountpaid,paymentdate,paymenttime,paymenttype,patientid,clerkid,consultationno) value($amount,curdate(),curtime(),'$paymenttype','$patientid','$clerkid',$consultationno)";
                    $queryresults = mysql_query($Selectquery);

                    $outstandingbalance = $outstandingbalance - $amount;
                    $Selectquery = "update account set outstandingbalance = $outstandingbalance  where patientid = '$patientid'";


                    if($queryresults = mysql_query($Selectquery)){
                        $Selectquery = "select surname, firstname from patient where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);
                        $rows = mysql_fetch_row($queryresults);
                        $Fullname = "$rows[0] $rows[1]";

                        $message = "Last consultation payment for patient $Fullname processed sucessfully";
                        $activatebuttonreport = true;
                    }
                    else{
                        $message = "An Error Ocurred please try again";
                    }


                }
                }else{
                   $message = "Patient already made a payment but hasn't consulted yet, Please send patient to the consultation room"; 
                }
                
                //check if request was from appointment, and delete that appointment after being processed
                if(!empty($_POST['Appointmentno'])){
                     $appointmentno = $_POST['Appointmentno'];
                     $Selectquery = "update appointment set status = 'Proccessed' where appointmentno = '$appointmentno'";
                     $queryresults = mysql_query($Selectquery);
                }
                
                ?>

                <p></p>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="panel panel-default col-md-6" style="margin-top: -20px">
                        <div class="panel-body">
                            <div class="" style="margin-top: 15px;color: #E80000;font-size: 14px">
                                <?php echo "<div align='center'>$message</div>"; ?>
                            </div>
                            <?php
                            if($activatebuttonreport == true){
                                ?>
                            <form action="PrintPayment.php" target="_blank" method="POST">
                                <input type="hidden" name="patientid" value="<?php echo $patientid?>">
                                <button type="submit" name="submit" class="btn btn-default form-control" class="AlignLeft">Print Payment</button>
                            </form> 
                                    <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>




                <?php
              }
              
              if(!empty($UpdateMedicalAidmessage)){
                 echo "<script>".
                    "alert('Medical aid details Updated sucessfull!!')".
                      "</script>";
                }
            ?>




        </div>
    </body>

    <?php
    include 'Pages/Footer.php';
    include 'Classes/JsScript.html';
    ?>
</html>
