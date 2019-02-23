<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
    header("Location: signout.php");
}
date_default_timezone_set('Africa/Johannesburg');
?>
<!DOCTYPE html>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        <?php
        include './Classes/CssLink.html';
        include './Classes/connection.php';
        ?>
        <link rel="stylesheet" href="./Classes/ModifiedCss.css">

    </head>


    <body onload="myFunction()">
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-lg-1">                       
            </div>
            <div class="panel panel-default col-md-10" style="border: solid; margin-top: -20px">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <br>
                            <label>Doctor</label>
                            <?php
                            $doctoremail = $_SESSION['email'];

                            $Selectquery = "select surname, firstname, CellNo from doctor where email = '$doctoremail'";
                            $queryresults = mysql_query($Selectquery);
                            $row = mysql_fetch_row($queryresults);
                            $fullname = "$row[0] $row[1]";
                            echo "<label>$fullname</label>"
                            ?>
                            <div>
                                <label>
                                    19 Sparrman Street 
                                    Vanderbijlpark <br>Gauteng, South Africa
                                </label>
                            </div> 
                            <div>
                                <label>
                                    Tel: <?php echo $row[2]; ?>
                                </label>
                            </div>

                        </div> 
                        <div class="col-lg-5"> 
                            <img src="./Images/LeratoClinicLogo2.jpg" width ="100%" height ="120px">
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-lg-5" >
                        </div>
                        <div class="col-lg-5" >
                            <h3 style="margin-top: 0px;"><b>Prescription</b></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5" >
                            <?php
                            $patientid = $_SESSION['patientid'];

                            $Selectquery = "select surname, firstname from patient where patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery);
                            $row = mysql_fetch_row($queryresults);
                            $fullname = "$row[0] $row[1]";
                            echo "<label>ID No: $patientid</label><br>";
                            echo "<label>Patient: $fullname</label>";
                            ?>
                        </div>
                        <div class="col-lg-4" >
                        </div>
                        <div class="col-lg-3" >
                            <br>
                            <?php
                            echo "<label>Date: </label> <b>" . date('d-m-Y') . "</b>";
                            ?>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-1" >
                        </div>
                        <div class="col-lg-10" >
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                <tr align="center">
                                    <td>Medication Name</td>
                                    <td>Quantity</td> 
                                    <td>Direction</td> 
                                </tr>
                                <?php
                                $consultationno = $_SESSION['consultationo'];

                                //delete missing data in prescription for a particular consultation
                                $Selectquery = "delete from prescription where directive = Null and quantity= Null and MedicineCode = Null and consultationno = $consultationno";
                                $queryresults = mysql_query($Selectquery);

                                $Selectquery = "select m.name,p.quantity,p.directive from medication m, prescription p where p.consultationno = '$consultationno' and m.medicinecode = p.medicinecode";
                                $queryresults = mysql_query($Selectquery);
                                while ($row = mysql_fetch_row($queryresults)) {
                                    ?>
                                    <tr align="center" style="font-size: 14px">
                                        <td width="35%"><?php echo $row[0] ?></td>
                                        <td width="12%"><?php echo $row[1] ?></td> 
                                        <td><?php echo $row[2] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>                        

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <div class="row">
                        <div class="col-lg-5">
                            ---------------------------------<br>
                            Doctor Signature
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <h5 style="color: #F80000">Not Valid Without Doctor Signature and Stamp</h5>
        </div>
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </body>
</html>
