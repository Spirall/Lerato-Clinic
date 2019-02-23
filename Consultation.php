<?php
if (!isset($_SESSION)) {
    session_start();
}
 if(!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor'){
    header("Location: signout.php");
}
date_default_timezone_set('Africa/Johannesburg');
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
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
    include 'Pages/DoctorHeader.html';
    
    //call connection to mysql
    include 'Classes/connection.php';
    ?>

        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="container"  align="center" style="padding-left: 10%;  margin-top: -20px;">
                <div class="panel panel-default col-lg-9">
                    <div class="panel-body"> 
                        <?php
                        if(!isset($_GET['search'])){
                        ?>    
                        <div class="page-header"   style="margin-bottom: 0;">
                                Enter Patient to Consult
                            </div>
                            <div class="row">
                                <div class="col-lg-4">                           
                                </div>
                               <div class="col-lg-7">
                            <form action="Consultation.php" class="navbar-form navbar-left" role="search" method="Get">
                                <div class="form-group">
                                    <input type="text" class="form-control" name= "patientid" placeholder="Enter Patient ID" required="">
                                </div>
                            <button type="submit" class="btn btn-default" name="search">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </form>
                                </div>
                            </div>
                        <?php
                        }else if(isset($_GET['search'])){
                         $patientid = $_GET['patientid'];   
                         $Selectquery = "select surname, firstname, gender, dob from patient where patientid = '$patientid'";
                         $queryresults = mysql_query($Selectquery);
                         $result = mysql_fetch_row($queryresults);
                         //check if patient exist
                           if(!empty($result)){
                             
                            $Selectquery = "select max(consultationno) from consultation where patientid = '$patientid'";
                            $queryresults = mysql_query($Selectquery);   
                            $consult = mysql_fetch_row($queryresults);   
                               
                            $Selectquery = "select doctorid from consultation where consultationno = '$consult[0]'";
                            $queryresults = mysql_query($Selectquery);   
                            $docid = mysql_fetch_row($queryresults);
                            
//                            $Selectquery = "select outstandingbalance from account where patientid = '$patientid'";
//                            $queryresults = mysql_query($Selectquery);   
//                            $result2 = mysql_fetch_row($queryresults);
//                            
//                            $Selectquery = "select max(paymentdate) from payment where patientid = '$patientid' and paymenttype = 'Medical Aid'";
//                            $queryresults = mysql_query($Selectquery);   
//                            $result3 = mysql_fetch_row($queryresults);
                        ?>
                        <div class="page-header"   style="margin-bottom: 0;">
                               Consultation Page <br>Step 1
                        </div>
                        <p></p>
                        <?php echo "Patient $result[0] $result[1]"; ?>
                        <p></p>
                            <div class="row">
                              <?php 
                                
                              //check if patient paid for consultation
                              if(empty($docid[0]) && !empty($consult[0])){
                                ?>
                                <div class="col-lg-5">
                                    <label for="Gender" class="" style="margin-bottom:0px">Last Diagnosis</label>
                                   <div>
                                       <?php
                                       $consultationno = 0;
                                       $lastconsultationno = 0;
                                       //select all consultation of the patient
                                       $Selectquery = "select consultationno from consultation where patientid = '$patientid'";
                                       $queryresults = mysql_query($Selectquery);
                                       $consultation = array();
                                       
                                       while($result = mysql_fetch_row($queryresults)){
                                       $consultation[] =  $result[0];
                                       }
                                       
                                       $count = count($consultation) - 2;
                                       
                                       if($count > -1){
                                       $lastconsultationno = $consultation[$count];
                                       }
                                       
                                       
                                       $Selectquery = "select max(consultationno) from consultation where patientid = '$patientid'";
                                       $queryresults = mysql_query($Selectquery);
                                       $result2 = mysql_fetch_row($queryresults);
                                       $consultationno = $result2[0];
                                       
                                       
                                       $Selectquery = "select doctorid from consultation where consultationno = '$lastconsultationno'";
                                       $queryresults = mysql_query($Selectquery);
                                       $result1 = mysql_fetch_row($queryresults);
                                       $view = TRUE;
                                       if(empty($result1[0])){
                                        echo "<textarea rows='6' class='form-control' disabled>No diagnosis for new patient</textarea>";   
                                       $view = FALSE;
                                       }
                                       else{
                                       $Selectquery = "select distinct(d.symptoms) from diagnosis d, prescription p where d.icd10_code = p.icd10_code and p.consultationno = $lastconsultationno";
                                       $queryresults = mysql_query($Selectquery);
                                       
                                       echo "<textarea rows='6' class='form-control' disabled>";
                                       
                                       while($resultdiagn = mysql_fetch_row($queryresults)){
                                          echo $resultdiagn[0] . "\n";  
                                       }
                                       echo "</textarea>";
                                       }
                                       ?>
                                    </div>
                                    <p></p>
                                    <div>
                                     <?php
                                     if($view == TRUE){
                                     ?>
                                        <form action="PatientRecord.php" method="POST">
                                            <input type="hidden" name="patientId" value="<?php echo $patientid;?>">
                                        <button type="submit" name= "SearchPatient" class="btn btn-default form-control">
                                        View History
                                        </button> 
                                        </form>
                                     <?php
                                     }else{
                                     ?>
                                        <button type="submit" name= "SearchPatient" class="btn btn-default form-control" disabled>
                                        View History
                                    </button>     
                                     <?php
                                     }
                                     ?>
                                    </div>
                                </div>
                                <form action="Consultation2.php" method="get">
                                <div class="col-lg-4">
                                <label for="Gender" class="" style="margin-bottom:0px">Patient Weight</label>
                                <div>
                                    <input type="number" min="10" max = "400" name="Weight" title="Weight should be from 10 to 400 Kg" class="form-control" placeholder="Weight in Kg" required>
                                </div>
                                <br/>
                                 <label for="Gender" class="" style="margin-bottom:0px;">Patient Blood Pressure</label>  
                                <div>
                                    <select name = 'bloodpressure' class="form-control">
                                       <option value ='Low Blood Pressure'>Low Blood Pressure</option>
                                       <option value ='Ideal Blood Pressure'>Ideal Blood Pressure</option>
                                       <option value ='Pre-High Blood Pressure'>Pre-High Blood Pressure</option>
                                       <option value ='High Blood Pressure'>High Blood Pressure</option>
                                    </select>
                                </div> 
                                 <p></p>
                                 <br>
                                    <a href="Consultation.php">
                                    <button type="button" class="btn btn-default form-control" name="search">
                                        <<< BACK
                                    </button>
                                    </a> 
                                </div>
                                <div class="col-lg-3">
                                    <br><br><br>
                                    <input type="hidden"  name="consultationo" value="<?php echo $consultationno?>"> 
                                    <input type="hidden"  name="patientid" value="<?php echo $patientid?>"> 
                                  <button type="submit" name= "step2" class="btn btn-default form-control" name="search">
                                  Next >>>
                                  </button>
                                </div>   
                             </form>
                                
                                 <?php
                                }else{
                                echo "<p></p><div style='color:#F80000'>Patient Not allowed to consult due to payment, Please send patient to the clerk for processing payment</div><br>";    
                                
                                echo "<a href='Consultation.php'>".
                              "<button type='submit' class='btn btn-default' name='search'>".
                                "<< BACK".
                            "</button>".
                            "</a>";
                                
                                }
                                ?>  
                                </div>
                            </div>
                        <?php
                           }else{
                              ?>
                        <div class="page-header"   style="margin-bottom: 0;">
                            <h4 style="color: #F80000">Patient with ID Number "<?php echo  $patientid; ?>" Not Found<h4>
                            </div>
                        <br>
                            <div class="row" >
                                <div class="col-lg-3">                           
                                </div>
                               <div class="col-lg-7">
                                   <a href="Consultation.php">
                            <button type="submit" class="btn btn-default" name="search">
                                <<< BACK
                            </button>
                            </a>
                                </div>
                            </div>         
                        <?php       
                           }} 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if(isset($_SESSION['consultation'])){
         ?>
        <script>
        alert("Consultation Finish Successfully");
        </script>
        <?php
        unset($_SESSION['consultation']);
        }
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
     </body>
</html>
