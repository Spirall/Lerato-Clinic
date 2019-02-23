<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
    header("Location: signout.php");
}
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
                                <img src="Images/LeratoClinicLogo2.jpg" width ="100%" height ="120px">
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-lg-5" >
                            </div>
                            <div class="col-lg-5" >
                                <h3 style="margin-top: 0px;"><b>Sick Note</b></h3>
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
                        <div class="row">
                            <div class="col-lg-3" >
                            </div>
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-lg-5" >
                                        <label>From:  <?php 
                                        if(isset($_POST['print'])){
                                         echo date("d-M-Y",  strtotime($_POST['From']));   
                                        }
                                        ?>
                                         </label>
                                    </div>
                                    <div class="col-lg-5" >
                                        <label>To: <?php 
                                        if(isset($_POST['print'])){
                                        echo date("d-M-Y",  strtotime($_POST['To']));    
                                        }
                                        ?>
                                        </label>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-3" >
                            </div>
                            <div class="col-lg-6">
                                <table border="0" class="table-responsive" style="background-color:#eee;width: 99%" align="center">

                                    <?php
                                    $consultationno = $_SESSION['consultationo'];

                                    $Selectquery = "select comment from consultation where consultationno = '$consultationno'";
                                    $queryresults = mysql_query($Selectquery);
                                    $row = mysql_fetch_row($queryresults)
                                    ?>
                                    <tr align="center" style="font-size: 14px">
                                        <?php 
                                        $commentadd = $_POST['addedcomment'];
                                        $comment = $row[0]. "<br>" .$commentadd;
                                         echo $comment;       
                                        ?>
                                    </tr>  
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
        <script>
            function myFunction() {
                window.print();
            }
        </script>
    </body>
</html>
