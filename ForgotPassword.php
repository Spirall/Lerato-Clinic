<!DOCTYPE html>
<!--Forgot password page
-->
<html>


    <head>

        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        <?php
        include 'Classes/CssLink.html';
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">
    </head>

    <body>
        <?php
        //call navigation 
        include 'Pages/Header.php';

        //call connection to mysql
        include 'Classes/connection.php';
        ?>

        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="container"  align="center" style="padding-left: 10%;  margin-top: -20px;">
                <div class="panel panel-default col-lg-9">
                    <?php
                    if (!isset($_POST['search'])) {
                        ?>
                        <div class="panel-body">
                            <div class="page-header"   style="margin-bottom: 0" align="center">
                                <b>Enter Your Email Address/UserName</b>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">                           
                                </div>
                                <div class="col-lg-8">
                                    <form action="ForgotPassword.php" class="navbar-form navbar-left" role="search" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name= "email" placeholder="Email Address" required>
                                        </div>
                                        <button type="submit" class="btn btn-default form-control" name="search">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else if (isset($_POST['search'])) {
                        $email = $_POST['email'];

                        $Selectquery = "select username,rights,password from log where username = '$email'";
                        $queryresults = mysql_query($Selectquery);
                        $result1 = mysql_fetch_row($queryresults);

                        if (!empty($result1[0])) {
                            if ($result1[1] == "admin") {
                                $Selectquery = "select fullname from log where username = '$email'";
                                $email = "leratoclinic@leratoclinic.co.za";
                                $queryresults = mysql_query($Selectquery);
                                $result2 = mysql_fetch_row($queryresults);
                                $fullname = "Administrator " . $result2[0];
                            } else if ($result1[1] == "clerk") {
                                $Selectquery = "select surname, firstname from clerk where email = '$email'";
                                $queryresults = mysql_query($Selectquery);
                                $result2 = mysql_fetch_row($queryresults);
                                $fullname = "Clerk $result2[0] $result2[1]";
                            } else if ($result1[1] == "doctor") {
                                $Selectquery = "select surname, firstname from doctor where email = '$email'";
                                $queryresults = mysql_query($Selectquery);
                                $result2 = mysql_fetch_row($queryresults);
                                $fullname = "Doctor $result2[0] $result2[1]";
                            } else {
                                $Selectquery = "select surname, firstname from patient where email = '$email'";
                                $queryresults = mysql_query($Selectquery);
                                $result2 = mysql_fetch_row($queryresults);
                                $fullname = "Patient $result2[0] $result2[1]";
                            }
                            ?>
                            <div class="panel-body">
                                <div class="page-header"   style="margin-bottom: 0;" align="center">
                                    <?php echo $fullname; ?>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-2">                           
                                    </div>
                                    <div class="col-lg-8">
                                        <form action="ForgotPassword.php"  method="post">
                                            <div>
                                                <label>Send Password To</label><br>
                                                <label><?php echo $email ?></label><br><br>
                                            </div>
                                            <div>
                                                <input type="hidden" name="email" value="<?php echo $email ?>">
                                                <input type="hidden" name="password" value="<?php echo $result1[2] ?>">
                                                <button type="submit" class="btn btn-default form-control" name="submitpassword">
                                                    Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            
                            <div class="panel-body">
                            <div class="page-header"   style="margin-bottom: 0;" align="center">
                                Enter Your Email Address
                            </div>
                            <div class="row">
                                <div class="col-lg-3">                           
                                </div>
                                <div class="col-lg-8">
                                    <form action="ForgotPassword.php" class="navbar-form navbar-left" role="search" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name= "email" placeholder="Email Address" required>
                                        </div>
                                        <button type="submit" class="btn btn-default form-control" name="search">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                                <p></p>
                                <p align= "center" style="font-size: 12px;color: #F80000;margin-left:-95px">Email Address <?php echo $email?> Not Found!</p>
                        </div>   
                    
                            <?php
                        }
                    }

                    if (isset($_POST['submitpassword'])) {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $response = "You have requested your password from lerato clinic \n"
                                . "username: $email \n"
                                . "Password: $password \n"
                                . "You are uble to change you password whenlog in \n"
                                . "\n \n"
                                . "Leratoclinic.nodejhb.co.za"
                                . "\n Leratoclinic.empirestate.co.za";

                        $mail = mail($email, 'Response From Lerato Clinic', $response);

                        if ($mail) {
                            $message = "password sent succesfuly to $email";
                            
                        } else {

                            $message = "could not sent passord to $email";
                        }
                        echo "<script>"
                        . "alert('$message')"
                                . "</script>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </body>
</html>
