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
This is a page reserved for patient to see their past consultation diagnosis and prescription
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
    include 'Patient/PatientHeader.html';
    //call connection to mysql
    include 'Classes/connection.php';
    
    if(isset($_POST['deleteapp'])){
       $appno = $_POST['appno']; 
        
       $Selectquery = "delete from appointment where appointmentno = $appno";
       $queryresults = mysql_query($Selectquery);
       
    }
    
    
    ?>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class=""  align="center" style="padding-left: 0%">
                <div class="row" style="  margin-top: -25px;margin-left: 5px;margin-right: 5px;">
                    <div class="panel panel-default">
                    <div class="panel-body"> 
                       <div class="page-header"   style="margin-bottom: 0;">
                                <h4>My Appointment</h4>
                        </div>
                        <p></p>
                       <div style="height: 300px;overflow:scroll">
                                <?php
                                $email = $_SESSION['email'];
                                $Selectquery = "select surname,firstname,patientid from patient where email = '$email'";
                                $queryresults = mysql_query($Selectquery);
                                $result = mysql_fetch_row($queryresults);
                                ?>
                                
                                <p align="center" style="font-size: 16px;margin-bottom: 1px"><?php echo "$result[0] $result[1]"; ?></p>
                                
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center"> 
                                <tr align="center">
                                    <td><b>Appointment No</b></td>
                                     <td><b>Appointment Date</b></td>
                                     <td><b>Appointment time</b></td>
                                     <td><b>Doctor Available</b></td>
                                     <td><b>Cancel</b></td>
                                </tr>
                                <?php
                                $id = $result[2];
                                $date = date("Y-m-d", strtotime("- 1 days"));
                                $Selectquery = "select * from appointment where patientid = '$id' and appointmentdate > '$date'";
                                $queryresults = mysql_query($Selectquery);
                                
                                while($result = mysql_fetch_row($queryresults)){
                                   
                                 ?>  
                                   
                                <tr align="center" style="font-size: 12px">
                                     <td><?php echo $result[0] ?></td>
                                     <td>
                                      <?php 
                                     $displdate = date("d-m-Y",  strtotime($result[4]));
                                     $displday = date("l",  strtotime($result[4]));
                                     echo $displday." / ". $displdate;
                                      ?>
                                     </td>
                                     <td><?php echo $result[5] ?></td>
                                     <td><?php
                                     $day = date("l",  strtotime($result[4]));
                                     $Selectquery3 = "select d.surname,d.firstname, s.starttime,s.endtime from doctor d, schedule s where d.doctorid = s.doctorid and s.days = '$day'";
                                     $queryresults3 = mysql_query($Selectquery3);
                                     while($result3 = mysql_fetch_row($queryresults3)){
                                         echo "$result3[0] $result3[1] : $result3[2] to $result3[3]<br/>";
                                        }
                                         ?>
                                     </td>
                                     <td>
                                         <form action="MyAppointment.php" method="post">
                                             <input type="hidden" name="appno" value="<?php echo $result[0] ?>">
                                         <input type="submit" name="deleteapp" value="Cancel" style="width: 99%"> 
                                         </form>
                                     </td>
                                </tr>
                                <?php   
                                }
                                ?>  
                               </table>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
                </div>
      
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        
        if(isset($_POST['deleteapp'])){
       echo "<script>"
            . "alert('Appointment No $appno Deleted succesfully!');"
               . "</script>";
       
          }
        ?>
     </body>
</html>
