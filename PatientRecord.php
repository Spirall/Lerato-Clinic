<?php
if (!isset($_SESSION)) {
    session_start();
}

 if(!isset($_SESSION['email']) && $_SESSION['right'] != 'doctor'){
    header("Location: index.php"); 
 }
?>

<!DOCTYPE html>
<!--
This Page is used to get patient report
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
        
   date_default_timezone_set('Africa/Johannesburg');
    //call navigation 
    include 'Pages/DoctorHeader.html';
    //call connection to mysql
    include 'Classes/connection.php';
    
    if(isset($_POST['SearchPatient'])){
                $patientid = $_POST['patientId'];
                
                $Selectquery = "select ConsultationNo, DoctorID, consultationDate from consultation where patientid = '$patientid'";
                $queryresults = mysql_query($Selectquery);
                $consultationNo = array();
                $doctorId = array();
                $date = array();
                
                
                while($rows = mysql_fetch_row($queryresults)){
                   $consultationNo[]= $rows[0];
                   $doctorId[]= $rows[1];
                   $date[]= $rows[2];
    }
    }
    
    ?>

        <div class ="jumbotron" style="margin-top: -15px;">
                     <?php
                      if(empty($consultationNo)){
                      ?>
            <div class="container"  align="center" style="padding-left: 10%;margin-top: -20px;">
                <div class="panel panel-default col-lg-9"> 
                                  
                        <div class="panel-body">
                           <div class="page-header" style="margin-bottom: 0;">
                                Search Specific Patient Record
                            </div>
                            <div class="row" >
                                <div class="col-lg-4">
                                </div>
                               <div class="col-lg-7">
                                   <form action = 'PatientRecord.php' class="navbar-form navbar-left" role="search" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter Patient ID" name='patientId' required="">
                                </div>
                            <button type="submit" class="btn btn-default" name = 'SearchPatient'>
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                                   </form>
                                </div>
                            </div>
                         </div>
                     </div>
                 </div>
                    <?php
                    }
                    ?>
            
            
           

                 <?php
            
                if(isset($_POST['SearchPatient'])){
                if(!empty($consultationNo)){
                ?>
                <div class="row" >
                <div class="row" style="  margin-top: -25px;margin-left: 5px;margin-right: 5px;">
                    <div class="panel panel-default col-lg-12">
                    <div class="panel-body">
                               <div class="col-lg-12" style="height: 300px;overflow:scroll">
                                <?php
                                
                                $Selectquery = "select surname,firstname from patient where patientid = '$patientid'";
                                $queryresults = mysql_query($Selectquery);
                                $result = mysql_fetch_row($queryresults);
                                ?>
                                
                                <h4 align="center" style="margin-bottom: 1px">Consultation Details For Patient</h4>
                                <p align="center" style="font-size: 16px;margin-bottom: 1px"><?php echo "$result[0] $result[1]"; ?></p>
                                
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center"> 
                                <tr align="center">
                                     <td>Doctor</td>
                                     <td>Date</td>
                                     <td>Weight</td>
                                     <td>Blood Pressure</td>
                                     <td>Diagnosis</td>
                                     <td>Medications</td>
                                     <td>Print Prescription</td>
                                     <td>Print Sick Note</td>
                                </tr>
                                <?php
                                $Selectquery = "select consultationno,doctorid,consultationdate,patientweight,patientbloodpresure from consultation where patientid = '$patientid' order by consultationno desc";
                                $queryresults = mysql_query($Selectquery);
                                while($result1 = mysql_fetch_row($queryresults)){
                                   
                                    $Selectquery2 = "select surname,firstname from doctor where doctorid = '$result1[1]'";
                                   $queryresults2 = mysql_query($Selectquery2); 
                                   $result2 = mysql_fetch_row($queryresults2);
                                   if(!empty($result2[0])){
                                 ?>  
                                   
                                <tr align="center" style="font-size: 12px">
                                     <td><?php echo "$result2[0] $result2[1]"; ?></td>
                                     <td><?php 
                                     $date = $result1[2];
                                     echo $result1[2] ?></td>
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
                                     <td>
                                         <form action="PrescriptionReport2.php" target="_blank" method="Get">
                                             <input type ="hidden" name="consultationno" value="<?php echo $result1[0]?>">
                                       <button type="submit" name= "convert" class="btn btn-default form-control">
                                       Print Prescription
                                        </button>
                                         </form>
                                     </td>
                                     <td width="15%">
                                         <form action="SickNote2.php" target="_blank" method="Get">
                                             <input type ="hidden" name="consultationno" value="<?php echo $result1[0]?>">
                                      <?php
                                      $now = date('Y-m-d',  strtotime("-90 day"));
                                      if($date < $now){
                                          echo "Expired <br>(Available for last 3 months Only)";
                                      }else{
                                      ?>
                                       <button type="submit" name= "convert" class="btn btn-default form-control">
                                       Print Sick Note
                                        </button>
                                      <?php
                                      }
                                      ?>      
                                       </form>
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
            <?php
                }else{
            ?>
            <div class="container"  align="center" style="padding-left: 10%">
                <div class="panel panel-default col-lg-9"> 
                       <div class="panel-body"> 
                      <div class="page-header" style="margin-bottom: 0;color: #F80000">
                    Patient consultation records not found!!, Please make sure that the patient exist and has consulted before
                       </div>
                    </div>
                </div>
                    
            </div>
               
            
            <?php
            }}
            ?>
       </div>
    </div>
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
     </body>
</html>
