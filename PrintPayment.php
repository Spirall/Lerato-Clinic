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
This is the to see appointment by the clerk
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        include './Classes/CssLink.html';
        
        //call connection to mysql
        include './Classes/connection.php';
    ?> 
        

    </head>
    
    <body onload="myFunction()">
        <div class ="jumbotron" style="margin-top: -1px;">
            <div class="row">
                <div class="col-md-1"></div>
               <div class="panel panel-default col-md-10" style="border: solid; margin-top: -9px;">
                    <div class="panel-body" style="">
                        <table border="0" width="100%">
                            <tr><td width="70%">
                            Lerato Clinic <br>
                        19 Sparrman Street 
                         Vanderbijlpark <br>Gauteng, South Africa
                        </td>
                        <td width="30%">
                        <img src="./Images/LeratoClinicLogo2.jpg" width ="100%" height ="100px">
                         </td>
                            </tr>
                        </table>          
                         <h4 align ="center" style="padding-top: 0px">Payment Receipt</h4>
                            
                         <p></p>
                        <h6 style="color: ">
                        <?php
                        //display title of the consultation report type
                        $patientid = $_POST['patientid'];
                        
                        $Selectquery = "select max(paymentno) from payment where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);  
                        $result = mysql_fetch_row($queryresults);
                        $paymentno = $result[0];
                        
                        $Selectquery = "select c.surname,c.firstname from payment p,clerk c where c.clerkid = p.clerkid and paymentno = $paymentno";
                        $queryresults = mysql_query($Selectquery);  
                        $result = mysql_fetch_row($queryresults);
                        $clerksurname =$result[0];
                        $clerkfirstname = $result[1];
                        
                        $Selectquery = "select surname,firstname,dob from patient where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);  
                        $result = mysql_fetch_row($queryresults);
                        $dob = $result[2];
                        $fullname = "$result[0] $result[1]";
                        
                        date_default_timezone_set('Africa/Johannesburg');
                        $age = date("Y-m-d") - $dob;
                        $consultationPrice;
                        
                        if($age > 14) {
                         $Selectquery = "select price from consultationprice where `type` = 'Adult'";
                         $queryresults = mysql_query($Selectquery);
                         $row = mysql_fetch_row($queryresults); 
                         $consultationPrice = $row[0];
                        }else{
                         $Selectquery = "select price from consultationprice where `type` = 'Child'";
                         $queryresults = mysql_query($Selectquery);
                         $row = mysql_fetch_row($queryresults);
                         
                         $consultationPrice = $row[0];
                        }
                        
                        
                        $Selectquery = "select m.medicalaidno, m.name from medicalaid m, patient p where m.medicalaidno = p.medicalaidno and p.patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);  
                        $medaid = mysql_fetch_row($queryresults);
                        
                        $medaidname =$medaid[1];
                        $medaidno =$medaid[0];
       
                        if(empty($medaidname)){
                         $medaidname = "None";
                         $medaidno = "None";
                        }
                        
                        echo "<table border='0' width='100%'>".
                            "<tr><td width='70%'>";
                        echo "Payment No: $paymentno <br>";
                        echo "Clerk : $clerksurname $clerkfirstname"
                                . "<br> <br> <br> <br></td><td width='30%'>";
                        echo "Patient ID : $patientid <br>";
                        echo "Patient : $fullname<br>";
                        echo "Age : $age<br><br>";
                        echo "MedicalAid Name : $medaidname<br>";   
                        echo "MedicalAid No : $medaidno<br>"
                                . "</td><tr></table>";
                                ?>
                        </h6>  
                         <br>
                        
                                <table border="1" class="table-responsive" style="width: 100%;font-size: 12px" align="center">
                                   <tr align="center">
                                     <td>Amount Paid</td>
                                     <td>Payment Date</td>
                                     <td>Payment Time</td>
                                     <td>Payment Type</td>
                                     <td>Consultation No</td>
                                     <td>Consultation Price</td>
                                     <td>Outstanding Amount</td>
                                    </tr>
                                    
                                    <?php
                                  $amountpaid = 0;   
                                  $Selectquery = "select * from payment where paymentno = $paymentno";
                                  $queryresults = mysql_query($Selectquery);
                                    
                                    while($rows = mysql_fetch_row($queryresults)){
                                        
                                    ?>
                                    <tr align="center" style="font-size: 12px">
                                    <td>&nbsp;R<?php echo $rows[1]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[2];?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[3]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[4]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[7]; ?>&nbsp;</td>
                                    <td>&nbsp;R<?php echo $consultationPrice; ?>&nbsp;</td>
                                    <td>&nbsp;<?php 
                                    $Selectquery2 = "select amountpaid from payment where consultationno = $rows[7]";
                                    $queryresults2 = mysql_query($Selectquery2);
                                    
                                    while($rows2 = mysql_fetch_row($queryresults2)){
                                      $amountpaid+=  $rows2[0];
                                    }
                                    $reminder = $consultationPrice - $amountpaid;
                                    echo "R$reminder";
                                    ?>&nbsp;</td>
                                    </tr>   
                                    <?php
                                    }
                                    ?>
                                    
                                </table>
                    <br>
                       
                    </div>
                </div>
            </div>
            </div>
            
        <script>
            function myFunction() {
                window.print();
            }
        </script>
     
    </body>
</html>
