<?php
if (!isset($_SESSION)) {
session_start();
}
if (!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk') {
header("Location: signout.php");
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
        ?>
    </head>
    <?php
    //call navigation 
    include './Clerk/ClerkHeader.php';

    //call connection to mysql
    include './Classes/connection.php';

    //include javascript page for Available hours
    include './Classes/gethourscript.html';
    ?>


    <body>
        <div class ="jumbotron" style="margin-top: -15px">
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-md-1">
                </div>
                <div class="panel panel-default col-md-6" style="margin-top: -20px">

                    <div class="panel-body">
                        <div class="page-header"   style="margin-bottom: 0;">
                            <div align="center"><b>Make an Appointment</b></div>
                        </div>
                        <br>
                        <?php
                        if (!isset($_GET['submitid'])) {
                        ?>
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <form action="MakeappClerk.php" method="get">
                                <div class="col-lg-7 navbar-form navbar-left" role="search" >
                                    <div class="form-group">
                                        <input type="text" name ="patientid" class="form-control" placeholder="Enter Patient ID" required>
                                    </div>
                                    <button type="submit" name="submitid" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <?php
                        }
                        if (isset($_GET['submitid'])) {
                        $id = $_GET['patientid'];

                        $Selectquery = "select surname, firstname from patient where patientid= '$id'";
                        $queryresults = mysql_query($Selectquery);
                        $result = mysql_fetch_row($queryresults);
                        if (!empty($result[0])) {
                        ?>



                        <form action="MakeappClerk.php" class="form-horizontal" method="POST">
                            <div class="form-group">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="ID-Number" class="" style="margin-bottom:0px">ID Number</label>
                                        <div>
                                            <?php
                                            $_SESSION['person_id'] = $id;
                                            echo "<input type='text' class='form-control' name='ID-number' placeholder='Enter your ID Number' value='$id' disabled>";
                                            ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Surname" class="" style="margin-bottom:0px">Full Name</label>
                                        <div >
                                            <?php
                                            echo "<input type='text' class='form-control' name='Surname' placeholder='Enter your Surname' value='$result[0] $result[1]' disabled>";
                                            ?>
                                        </div>
                                    </div> 

                                </div>
                            </div> <!--End Form Group-->

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="Appointment_Date" class="" style="margin-bottom:0px">Appointment Date</label>
                                        <div>


                                            <input type="date" onchange="showUser(this.value)" max="<?php echo date("Y-m-d", strtotime("+2 weeks")); ?>" min="<?php echo date("Y-m-d", strtotime("+1 days")); ?>" class="form-control" name="Appointment_Date" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Appointment_Time" class="" style="margin-bottom:0px">Appointment Time</label>
                                        <div id = "txtHint">
                                            <div>
                                                <select  name = 'time' class="form-control">

                                                    <?php
                                                    for ($i = 8;
                                                    $i < 17;
                                                    $i++) {
                                                    $descr;


                                                    if ($i < 12) {
                                                    $descr = "AM";
                                                    } else {
                                                    $descr = "PM";
                                                    }


                                                    $fisttime = "$i:00";
                                                    $secondtime = "$i:30";


                                                    echo "<option value ='$i:00'>$fisttime $descr</option>";
                                                    echo "<option value ='$i:30'>$secondtime $descr</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div> 

                                            <div class="row" style="margin-bottom: -20px">
                                                <br/>
                                                <div class="col-md-6">
                                                    <a href ="Appointment.php" ><button type="button" name= "submit_Reg" class="btn btn-default" class="AlignLeft"> Reset </button></a>
                                                </div>
                                                <div class="col-md-6">
                                                    <div id="hidd">
                                                        <button type='submit'  name= 'submit_app' class='btn btn-default' class='AlignLeft'>Submit</button>
                                                    </div>    
                                                </div>
                                            </div>

                                        </div> 
                                    </div>
                                </div> <!--End Form Group-->

                            </div>
                        </form> 
                        <?php
                        } else {
                        ?> 
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <form action="MakeappClerk.php" method="get">
                                <div class="col-lg-7 navbar-form navbar-left" role="search" >
                                    <div class="form-group">
                                        <input type="text" name ="patientid" class="form-control" placeholder="Enter Patient ID" required>
                                    </div>
                                    <button type="submit" name="submitid" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                            </form>
                            <h5 style="color: #F80000">Patient with id number <?php echo $id ?> Not Found!</h5>
                        </div>

                        <?php
                        }}
                        ?>
                        
                        
                    </div>
                </div>
            </div>
        
        
        <?php
        if (isset($_POST['submit_Reg'])) {

                        $clerkemail = $_SESSION['email'];
                        $id = $_SESSION["person_id"];
                        $clerkid;
                        $appointdate = $_POST['Appointment_Date'];
                        $appointtime = $_POST['time'];

                        $Selectquery = "select clerkid from clerk where email ='$clerkemail'";
                        $queryresults = mysql_query($Selectquery);
                        $result = mysql_fetch_row($queryresults);
                        $clerkid = $result[0];

                        $Selectquery = "insert into appointment(patientid,time,date,appointmentdate,appointmenttime,clerkid) values('$id',curtime(),curdate(),'$appointdate','$appointtime','$clerkid')";
                        $queryresults = mysql_query($Selectquery);


                        $Selectquery = "select surname, title from patient where patientid = '$id'";
                        $queryresults = mysql_query($Selectquery);
                        $rows = mysql_fetch_row($queryresults);

                        $surname = $rows[0];
                        $title = $rows[1];
                        ?>

                        <br><br>
                        <div class="container"  align="center" style="padding-left: 11%">
                            <div class="panel panel-default col-lg-8">
                                <div class="panel-body"> 
                                    <h5 align ="center" style="padding-top: 0px;color: #F80000"><?php
                                        $appointdate = date('d-M-Y', strtotime($appointdate));
                                        echo "Appointment  for $title $surname, has been submited for $appointdate at $appointtime. Thank you for choosing "
                                        . "Lerato Clinic";
                                        ?>
                                    </h5> 
                                </div>
                            </div>
                        </div>

                        <?php
                        }
                        ?>
        </div>
   </body>
</html>
