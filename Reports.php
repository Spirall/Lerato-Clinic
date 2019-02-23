<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk'){
    header("Location: signout.php");
}
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
                                <div class="container" style="padding-left: 10%">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Reports</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                       
                                       <label align ="center">Consultation Report</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span>
                                      </span>
                                       <a href="ConsultationReport.php"><button type="submit" name="submit_Update" class="btn btn-default form-control" class="AlignLeft">Consultation Report</button></a>
                                   </div>  
                                     </div>
                               
                                    
                                    <div class="col-md-6">
                                       <label align ="center">Payment Report</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span>
                                      </span>
                                       <a href="PaymentReport.php"><button type="submit" name="submit_Add" class="btn btn-default form-control" class="AlignLeft">Payment Report</button></a>
                                   </div>
                                   </div>
                                    
                                </div>
                                </div>
                            </div>
                   </div>
                  </div>
                </div>
       
    </body>
        
        <?php
           
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
</html>
