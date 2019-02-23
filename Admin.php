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
This is the main Administrator page
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
            $(document).ready(function() {
                $("#edit").click(function() {
                    $("#password").fadeIn("fast");
                });
            });
        </script>

    </head>
    <?php
    //call navigation 
    include './Pages/AdminHeader.html';

    //call connection to mysql
    include './Classes/connection.php';
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2">

                </div>
                <div class="col-md-1">

                </div>

                <div class="panel panel-default col-md-6" style="border: solid; margin-top: -20px">
                    <div class="panel-body"> 
                            <div class="page-header">
                                <div class="row">
                                <div class="col-lg-11"></div>  
                                <form action="Help.php" method="get">
                                <div class="col-lg-1">
                                  <input type="hidden" name="help" value="1009">
                                   <button type="submit" class="btn btn-default">
                                           <span class="glyphicon glyphicon-question-sign" style="  top: 2px;"></span> 
                                   </button>
                                </div> 
                               </form>
                                </div>
                                <h4 align ="center" style="padding-top: 0px">My Dashboard</h4>
                            </div>

                            <h4 align="center">Welcome Administator</h4>
                            <?php
                            $email = $_SESSION['email'];
                            $Selectquery = "select fullname from log where username = '$email'";
                            $queryresults = mysql_query($Selectquery);
                            $rows = mysql_fetch_row($queryresults);
                            $fullname = $rows[0];

                            echo "<p></p><h5 align='center'>" . $fullname . "</h5>";
                            ?>

                            <br><br>

                            <p align="center" style="margin-bottom: -5px;  font-size: 17px;"><input type="button" class="btn btn-default" value="Update Password" id="edit"></p>

                       
                    </div>
                </div>
                <?php
                include './Pages/PopAdminPassword.php';


                if (isset($_POST['submitpassword'])) {

                    $email = $_SESSION['email'];
                    $Oldpassword = $_POST['Old_Password'];
                    $NewPassword = $_POST['NewPassword'];
                    $Confirnpasswod = $_POST['ConfirmPassword'];


                    $Selectquery = "select password from log where username = '$email' and password = '$Oldpassword'";
                    $queryresults = mysql_query($Selectquery);
                    $rows = mysql_fetch_row($queryresults);


                    if (!empty($rows[0])) {
                        if (trim($NewPassword) == trim($Confirnpasswod)) {
                            //update the database with the new DOB
                            $Selectquery = "update log set password = '$NewPassword' where username = '$email'";
                            $queryresults = mysql_query($Selectquery);

                            if ($Selectquery === FALSE) {
                                ?>
                                <script>
                                    alert("Error Occured while inserting into the database!!");
                                </script>

                                <?php
                            } else {
                                ?>
                                <script>
                                    alert("Password Changed successful!");
                                </script>

                <?php
            }
        } else {
            ?>
                            <script>
                                alert("Password does not match, Password Not Updated!!");
                            </script>
                            <?php
                        }
                    } else {
                        ?>
                        <script>
                            alert("Incorrect Old password,Password not updated!!");
                        </script>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
                <?php
                include 'Pages/Footer.php';
                include 'Classes/JsScript.html';
                ?>
    </body>
</html>
