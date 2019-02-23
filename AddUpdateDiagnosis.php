<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'admin'){
    header("Location: index.php");
}
}
?>

<!DOCTYPE html>
<!--
This is a page to add or update clerk, we got two options here, add or update
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
                <div class="panel panel-default col-md-6" style="margin-top: -20px">
                   
                            <div class="panel-body">
                                <?php if(!isset($_POST['submit_Update']) && !isset($_POST['submit_Add'])){ ?>
                                <div class="container" style="padding-left: 10%">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">OPTIONS DIAGNOSIS</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <form action="AddUpdateDiagnosis.php" method="POST">
                                       <label align ="center">Update Diagnosis</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default" class="AlignLeft">Update Diagnosis</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-6">
                                        <form action="AddUpdateDiagnosis.php" method="POST">
                                            <label align ="center">Add Diagnosis</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default" class="AlignLeft">Add Diagnosis</button>
                                    </div>
                                       </form> 
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Pages/AddDiagnosis.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Pages/UpdateDiagnosis.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
<!--                If the button to add doctor pressed -->
                <?php
                if(isset($_POST['submit_NewMed'])){
                 $ICD10Code = $_POST['ICD10Code']; 
                 $Symptom = $_POST['Symptoms'];
                 $message;
                 
                 
                 
                 $Selectquery = "select icd10_code from diagnosis where icd10_code = '$ICD10Code'";
                 $queryresults = mysql_query($Selectquery);
                 $icdcheck1 = mysql_fetch_row($queryresults);
                 
                 //check if email exit in doctor tbl
                 if(empty($icdcheck1[0])){
                   $Selectquery = "insert into diagnosis value('$ICD10Code','$Symptom')";
                   $insertquery = mysql_query($Selectquery);
                   $message="Diagnosis $ICD10Code add into the database!";
                 }else{
                  $message=" Diagnosis $ICD10Code exist already in the database!";   
                 }
                 
                ?>
            </div>
                
            <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="panel panel-default col-md-3" style="margin-top: 5px">
                        <div class="panel-body">
                            <h6 align ="center" style="padding-top: 0px;color: #F80000"><?php echo $message; ?></h6>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (isset($_POST['submit_UpMed'])) {
                 $ICD10Code = $_POST['ICD10Code']; 
                 $Symptom = $_POST['Symptoms'];
                 $prevname = $_SESSION['wrongicdcode'];
                 
                 //check if trying to change medicine name
                 if($ICD10Code != $prevname){
                 $Selectquery = "select icd10_code from diagnosis where icd10_code = '$ICD10Code'";
                 $queryresults = mysql_query($Selectquery);
                 $namecheck1 = mysql_fetch_row($queryresults);
                 //if name not used 
                if(empty($namecheck1[0])){
                 $Selectquery = "delete from diagnosis where icd10_code = '$prevname'";
                 $insertquery = mysql_query($Selectquery);
                 
                 $Selectquery = "insert into diagnosis value('$ICD10Code','$Symptom')";
                 $insertquery = mysql_query($Selectquery);
                 
                 $message = "Diagnosis $prevname updated to $ICD10Code sucessful";
                 }
                 else {
                 $message = "This Diagnosis $ICD10Code exist in the database";
                }
                 }
                    else {
                 $Selectquery = "update diagnosis set symptoms = '$Symptom' where icd10_code = '$ICD10Code'";
                 $insertquery = mysql_query($Selectquery);
                     
                 $message = "Diagnosis $ICD10Code updated sucessful";
                     }
                 
                ?>
        </div>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="panel panel-default col-md-3" style="margin-top: 5px">
                        <div class="panel-body">
                            <h6 align ="center" style="padding-top: 0px;color: #F80000"><?php echo $message; ?></h6>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
</div>
    </body>
        
        <?php
           
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
</html>
