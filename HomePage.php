<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'patient'){
    header("Location: signout.php");
}
}
?>

<!DOCTYPE html>
<!--
This is the clerk home page
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        include './Classes/CssLink.html';
        ?>
        <script src="bootstrap/js/jquery-1.11.2.min.js"> </script>
        <script>
        $(document).ready(function(){
            $("#profile").click(function(){
                $("#password").fadeOut("fast");
              $("#profil").fadeIn("fast");
            });
            
            $("#btnpassword").click(function(){
                $("#profil").fadeOut("fast");
              $("#password").fadeIn("fast");
            });
        });
        </script>
        
    </head>
    <?php
    //call navigation 
    include './Patient/PatientHeader.html';
    
    //call connection to mysql
    include './Classes/connection.php';
    
    
    //call the edit profil script when button submitdetails from pop edit profil pressed
     include './Patient/UpdateDetails.php';
   
     //call the edit profil script when button submitdetails from pop edit profil pressed
     include './Patient/UpdatePassword.php';
  
    ?>
    
    <body>
        <div class ="jumbotron" style="height: 450px;margin-top: -15px;">
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
                                  <input type="hidden" name="help" value="">
                                   <button type="submit" class="btn btn-default">
                                           <span class="glyphicon glyphicon-question-sign" style="  top: 2px;"></span> 
                                   </button>
                                </div> 
                               </form>
                                </div>
                                    <h4 align ="center" style="padding-top: 0px">My Dashboard</h4>
                                </div>
                                
                                <h4 align="center">Welcome Patient</h4>
                                <?php
                                $email = $_SESSION['email'];
                                  $Selectquery = "select fullname from log where username = '$email'";
                                  $queryresults = mysql_query($Selectquery);
                                  $rows = mysql_fetch_row($queryresults);
                                  $fullname = $rows[0];
                                ?>
                                
                                <br>
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                <input type="button" class="btn btn-default form-control" value="<?php echo $fullname; ?>" id="profile">
                                </div>
                                    </div>
                            </div>                   
                </div>
                <?php
                include './Patient/PopPatientPassword.php';
                include './Patient/EditProfil.php';
                ?>
                </div>
        </div>
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
