<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk') {
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
        //call navigation 
        include './Clerk/ClerkHeader.php';
        //call connection to mysql
        include './Classes/connection.php';
        ?>


        <script src="bootstrap/js/jquery-1.11.2.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#btnpatientid").click(function() {
                    $("#date").fadeOut("fast");
                    $("#patientid").fadeIn("fast");
                });

                $("#btnsortdate").click(function() {
                    $("#patientid").fadeOut("fast");
                    $("#date").fadeIn("fast");
                });
            });
        </script>
    </head>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-default col-md-10" style="border: solid; margin-top: -20px;">
                    <div class="panel-body" style="">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">Payment Report</h4>
                        </div>
                    </div>

                    <div class="row"> 
                            <div class="col-md-4">
                                <div>
                                    <button type="submit" id ="btnsortdate" name="submitdates" class="btn btn-default form-control">Sort By Date</button>
                                </div>                                                                                                      
                            </div> 
                            <div class="col-md-4">
                                <div>
                                    <button type="submit" id="btnpatientid" name="submitpatient" class="btn btn-default form-control">For Specific Patient</button>
                                </div>                                                                                                      
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <a href="PaymentReport.php"><button type="button" id="" name="" class="btn btn-default form-control">Reset</button></a>
                                </div>                                                                                                      
                            </div>
                        </div>
                    <p></p>
                    <h4 align="center" style="color: ">
                        <?php
                        //display title of the consultation report type
                        if (isset($_POST['submitdates'])) {
                            $from = date('d-M-Y', strtotime($_POST['From']));
                            $to = date('d-M-Y', strtotime($_POST['To']));

                            if ($from <= $to) {
                                echo "$from - $to";
                            } else {
                                echo "<b style='color: #F80000'>Incorrect date, from date $from can not be greater than to date $to</b>";
                            }
                        } else if (isset($_POST['submitpatientid'])) {
                            $patientid = $_POST['patientid'];

                            $Selectquery = "select surname,firstname from patient where patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery);
                            $patientnames = mysql_fetch_row($queryresults);
                            if (!empty($patientnames[0])) {
                                echo "Payment Report For $patientnames[0] $patientnames[1]";
                            } else {
                                echo "<b style='color: #F80000'>Patient Not Found</b>";
                            }
                        } else {
                            echo " Full Payment Report";
                        }
                        ?>
                    </h4>  
                    <p></p>

                    <div style="height: 200px;overflow:scroll;width: 100%">
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
                            $from = "";
                            $to = "";
                            $patientid = "";
                            $totAmount = 0;
                            
                            if (isset($_POST['submitdates'])) {
                                //if search for specific dates pressed
                                $from = $_POST['From'];
                                $to = $_POST['To'];
                                $Selectquery = "select p.paymentno, pat.patientid ,pat.surname,pat.firstname,p.amountpaid,p.paymenttype,p.paymentdate,p.paymenttime,c.surname,c.firstname,p.consultationno from patient pat, clerk c ,payment p where (p.patientid = pat.patientid) and (c.clerkid = p.clerkid) and (paymentdate between '$from' and '$to') order by p.paymentno desc";
                                $queryresults = mysql_query($Selectquery);
                            } else if (isset($_POST['submitpatientid'])) {
                                //if search for specific patient pressed
                                $patientid = $_POST['patientid'];
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




<?php
include 'Clerk/PopdateInterval2.php';
include 'Clerk/PopGetPatientId2.php';
?>

            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div>
                    <form action="PrintPaymentReport.php" target="_blank" method="get">
                      <input type="hidden" name="From" value="<?php echo $from?>">
                      <input type="hidden" name="To" value="<?php echo $to?>">
                      <input type="hidden" name="patientid" value="<?php echo $patientid?>">
                        <button type="submit" name= "convert" class="btn btn-default form-control">
                          Print
                        </button>
                    </form>
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
