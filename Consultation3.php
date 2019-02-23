<?php
if (!isset($_SESSION)) {
    session_start();
    
}
if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
//    header("Location: signout.php");
}
date_default_timezone_set('Africa/Johannesburg');
?>

<!DOCTYPE html>
<!--
This is consultation step 3 page, we get the patient medications
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
        $consultationno = $_SESSION['consultationo'];
        
        if(isset($_GET['next2'])){
            $comment = $_GET['comment'];
            
            $Selectquery = "update consultation set comment = '$comment' where consultationno = $consultationno";
            $queryresults = mysql_query($Selectquery);
        }
        
        
        if(isset($_POST['add'])){
             
            $notenough = "";
           
            $icdcode = $_POST['icd10_code'];
//            $prescriptionno = $_POST['prescriptionno'];
            $medicinename = $_POST['Medicine'];
            $directive = $_POST['directive'];
            $qty = $_POST['qty'];
            
            
            //get medicine code
            $Selectquery = "select medicinecode from medication where name = '$medicinename'";
            $queryresults = mysql_query($Selectquery);
            $row = mysql_fetch_row($queryresults);
            $medicinecode = $row[0];
            
            //check if medicine code exist in patient prescription
            $Selectquery = "select medicinecode from prescription where icd10_code = '$icdcode' and consultationno = $consultationno";
            $queryresults = mysql_query($Selectquery);
            $row2 = mysql_fetch_row($queryresults);
            
            if(empty($row2[0])){
             //check if medicine code exist in patient prescription
            $Selectquery = "select prescriptionno from prescription where icd10_code = '$icdcode' and consultationno = $consultationno";
            $queryresults = mysql_query($Selectquery);
            $row2 = mysql_fetch_row($queryresults);  
            $prescriptionno = $row2[0];  
            
            
             //update medicine and directive in prescription
            $Selectquery = "update prescription set medicinecode = '$medicinecode', directive = '$directive',quantity =  $qty where prescriptionno = $prescriptionno";
            $queryresults = mysql_query($Selectquery);
            
            }else{
                
             //insert medicine and directive in prescription
            $Selectquery = "insert into prescription(directive,icd10_code,medicinecode,consultationno,quantity) value('$directive','$icdcode','$medicinecode',$consultationno,$qty)";
            $queryresults = mysql_query($Selectquery);   
            }
          
            //Update Medicine quantity Here
            $Selectquery = "select inhouse,qty from medication where medicinecode = '$medicinecode'";
            $queryresults = mysql_query($Selectquery);
            $result = mysql_fetch_row($queryresults);
            if($result[0]== "Y"){
            $newQuatity = $result[1] - 1;
            
            if($newQuatity < 0){
               $notenough = "Medicine $medicinename Not Enough, Quantity ordered greater than quantity in stock"; 
            }else{
            $Selectquery = "update medication set qty = $newQuatity where medicinecode = '$medicinecode'";
            $queryresults = mysql_query($Selectquery);  
            
            //update that medicine prescription to give = Y
            $Selectquery = "update prescription set give = 'Y' where icd10_code = '$icdcode'and medicinecode = '$medicinecode' and consultationno = $consultationno";
            $queryresults = mysql_query($Selectquery);
            
            }
            }
        }
        
        if(isset($_POST['Remove'])){
        $prescriptionno = $_POST['prescriptionno'];
        
        //Update Medicine quantity Here
            $Selectquery = "select medicinecode,quantity,give from prescription where prescriptionno = '$prescriptionno'";
            $queryresults = mysql_query($Selectquery);
            $result1 = mysql_fetch_row($queryresults);
            
            $Selectquery = "select inhouse,qty from medication  where medicinecode = '$result1[0]'";
            $queryresults = mysql_query($Selectquery);
            $result2 = mysql_fetch_row($queryresults);
            
            
            if($result2[0] == "Y" && $result1[2] == "Y"){
            $newQuatity = $result2[1] + 1;
            $Selectquery = "update medication set qty = $newQuatity where medicinecode = '$result1[0]'";
            $queryresults = mysql_query($Selectquery); 
            }
            
        $Selectquery = "update prescription set medicinecode = Null, directive = Null,quantity = Null,give = 'N'  where prescriptionno = $prescriptionno";
        $queryresults = mysql_query($Selectquery);
        
        }
        
        ?>

        <div class ="jumbotron" style="margin-top: -18px;">
            <div class="row" style="margin-top: -20px;">
                <div class="panel panel-default col-lg-3" style="margin-left: 10px;margin-right: 10px" align='center'>
                    <div class="panel-body">
                       <div class="page-header"   style="margin-bottom: 0;font-size: 13px">
                           <b> In House Medicines Stock</b>
                        </div>
                        <div style="height: 100px;overflow:scroll;">
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 80%;font-size: 12px" align="center">
                                <tr align="center">
                                    <td style="">Medicine Name</td>
                                    <td>In House</td>
                                    <td>Qty Left</td>
                                    
                                </tr>
                            <?php
                            $Selectquery0 = "select distinct(m.name) from medication m,prescription p where p.medicinecode = m.medicinecode and p.consultationno = $consultationno";
                            $queryresults0 = mysql_query($Selectquery0);
                            while ($result0 = mysql_fetch_row($queryresults0)){
                            $Selectquery1 = "select inhouse, qty from medication m,prescription p where name = '$result0[0]'";
                            $queryresults1 = mysql_query($Selectquery1);
                            $row = mysql_fetch_row($queryresults1);   
                            
                             ?>   
                                <tr align='center'>
                                    <td><?php echo $result0[0] ?></td>
                                    <td><?php echo $row[0] ?></td>
                                    <td><?php echo $row[1] ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                        </div>  
                </div>
                
                
            <div class="container"  align="center" style="padding-left: 10%;  margin-top: -20px;">
               <div class="panel panel-default col-lg-10">
                    <div class="panel-body">
                        <div class="page-header"   style="margin-bottom: 0;">
                            Consultation Page <br>Step 3
                        </div><?php
                        $patientid = $_SESSION['patientid'];
                        
                        $Selectquery = "select surname, firstname from patient where  patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);
                        $row = mysql_fetch_row($queryresults);
                        
                        echo "Patient $row[0] $row[1]";
                        ?>
                        <p></p>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                Choose medicines for assigned diagnosises
                                <div style="height: 150px;overflow:scroll;">
                                    <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                            <tr align="center">
                                                <td>Diagnosis</td>
                                                <td>Symptom</td>
                                                <td>Medication</td>
                                                <td>Quantity</td>
                                                <td>Direction</td>
                                                <td>ADD</td>
                                            </tr>

                                            <?php
                                             $Selectquery0 = "select distinct(d.icd10_code) from diagnosis d, prescription p where d.icd10_code = p.icd10_code and p.consultationno = $consultationno";
                                             $queryresults0 = mysql_query($Selectquery0);
                                             
                                            while ($icd10 = mysql_fetch_row($queryresults0)){
                                            $Selectquery = "select symptoms from diagnosis where icd10_code= '$icd10[0]'";
                                            $queryresults = mysql_query($Selectquery);
                                            $symp = mysql_fetch_row($queryresults);
                                            ?>
                                            <form action="Consultation3.php" method="POST">
                                                <tr align="center" style="font-size: 12px">
                                                    <td>&nbsp;<?php echo $icd10[0]; ?>&nbsp;</td>
                                                    <td>&nbsp;<?php echo $symp[0]; ?>&nbsp;</td>
                                                    <td>
                                                       <select name = 'Medicine' class="form-control" id="icd10" required>
                                                           <?php
                                                           $medicinedb = array();
                                                           $medicenepres = array();
                                                           
                                                           $Selectquery2 = "select * from medication where discontinue = 'N' ";
                                                           $queryresults2 = mysql_query($Selectquery2);
                                                           while ($rows2 = mysql_fetch_row($queryresults2)){
                                                            $medicinedb[] = $rows2[1];
                                                           }
                                                           
                                                           $Selectquery3 = "select m.name from medication m,prescription p where p.medicinecode = m.medicinecode and p.consultationno = $consultationno";
                                                           $queryresults3 = mysql_query($Selectquery3);
                                                           while ($rows3 = mysql_fetch_row($queryresults3)){
                                                            $medicenepres[] = $rows3[0];
                                                           }
                                                           
                                                           $medicine = array_diff($medicinedb,$medicenepres);
                                                           
                                                           foreach ($medicine as $med) {
                                                            $Selectquery4 = "select qty from medication m,prescription p where name = '$med'";
                                                            $queryresults4 = mysql_query($Selectquery4);
                                                            $avail = mysql_fetch_row($queryresults4);    
                                                           echo "<option value ='$med'>$med -> Available($avail[0])</option>";
                                                           }
                                                           ?> 
                                                       </select>
                                                    </td>
                                                    <td width="12%"><input type="number" min="1" max="100" title="number from 1 to 100" class="form-control" name="qty" required></td>
                                                     <td>
                                                         <select name = 'directive' class="form-control" id="" required>
                                                             <option value ='Three Times a day'>Three Times a day</option>
                                                             <option value ='Two Times a day'>Two Times a day</option>
                                                             <option value ='Once a day'>Once a day</option>
                                                             <option value ='Every 3 Hours'>Every 3 Hours</option>
                                                             <option value ='Every 2 Hours'>Every 2 Hours</option>
                                                             <option value ='Every 1 Hour'>Every 1 Hour</option>
                                                             <option value ='Every 30 Minutes'>Every 30 Minutes</option>
                                                         </select>
                                                     </td>
                                                    <td>
                                                        
                                                        <input type="hidden" name="icd10_code" value="<?php echo $icd10[0];?>">
<!--                                                        <input type="hidden" name="prescriptionno" value="<?php //echo $prescrno[0];?>">-->
                                                        <button type="submit" name= "add" class="btn btn-default">
                                                            ADD
                                                        </button>
                                                        
                                                    </td>
                                                    </form>
                                                </tr> 
                                                
                                            <?php
                                             }
                                            ?>

                                        </table>
                                        
                                    </div> 
                            </div>
                            
                        </div>
                        <br>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                Update medicines for assigned diagnosises
                                <div style="height: 150px;overflow:scroll">
                                        <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                            <tr align="center">
                                                <td>Diagnosis</td>
                                                <td>Symptom</td>
                                                <td>Medicine</td>
                                                <td>Quantity</td>
                                                <td>Direction</td>
                                                <td>Remove</td>
                                            </tr>

                                            <?php
                                            $consultationno = $_SESSION['consultationo'];
                                            $Selectquery = "select p.icd10_code,d.symptoms,m.name, p.directive,p.prescriptionno,p.quantity,p.give from prescription p, diagnosis d,medication m where p.icd10_code = d.icd10_code and p.medicinecode = m.medicinecode and p.consultationno = $consultationno order by p.prescriptionno asc";
                                            $queryresults = mysql_query($Selectquery);
                                            while ($rows = mysql_fetch_row($queryresults)) {
                                                if($rows[6] == "Y"){
                                                echo "<tr align='center' style='font-size: 12px'>";
                                                }else{
                                                  echo "<tr align='center' style='font-size: 12px;background-color: #F80000'>";
                                                }
                                            ?>
                                                    
                                                    <td>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                                    <td>&nbsp;<?php echo $rows[1]; ?>&nbsp;</td>
                                                    <td>&nbsp;<?php echo $rows[2]; ?>&nbsp;</td>
                                                    <td width="12%">&nbsp;<?php echo $rows[5]; ?>&nbsp;</td>
                                                    <td>&nbsp;<?php echo $rows[3]; ?>&nbsp;</td>
                                                    <td>
                                                        <form action="Consultation3.php" method="POST">
                                                        <input type="hidden" name="prescriptionno" value="<?php echo $rows[4]; ?>">
                                                        <button type="submit" name= "Remove" class="btn btn-default">
                                                           Remove
                                                        </button> 
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
                        <br>
                        <div class="row">
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-4">
                                <?php
                                $Selectquery = "select p.icd10_code,d.symptoms,m.name, p.directive,p.prescriptionno,p.quantity,p.give from prescription p, diagnosis d,medication m where p.icd10_code = d.icd10_code and p.medicinecode = m.medicinecode and p.consultationno = $consultationno";
                                $queryresults = mysql_query($Selectquery);
                                $rows = mysql_fetch_row($queryresults);
                                if(!empty($rows[0])){
                                ?>
                                <a href="FinishConsultation.php">
                                <button type="submit" name= "Remove" class="btn btn-default form-control">
                                Next >>
                                </button>
                                 <?php
                                }else{
                                 ?>
                                  <a href="FinishConsultation.php">
                                      <button type="submit" name= "Remove" class="btn btn-default form-control" disabled>
                                Next >>
                                </button>  
                                 <?php
                                }
                                
                                if(!empty($notenough)){
                                echo "<script>"
                                    . "alert('$notenough')"
                                        . "</script>";
                                }
                                 ?>
                                </a>
                            </div>
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
