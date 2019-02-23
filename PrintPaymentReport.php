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
This is a page to add or update Patient, we got two options here, add or update
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
    <div class ="jumbotron" style="margin-top: -10px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-default col-md-10" style="border: solid; margin-top: -0px;">
                <div class="panel-body" style="">
                    <div class="page-header">
                        <h4 align ="center" style="padding-top: 0px">Payment Report</h4>
                    </div>   
                    <p></p>
                    <h4 align="center" style="color: ">
                    <?php
                                     //display title of the consultation report type
                                     if(!empty($_GET['From'])){
                                    $from = date( 'd-M-Y',strtotime($_GET['From']));
                                    $to = date( 'd-M-Y',strtotime($_GET['To']));
                                    
                                    if($from <= $to){
                                    echo "$from - $to";
                                    }else{
                                     echo "<b style='color: #F80000'>Incorrect date, from date $from can not be greater than to date $to</b>";   
                                    }
                                    
                                    }else if(!empty($_GET['patientid'])){
                                    $patientid = $_GET['patientid']; 
                                    
                                    $Selectquery = "select surname,firstname from patient where patientid = '$patientid'";
                                    $queryresults = mysql_query($Selectquery);
                                    $patientnames = mysql_fetch_row($queryresults);
                                     if(!empty($patientnames[0])){       
                                    echo "Payment Report For $patientnames[0] $patientnames[1]"; 
                                     }else{
                                    echo "<b style='color: #F80000'>Patient Not Found</b>";    
                                    }
                                    }else{
                                     echo " Full Payment Report"; 
                                    }
                                     ?>
                    </h4>
                    <p></p>
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                            <tr align="center">
                                <td><b>Payment No</b></td>
                                <td><b>Patient ID</b></td>
                                <td><b>Full Name</b></td>
                                <td><b>Amount</b></td>
                                <td><b>Type</b></td>
                                <td><b>Clerk</b></td>
                                <td><b>Date</b></td>
                                <td><b>Time</b></td>
                                <td><b>Consultation No</b></td>
                            </tr>

                            <?php
                            $totAmount = 0;
                            if (!empty($_GET['From'])) {
                                //if search for specific dates pressed
                                $from = $_GET['From'];
                                $to = $_GET['To'];
                                $Selectquery = "select p.paymentno, pat.patientid ,pat.surname,pat.firstname,p.amountpaid,p.paymenttype,p.paymentdate,p.paymenttime,c.surname,c.firstname,p.consultationno from patient pat, clerk c ,payment p where (p.patientid = pat.patientid) and (c.clerkid = p.clerkid) and (paymentdate between '$from' and '$to') order by p.paymentno desc";
                                $queryresults = mysql_query($Selectquery);
                            } else if (!empty($_GET['patientid'])) {
                                //if search for specific patient pressed
                                $patientid = $_GET['patientid'];
                                $Selectquery = "select p.paymentno,pat.patientid ,pat.surname,pat.firstname,p.amountpaid,p.paymenttype,p.paymentdate,p.paymenttime,c.surname,c.firstname,p.consultationno from patient pat, clerk c ,payment p where (p.patientid = pat.patientid) and (c.clerkid = p.clerkid) and (p.patientid = '$patientid') order by p.paymentno desc";
                                $queryresults = mysql_query($Selectquery);
                            } else {
                                $Selectquery = "select p.paymentno,pat.patientid ,pat.surname,pat.firstname,p.amountpaid,p.paymenttype,p.paymentdate,p.paymenttime,c.surname,c.firstname,p.consultationno from patient pat, clerk c ,payment p where (p.patientid = pat.patientid) and (c.clerkid = p.clerkid) order by p.paymentno desc";
                                $queryresults = mysql_query($Selectquery);
                            }

                            while ($rows = mysql_fetch_row($queryresults)) {
                                $patientfullname = "$rows[2] $rows[3]";
                                $clerkfullname = "$rows[8] $rows[9]";
                                ?>
                                <tr align="center" style="font-size: 12px">
                                    <td width='10%'>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[1]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $patientfullname; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[4]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[5]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $clerkfullname; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[6]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[7]; ?>&nbsp;</td>
                                    <td width='12%'>&nbsp;<?php echo $rows[10]; ?>&nbsp;</td>
                                </tr>   
                            <?php
                                $totAmount += $rows[4];
                             }
                            ?>
                        </table>
                        </div>
                <p></p>
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3">
                            <label>Total Amount: <?php echo "R".$totAmount ?></label>
                        </div>
                    </div>
                    <p></p>
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
