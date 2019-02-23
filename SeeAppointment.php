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
This is the to see appointment by the clerk
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        ?>
        <script src="bootstrap/js/jquery-1.11.2.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#btnpatientid").click(function () {
                    $("#date").fadeOut("fast");
                    $("#patientid").fadeIn("fast");
                });

                $("#btnsortdate").click(function () {
                    $("#patientid").fadeOut("fast");
                    $("#date").fadeIn("fast");
                });
            });
        </script>


    </head>
    <?php
    //call navigation 
    include './Clerk/ClerkHeader.php';
    //call connection to mysql
    include './Classes/connection.php';
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-default col-md-10" style="border: solid; margin-top: -20px;">
                    <div class="panel-body" style="">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">Appointments</h4>
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
                                    <a href="SeeAppointment.php"><button type="button" id="" name="" class="btn btn-default form-control">Reset</button></a>
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
                                echo " Full Appointment Report";
                            }
                            ?>
                        </h4>  
                        <p></p>

                        <div style="height: 200px;overflow:scroll">
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%;" align="center">
                                <tr align="center">
                                    <td>Patient ID</td>
                                    <td>Full Name</td>
                                    <td>Title</td>
                                    <td>Cell Phone Number</td>
                                    <td>Email Address</td>
                                    <td>Appointment Date</td>
                                    <td>Appointment Time</td>
                                    <td>Process Appointment</td>
                                </tr>

                                <?php
                                $From = "";
                                $to = "";
                                $patientid = "";
                                $timeexp = 0;
                                $dayexp = 0;
                                $processed = 0;
                                $NotReady = 0;
                                $toprocess = 0;
                                date_default_timezone_set('Africa/Johannesburg');

                                if (isset($_POST['submitdates'])) {
                                    $From = $_POST['From'];
                                    $to = $_POST['To'];

                                    $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where (a.appointmentdate between '$From' and '$to') and (p.patientid = a.patientid) order by a.appointmentno desc";
                                    $queryresults = mysql_query($Selectquery);
                                } else if (isset($_POST['submitpatientid'])) {
                                    $patientid = $_POST['patientid'];

                                    $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where (p.patientid = '$patientid') and (p.patientid = a.patientid) order by a.appointmentno desc";
                                    $queryresults = mysql_query($Selectquery);
                                } else {
                                    $date = date('Y-m-d', strtotime("- 2 days"));
                                    //get all appointments from yesterday to 2 weeks ones
                                    $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where( a.appointmentdate > $date) and p.patientid = a.patientid order by a.appointmentdate desc";
                                    $queryresults = mysql_query($Selectquery);
                                }

                                while ($rows = mysql_fetch_row($queryresults)) {
                                    $fullname = "$rows[3] $rows[4]";
                                    //if appointment is still available display it in red
                                    if ($rows[0] == date("Y-m-d")) {
                                        ?>
                                        <tr align="center" style="background-color: #F80000;font-size: 12px">
                                            <?php
                                            //if appointment is not available anymore display it normally
                                        } else if ($rows[0] > date("Y-m-d")) {
                                            ?>
                                        <tr align="center" style="background-color: #28a4c9;font-size: 12px">   
                                            <?php
                                            //if appointment is not available anymore display it normally
                                        } else {
                                            ?>
                                        <tr align="center" style="font-size: 12px">    
                                            <?php
                                        }
                                        ?>
                                        <td>&nbsp;<?php echo $rows[2]; ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $fullname; ?>&nbsp;</td>
                                        <td><?php echo $rows[5]; ?></td>
                                        <td><?php echo $rows[6]; ?></td>
                                        <td>&nbsp;<?php echo $rows[7]; ?>&nbsp;</td>
                                        <td><?php echo $rows[0]; ?></td>
                                        <td><?php echo $rows[1]; ?></td>
                                        <td>
                                            <?php
                                            if (empty($rows[9])) {
                                                if ($rows[0] == date("Y-m-d")) {
                                                    $time = date('H:i', strtotime($rows[1]));
                                                    $now = date('H:i', strtotime("-10 minutes"));
                                                    if ($time >= $now) {
                                                        ?>
                                                        <form action="Payment.php" method="POST">
                                                            <input type="hidden" name="patientid" value="<?php echo $rows[2] ?>">
                                                            <input type="hidden" name="Appointmentno" value="<?php echo $rows[8] ?>">
                                                            <button type="submit" name="search" style="width:90%;color: #ac2925">Process Appointment</button>
                                                        </form>
                                                        <?php
                                                        $toprocess +=1;
                                                    } else {
                                                        ?>
                                                        Time Expired
                                                        <?php
                                                        $timeexp +=1;
                                                    }
                                                    ?>
                                                    <?php
                                                } else if ($rows[0] > date("Y-m-d")) {
                                                    ?>
                                                    Not Yet Ready
                                                    <?php
                                                    $NotReady +=1;
                                                } else {
                                                    ?>
                                                    Date Expired
                                                    <?php
                                                    $dayexp+=1;
                                                }
                                            } else {
                                                echo $rows[9];
                                                $processed+=1;
                                            }
                                            ?>
                                        </td>
                                    </tr>   
                                    <?php
                                }
                                ?>

                            </table>
                        </div>
                        <p></p>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2">
                                    <label>Date Expired: </label><?php echo "  " . $dayexp . "  " ?>
                                </div>
                                <div class="col-md-2">
                                    <label>Time Expired: </label><?php echo "  " . $timeexp . "  " ?>
                                </div>
                                <div class="col-md-2">
                                    <label>Processed: </label><?php echo "  " . $processed . "  " ?>
                                </div>
                                <div class="col-md-2">
                                    <label>To Process: </label><?php echo "  " . $toprocess . "  " ?>
                                </div>
                                <div class="col-md-2">
                                    <label>Not Ready Yet: </label><?php echo "  " . $NotReady . "  " ?>
                                </div>
                            </div>
                        </div>
                        <p></p>
                    </div>
                </div>
            </div>

            <?php
            include 'Clerk/PopdateInterval3.php';
            include 'Clerk/PopGetPatientId3.php';
            ?>

            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div>
                        <form action="PrintAppointmentReport.php" target="_blank" method="get">
                            <input type="hidden" name="From" value="<?php echo $From ?>">
                            <input type="hidden" name="To" value="<?php echo $to ?>">
                            <input type="hidden" name="patientid" value="<?php echo $patientid ?>">
                            <button type="submit" name= "convert" class="btn btn-default form-control">
                                Print
                            </button>
                        </form>
                        <br>
                        <a href="AppointmentClerk.php">
                            <button type="button" name="back" class="btn btn-default form-control"><< Back</button>
                        </a>
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
