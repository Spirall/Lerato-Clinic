<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'admin') {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<!--
This is medication page report
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
    //call connection to mysql
    include './Classes/connection.php';
    ?>

    <body onload="myFunction()">
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="panel panel-default col-md-8" style="border: solid; margin-top: 0px">
                    <div class="panel-body">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">Medication Report</h4>
                        </div>
                        
                        <p></p>
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                <tr align="center" style="background-color: #FFFFFF">
                                    <td><b>Name</b></td>
                                    <td><b>Description</b></td>
                                    <td><b>In House</b></td>
                                    <td><b>Quantity</b></td>
                                    <td><b>Discontinue</b></td>
                                </tr>
                                <?php
                                if (isset($_GET['inhouse'])) {
                                    $Selectquery = "select * from medication where inhouse= 'Y'";
                                    $queryresults = mysql_query($Selectquery);
                                } else if (isset($_GET['notinhouse'])) {
                                    $Selectquery = "select * from medication where inhouse= 'N'";
                                    $queryresults = mysql_query($Selectquery);
                                } else if (isset($_GET['discontinued'])) {
                                    $Selectquery = "select * from medication where discontinue= 'Y'";
                                    $queryresults = mysql_query($Selectquery);
                                } else if (isset($_GET['outofstock'])) {
                                    $Selectquery = "select * from medication where qty < 1 and inhouse= 'Y'";
                                    $queryresults = mysql_query($Selectquery);
                                } else {
                                    $Selectquery = "select * from medication";
                                    $queryresults = mysql_query($Selectquery);
                                }

                                $discontinued = 0;
                                $outofstck = 0;
                                $inhouse = 0;
                                $notinhouse = 0;


                                while ($result = mysql_fetch_row($queryresults)) {

                                    if ($result[3] == "Y") {
                                        $inhouse +=1;
                                        if ($result[5] != 'Y') {
                                            if ($result[4] < 1) {
                                                $outofstck+=1;
                                                echo "<tr align='center' style='background-color: #F80000;font-size:13px'>";
                                            } else {
                                                echo "<tr align='center' style='background-color: #2aabd2;font-size:13px'>";
                                            }
                                            $result[5] = 'No';
                                        } else {
                                            if ($result[4] < 1) {
                                                $outofstck+=1;
                                            }
                                            $result[5] = 'Yes';
                                            $discontinued +=1;
                                            echo "<tr align='center' style='background-color: #0000CC;color:#eee;font-size:13px'>";
                                        }
                                        $result[3] = "Yes";
                                    } else {
                                        if ($result[5] != 'Y') {
                                            $notinhouse+=1;
                                            $result[4] = "-";
                                            $result[5] = 'No';
                                            echo "<tr align='center' style='font-size:13px'>";
                                        } else {

                                            $discontinued +=1;
                                            $notinhouse +=1;
                                            $result[4] = "-";
                                            echo "<tr align='center' style='background-color: #0000CC;color:#eee;font-size:13px'>";
                                            $result[5] = 'Yes';
                                        }
                                        $result[3] = "No";
                                    }
                                    ?>
                                    <td style='color:'><?php echo $result[1] ?></td>
                                    <td><?php echo $result[2] ?></td>
                                    <td><?php echo $result[3] ?></td>
                                    <td><?php echo $result[4] ?></td>
                                    <td><?php echo $result[5] ?></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                      
                        <p></p>

                        <table width = '80%' align='center'>
                            <tr> 
                                <td> <label>Discontinue:&nbsp;</label><?php echo $discontinued ?></td>
                           
                                <td><label>In House:&nbsp;</label><?php echo $inhouse ?></td>
                            
                                <td><label>Out Of Stock:&nbsp;</label><?php echo $outofstck ?></td>
                            
                                <td><label>Not In House:&nbsp;</label><?php echo $notinhouse ?></td>
                            </tr>   
                        </table>
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
