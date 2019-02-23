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
    
    ?>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class=""  align="center" style="padding-left: 0%">
                <div class="row" style="  margin-top: -25px;margin-left: 5px;margin-right: 5px;">
                    <div class="panel panel-default">
                    <div class="panel-body"> 
                       <div class="page-header"   style="margin-bottom: 0;">
                                <h4>My Consultation</h4>
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
                                    <td><b>Doctor</b></td>
                                     <td><b>Date</b></td>
                                     <td><b>Start time</b></td>
                                     <td><b>End Time</b></td>
                                     <td><b>Diagnosis</b></td>
                                     <td><b>Medications</b></td>
                                </tr>
                                <?php
                                $id = $result[2];
                                $Selectquery = "select consultationno,doctorid,consultationdate,starttime,endtime from consultation where patientid = '$id'";
                                $queryresults = mysql_query($Selectquery);
                                
                                while($result1 = mysql_fetch_row($queryresults)){
                                   $Selectquery2 = "select surname,firstname from doctor where doctorid = '$result1[1]'";
                                   $queryresults2 = mysql_query($Selectquery2); 
                                   $result2 = mysql_fetch_row($queryresults2);
                                   if(!empty($result2[0])){
                                 ?>  
                                   
                                <tr align="center" style="font-size: 12px">
                                     <td><?php echo "$result2[0] $result2[1]"; ?></td>
                                     <td><?php echo $result1[2] ?></td>
                                     <td><?php echo $result1[3] ?></td>
                                     <td><?php echo $result1[4] ?></td>
                                     <td>
                                     <?php
                                     $Selectquery3 = "select distinct(d.symptoms) from diagnosis d, prescription p where d.icd10_code = p.icd10_code and p.consultationno = $result1[0]";
                                     $queryresults3 = mysql_query($Selectquery3);
                                     while($result3 = mysql_fetch_row($queryresults3)){
                                         echo "$result3[0]<br/>";
                                        }
                                     ?>
                                     </td>
                                     <td>
                                        <?php
                                     $Selectquery4 = "select m.name from medication m, prescription p where m.medicinecode = p.medicinecode and p.consultationno = $result1[0]";
                                     $queryresults4 = mysql_query($Selectquery4);
                                     while($result4 = mysql_fetch_row($queryresults4)){
                                         echo "$result4[0]<br/>";
                                        }
                                     ?>
                                     </td>
                                </tr>
                                <?php   
                                }}
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
        ?>
     </body>
</html>
