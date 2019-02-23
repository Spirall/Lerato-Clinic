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
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">
        <script src="bootstrap/js/jquery-1.11.2.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#picture").click(function() {
                    $("#profil").fadeOut("fast");
                    $("#pop").fadeIn("fast");
                });

                $("#edit").click(function() {
                    $("#pop").fadeOut("fast");
                    $("#profil").fadeIn("fast");
                });
                $("#passwordbtn").click(function() {
                    $("#profil").fadeOut("fast");
                    $("#profil").fadeOut("fast");
                    $("#password").fadeIn("fast");

                });
            });
        </script>

    </head>
    <?php
    //call navigation 
    include './Pages/DoctorHeader.html';

    //call connection to mysql
    include './Classes/connection.php';

    //call the upload picture script when button submit picture from popprofilpicture pressed
    include './Classes/UploadPicture.php';

    //call the edit profil script when button submitdetails from pop edit profil pressed
    include './Classes/UpdateDetails.php';

    //call the edit profil script when button submitdetails from pop edit profil pressed
    include './Classes/UpdatePassword.php';
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="panel panel-default col-lg-3" style="margin-top: -20px;margin-left: 5px;">
                    <div class="panel-body"> 
                        <div class="panel-body">
                            <div class="page-header">
                                <h4 align ="center" style="padding-top: 0px">Doctor Information</h4>
                            </div>

                            <a href="#" id="picture">
                                <?php
                                $email = $_SESSION['email'];

                                $Selectquery = "select surname,firstname,profilpicture,gender,doctorid from doctor where email = '$email'";
                                $queryresults = mysql_query($Selectquery);


                                $rows = mysql_fetch_row($queryresults);
                                $surname = $rows[0];
                                $firstname = $rows[1];
                                $picture = $rows[2];
                                $gender = $rows[3];
                                $doctorid = $rows[4];
                                if ($picture != 'None') {
                                    echo "<p align = 'center'><img src='Images/Stuff/Doctor/$picture' width='90%' style='border-radius: 10px;background-color:#660099;height: 150px;width: 200px;'></p>";
                                } else {
                                    if ($gender == 'F') {
                                        echo "<p align = 'center'><img src='Images/Stuff/Woman.png' width='90%' style='border-radius: 10px;background-color:#660099;height: 150px;width: 200px;'></p>";
                                    } else {
                                        echo "<p align = 'center'><img src='Images/Stuff/Man.png' width='90%' style='border-radius: 10px;background-color:#660099;height: 150px;width: 200px;'></p>";
                                    }
                                }
                                ?>
                            </a>
                            <br>
                            <h4 align="center">Welcome</h4>
                            <p></p>
                            <h5 align="center">Dr. <?php echo $firstname, " ", $surname; ?></h5>
                            <p></p>
                            <p align="center" style="margin-bottom: -5px;  font-size: 17px;"><input type="button" value="Edit Profil" id="edit"></p>
                            <div class="left carousel-control" >
                            </div>
                            <div class="right carousel-control" >
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-2">

                </div>

                <div class="panel panel-default col-md-6" style="border: solid; margin-top: -20px">
                    <div class="panel-body">
                        <div class="page-header">
                            <div class="row">
                                <div class="col-lg-11"></div>  
                                <form action="Help.php" method="get">
                                <div class="col-lg-1">
                                  <input type="hidden" name="help" value="1007">
                                   <button type="submit" class="btn btn-default">
                                           <span class="glyphicon glyphicon-question-sign" style="  top: 2px;"></span> 
                                   </button>
                                </div> 
                               </form>
                            </div>
                            <h4 align ="center" style="padding-top: 0px">My Dashboard</h4>
                        </div>

                        <p align="center">Schedule</p>

                        <table border="2" class="table-responsive" style="background-color:#eee;width: 99%" align="center"> 
                            <tr align="center">
                                <td><b>Day</b></td>  
                                <td><b>Start Time</b></td>  
                                <td><b>End Time</b></td>  
                            </tr>

                            <?php
                            $Selectquery = "select days,starttime,endtime from schedule where doctorid = '$doctorid'";
                            $queryresults = mysql_query($Selectquery);

                            while ($row = mysql_fetch_row($queryresults)) {
                                ?>
                                <tr align="center">
                                    <?php
                                    $starttime;
                                    $endtime;
                                    if ($row[1] < 12) {
                                        $starttime = $row[1] . " AM";
                                    } else {
                                        $starttime = $row[1] . " PM";
                                    }
                                    if ($row[2] < 12) {
                                        $endtime = $row[2] . " AM";
                                    } else {
                                        $endtime = $row[2] . " PM";
                                    }
                                    ?>
                                    <td><?php echo $row[0]; ?></td>  
                                    <td><?php echo $starttime ?></td>  
                                    <td><?php echo $endtime ?></td>  
                                </tr>
                                <?php
                            }
                            ?>
                        </table>

                    </div>
                </div>


                <?php
                include './Classes/PopProfilPicture.php';

                include './Classes/PopEditProfil.php';

                include './Classes/PopPassword.php';
                ?>

            </div>
        </div>
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
