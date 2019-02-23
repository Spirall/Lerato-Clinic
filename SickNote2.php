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
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">

    </head>
    <?php
    //call navigation 
    include './Pages/DoctorHeader.html';
date_default_timezone_set('Africa/Johannesburg');
    //call connection to mysql
    include './Classes/connection.php';
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <form action="SickNoteReport2.php" method="GET">
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
                                $consultationNo = $_GET['consultationno'];
                            $doctorid;
                            $pateintid;
                            
                            $Selectquery = "select patientid,doctorid from consultation where consultationno = '$consultationNo'";
                            $queryresults = mysql_query($Selectquery);
                            $row = mysql_fetch_row($queryresults);
                            $patientid = $row[0];
                            $doctorid = $row[1];
                            
                            
                                
                                $Selectquery = "select surname, firstname, CellNo from doctor where doctorid = '$doctorid'";
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
                                        <label>From: </label>
                                     <div>
                                    <input type="date" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+1 days")); ?>" class="form-control" name="From" placeholder="From Date" required>
                                                                    
                                        </div>
                                    </div>
                                    <div class="col-lg-5" >
                                        <label>To: </label>
                                        <div>
                                    <input type="date" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime("+60 days")); ?>" class="form-control" name="To" placeholder="To Date" required>
                                        </div>
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
                                <label>Add Other Comment:</label> 
                                <div>
                                    <textarea name="addedcomment" class="form-control" rows="4" maxlength="200" autofocus></textarea>
                                </div>
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

            <div class="row">
                <div class="col-lg-5">

                </div>
                <div class="col-lg-2">
                    <input type ="hidden" name="consultationno" value="<?php echo $_GET['consultationno']?>">
                        <button type="submit" name= "print" class="btn btn-default form-control">
                            Print
                        </button>
                   
                    <p></p>
                    
                </div>

            </div>

        </form>
        </div>
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
