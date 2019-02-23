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
This is a page to Print patient list 
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
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-default col-md-10" style="border: solid; margin-top: 0px;">
                    <div class="panel-body" style="">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">List of Patient Report</h4>
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
                            } else {
                                echo " Full Patient Report";
                            }
                            ?>
                        </h4>  
                        <p></p>
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                <tr align="center">
                                    <td><b>ID</b></td>
                                    <td><b>Title</b></td>
                                    <td><b>Full Name</b></td>
                                    <td><b>Date of Birth</b></td>
                                    <td><b>Cell Phone</b></td>
                                    <td><b>Email</b></td>
                                    <td><b>Address</b></td>
                                    <td><b>Date Registered</b></td>
                                </tr>

                                <?php
                                $from = "";
                                $to = "";
                                $Nopatient = 0;
                                if (!empty($_GET['From'])) {
                                    //if search for specific dates pressed
                                    $from = date('Y-m-d H:i:s', strtotime($_GET['From']));
                                    $to = date('Y-m-d H:i:s', strtotime($_GET['To']));

                                    $Selectquery = "select * from patient where registerdate between '$from' and '$to'";
                                    $queryresults = mysql_query($Selectquery);
                                } else {
                                    $Selectquery = "select * from patient";
                                    $queryresults = mysql_query($Selectquery);
                                }

                                while ($rows = mysql_fetch_row($queryresults)) {
                                    ?>
                                    <tr align="center" style="font-size: 12px">
                                        <td>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $rows[3]; ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo "$rows[1] $rows[2]"; ?>&nbsp;</td>
                                        <td>&nbsp;<?php
                                $dob = date("Y-m-d", strtotime($rows[4]));
                                echo $dob;
                                ?>&nbsp;
                                        </td>
                                        <td>&nbsp;<?php echo $rows[8] ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $rows[9] ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $rows[10] ?>&nbsp;</td>
                                        <td>&nbsp;<?php echo $rows[13]; ?>&nbsp;</td>
                                    </tr>   
                                    <?php
                                    $Nopatient+=1;
                                }
                                ?>

                            </table>
                        <p></p>
                        <div class="row">
                            <div class="col-md-9">
                            </div>
                            <div class="col-md-3">
                                <label>Number of Patient: <?php echo $Nopatient ?></label>
                            </div>
                        </div>
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
