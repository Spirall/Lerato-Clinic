<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'admin'){
    header("Location: index.php");
}
}
?>

<!DOCTYPE html>
<!--
This is the main Administrator page
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
    include './Pages/AdminHeader.html';
    
    //call connection to mysql
    include './Classes/connection.php';
  
    ?>
    
    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2">         
                </div>
                <div class="col-md-1">    
                </div>
                <div class="panel panel-default col-md-6" style="border: solid; margin-top: -20px">
                    <div class="panel-body"> 
                        
                        
                     <?php
                     if(!isset($_POST['submitpaymentno'])){
                     ?>
                        <div class="page-header" style="">
                                    <h4 align ="center">Update Medical Aid Payment</h4>
                        </div> 
                        <form action="MedicalAidPaymentUpdate.php" method="post">
                        <div class="row" style="margin-top: -12px">
                                <div class="col-lg-6">
                                </div>
                               <div class="col-lg-6 navbar-form navbar-left" role="search" >
                                <div class="form-group">
                                    <input type="text" id ="" class="form-control" title="enter medical aid payment no" placeholder="Payment Number" name="paymentno" required>
                                </div>
                                   <button type="submit" class="btn btn-default" name="submitpaymentno">
                                 <span class="glyphicon glyphicon-search"></span>
                                   </button>
                                </div>
                        </div>
                        </form>
                    <?php
                     }else if(isset($_POST['submitpaymentno'])){
                         $paymentno = $_POST['paymentno'];
                         
                         $Selectquery = "select p.amountpaid,p.paymentdate,p.patientid, pa.surname,pa.firstname, pa.medicalaidno from payment p, patient pa where p.patientid = pa.patientid and p.paymenttype ='Medical Aid' and p.paymentno = '$paymentno'";
                         $queryresults = mysql_query($Selectquery);
                         $rows = mysql_fetch_row($queryresults);
                         if(!empty($rows[0])){
                    ?>
                        <div class="page-header" style="margin-bottom: 0px">
                                    <h4 align ="center">Update Medical Aid Payment</h4>
                        </div> 
                        
                        <br>
                        <div class="row">
                            <p align="center" style="">Payment No: <?php echo $paymentno?> </p>
                            <div class="col-md-8">
                                <b>Patient ID: </b><?php echo " $rows[2]" ?><br>    
                                <b>Full Name: </b><?php echo " $rows[3] $rows[4]" ?><br>    
                            </div>
                            <div class="col-md-4">
                                <b>Medical Aid No: </b><?php echo " $rows[5]" ?><br> 
                                <b>Name: </b><?php 
                                $Selectquery = "select  name from medicalaid where medicalaidno = '$rows[5]'";
                                $queryresults = mysql_query($Selectquery);
                                $row = mysql_fetch_row($queryresults);
                                $medicalaidname = $row[0];
                                echo $medicalaidname;
                                ?>
                                <br> 
                            </div>     
                        </div>
                        <br>
                        <br>
                        <form action="MedicalAidPaymentUpdate.php" method="post">
                        <div class="row">
                            <div class="col-md-2"></div>
                            
                            <div class="col-md-5"> 
                                <label style="padding-left: 5px">Amount Received (Rand)</label>
                                <input type="number" min="100" max="350" step="5" class="form-control"  placeholder="Amount Received" name="amount" value="<?php echo $rows[0]?>" required>
                            </div> 
                            <div class="col-md-4">
                                <label></label>
                                <input type="hidden" name="paymentno" value="<?php echo $paymentno?>">
                                <input type="submit" class="btn btn-default form-control" name="submitpayment" value="Update Payment">
                            </div> 
                        </div>
                        </form>           
                     <?php
                         }else{
                         ?>
                        <div class="page-header" style="">
                                    <h4 align ="center">Update Medical Aid Payment</h4>
                        </div> 
                        <form action="MedicalAidPaymentUpdate.php" method="post">
                        <div class="row" style="margin-top: -12px">
                                <div class="col-lg-6">
                                </div>
                               <div class="col-lg-6 navbar-form navbar-left" role="search" >
                                <div class="form-group">
                                    <input type="text" id ="" class="form-control" title="enter medical aid payment no" placeholder="Payment Number" name="paymentno" required>
                                </div>
                                   <button type="submit" class="btn btn-default" name="submitpaymentno">
                                 <span class="glyphicon glyphicon-search"></span>
                                   </button>
                                </div>
                        </div>
                        </form>
                        <br>
                        <br>
                        <h5 style="color: #F80000;font-size: 12px">Payment Number <?php echo $paymentno ?> Not Found! Please make sure this payment was a medical Aid Payment</h5>
                        
                        <?php
                        }
                        }
                        
                        
                        if(isset($_POST['submitpayment'])){
                            $payno = $_POST['paymentno'];
                            $amount = $_POST['amount'];
                            
                            $Selectquery = "update payment set amountpaid = '$amount' where paymentno = $payno";
                            $queryresults = mysql_query($Selectquery);
                            
                          echo "<script>"
                            . "alert('Medical Aid Payment No $payno Successfully Updated to R$amount')"
                                  . "</script>";  
                        }    
                     ?>
                    </div>
                    </div>
                   </div>
                </div>
               
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
