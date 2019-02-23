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
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Appointments</h4>
                                </div>
                        
                         <p></p>
                        <h4 align="center" style="color: ">
                        <?php
                        //display title of the consultation report type
                        if (!empty($_GET['From'])) {
                            $from = date('d-M-Y', strtotime($_GET['From']));
                            $to = date('d-M-Y', strtotime($_GET['To']));

                            if ($from <= $to) {
                                echo "$from - $to";
                            } else {
                                echo "<b style='color: #F80000'>Incorrect date, from date $from can not be greater than to date $to</b>";
                            }
                        } else if (!empty($_GET['patientid'])) {
                            $patientid = $_GET['patientid'];

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
                                    $timeexp = 0;
                                    $dayexp = 0;
                                    $processed = 0;
                                    $NotReady = 0;
                                    $toprocess = 0;
                                    date_default_timezone_set('Africa/Johannesburg');
                                    
                                    if(!empty($_GET['From'])){
                                 $From = $_GET['From'];
                                 $to = $_GET['To'];
                                
                                $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where (a.appointmentdate between '$From' and '$to') and (p.patientid = a.patientid) order by a.appointmentno desc";
                                $queryresults = mysql_query($Selectquery);
                                
                                }else if(!empty($_GET['patientid'])){
                                 $patientid = $_GET['patientid'];   
                                 
                                $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where (p.patientid = '$patientid') and (p.patientid = a.patientid) order by a.appointmentno desc";
                                $queryresults = mysql_query($Selectquery);
                                }else{
                                  $date = date('Y-m-d',  strtotime("- 2 days"));
                                //get all appointments from yesterday to 2 weeks ones
                                $Selectquery = "select a.appointmentdate,a.appointmenttime,p.patientid,p.surname,p.firstname,p.title,p.cellno,p.email,a.appointmentno,a.status from patient p, appointment a where( a.appointmentdate > $date) and p.patientid = a.patientid order by a.appointmentno desc";
                                $queryresults = mysql_query($Selectquery);   
                                }
                                    
                                    while($rows = mysql_fetch_row($queryresults)){
                                        $fullname = "$rows[3] $rows[4]";
                                        //if appointment is still available display it in red
                                        if($rows[0] == date("Y-m-d")){
                                    ?>
                                    <tr align="center" style="background-color: #F80000;font-size: 12px">
                                     <?php
                                    //if appointment is not available anymore display it normally
                                    }else if($rows[0] > date("Y-m-d")){
                                    ?>
                                    <tr align="center" style="background-color: #28a4c9;font-size: 12px">   
                                    <?php
                                    //if appointment is not available anymore display it normally
                                    }else{
                                    ?>
                                    <tr align="center" style="font-size: 12px">    
                                    <?php
                                    }
                                    ?>
                                    <td>&nbsp;<?php echo $rows[2]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $fullname; ?>&nbsp;</td>
                                    <td><?php echo $rows[5];?></td>
                                    <td><?php echo $rows[6]; ?></td>
                                    <td>&nbsp;<?php echo $rows[7]; ?>&nbsp;</td>
                                    <td><?php echo $rows[0]; ?></td>
                                    <td><?php echo $rows[1]; ?></td>
                                    <td>
                                        <?php
                                        if(empty($rows[9])){
                                        if($rows[0] == date("Y-m-d")){
                                            $time = date('H:i', strtotime($rows[1]));
                                            $now = date('H:i');

                                            if( $time > $now){
                                        ?>
                                        <form action="Payment.php" method="POST">
                                        <input type="hidden" name="patientid" value="<?php echo $rows[2]?>">
                                        <input type="hidden" name="Appointmentno" value="<?php echo $rows[8]?>">
                                        <button type="submit" name="search">Process</button>
                                        </form>
                                        <?php
                                       $toprocess +=1;
                                        }else{
                                        ?>
                                        Time Expired
                                        <?php
                                        $timeexp +=1;
                                        }
                                        ?>
                                        <?php
                                          }else if($rows[0] > date("Y-m-d")){
                                        ?>
                                        Not Yet Ready
                                        <?php
                                        $NotReady +=1;
                                        }else{
                                        ?>
                                        Date Expired
                                        <?php
                                        $dayexp+=1;
                                        }}
                                        else{
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
                    <br>
                         <p></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                            <label>Date Expired: </label><?php echo "  ".$dayexp."  " ?>
                            </div>
                            <div class="col-md-2">
                            <label>Time Expired: </label><?php echo "  ".$timeexp."  " ?>
                            </div>
                            <div class="col-md-2">
                            <label>Processed: </label><?php echo "  ".$processed."  " ?>
                            </div>
                            <div class="col-md-2">
                            <label>To Process: </label><?php echo "  ".$toprocess."  " ?>
                            </div>
                            <div class="col-md-2">
                            <label>Not Ready Yet: </label><?php echo "  ".$NotReady."  " ?>
                            </div>
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
