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
                                <?php if(!isset($_POST['submit_Update']) && !isset($_POST['submit_Add'])){ ?>
                                <div class="container" style="padding-left: 10%">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Patient Options</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <form action="AddUpdatePatient.php" method="POST">
                                       <label align ="center">Update Patient</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default form-control" class="AlignLeft">Update Patient</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-6">
                                       <form action="AddUpdatePatient.php" method="POST">
                                            <label align ="center">Add Patient</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default form-control" class="AlignLeft">Add Patient</button>
                                   </div>
                                       </form>
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Clerk/AddPatient.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Clerk/UpdatePatient.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
<!--                If the button to add Patient pressed -->
                <?php
                if(isset($_POST['submit_NewPatient'])){
                 $id = $_POST['ID-number']; 
                 $id = trim($id);
                 $surname = $_POST['Surname'];
                 $firstname = $_POST['FirstName'];
                 $fullname = "$firstname "."$surname";
                 $title = $_POST['Title'];
                 $address = $_POST['Address'];
                 $gender;
                 $DOB= $_POST['DOB'];
                 $CelNo = $_POST['cellno'];
                 $email = $_POST['Email'];
                 $medicalaidno = $_POST['Medical_Aid_No'];
                 $medicalaidname = $_POST['Medical_Aid_Name'];
                 $medicalaidTelno = $_POST['Medical_Aid_telno'];
                 $medicalaidExpdate = $_POST['Medical_Aid_Exdate'];
                 $message;
                 $message2;
                 
                 if($title == 'Mr'){
                   $gender = "M"; 
                 }
                 else
                 {
                  $gender = "F";   
                 }
                 
                 $Selectquery = "select surname from patient where email = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck1 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select surname from patient where patientid = '$id'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck2 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select fullname from log where username = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $fullnamecheck = mysql_fetch_row($queryresults);
                 
                 //check if email exit in patient tbl
                 if(!empty($surnamecheck1[0])){
                $message = "This email exist in the database used by Patient $surnamecheck1[0], please provide a different email";
                 }else if(!empty($surnamecheck2[0])){
                 //check if id exist in  
                $message = "This id exist in the database used by Patient $surnamecheck2[0], please provide a different id";    
                 }else if(!empty($fullnamecheck[0])){
                    //check if email address exit in log in tbl
                $message = "This email exist in the log in database used by $fullnamecheck[0], please provide a different email";   
                 }
                 else{
                     //insert to the database
                  $Selectquery = "insert into patient(patientid,surname,firstname,title,dob,cellno,email,gender,address) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender','$address')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','patient')";
                  $insertquery = mysql_query($Selectquery); 
                  
                  $Selectquery = "insert into account(patientid) value('$id')";
                  $insertquery = mysql_query($Selectquery);
                  
                  //check if enter medicaladi details
                  if(!empty($medicalaidno) && !empty($medicalaidname) && !empty($medicalaidTelno) && !empty($medicalaidExpdate)){
                  
                  $Selectquery = "select medicalaidno from medicalaid where medicalaidno = '$medicalaidno'";
                  $queryresults = mysql_query($Selectquery);
                  $medicalaidnocheck = mysql_fetch_row($queryresults);
                  
                  //if entered medical aid exist
                     if(!empty($medicalaidnocheck[0])){
                  $Selectquery = "update patient set medicalaidno = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $message2 ="Medical Aid details sucessfully inserted";
                     } 
                     else{
                      //if entered medical aid does not exist
                  $Selectquery = "insert into medicalAid(medicalaidno,mame,tel,expiry_date) value('$medicalaidno','$medicalaidname','$medicalaidTelno','$medicalaidExpdate')";
                  $insertquery = mysql_query($Selectquery);      
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $message2 ="Medical Aid details sucessfully inserted";
                     }
                  }
                  else{
                      $message2 = "Medical Aid details Not inserted because some fields was empty please go to update patient to insert medical aid details";
                  }
                  
                  if($insertquery){
                   $message = "Patient $surname Has been added in the database successful";   
                  }else{
                   $message = "Error Occur while inserting, please try again";  
                  }
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
                <?php
                if(!empty($medicalaidno) && !empty($medicalaidname) && !empty($medicalaidTelno) && !empty($medicalaidExpdate)){
                ?>
                </div>
            <div class="row">
            <div class="col-lg-2">
                    </div>
                    <div class="col-md-2">
                    </div>
                <div class="panel panel-default col-md-3" style="margin-top: 5px">
                        <div class="panel-body">
                            <h6 align ="center" style="padding-top: 0px;color: #F80000"><?php echo $message2; ?></h6>
                        </div>
                    </div>
                </div>
            
                <?php
                }
            }
            //if updating patient details
            if (isset($_POST['submit_UpPatient'])) {
                 $id = $_POST['ID-number']; 
                 $id = trim($id);
                 $surname = $_POST['Surname'];
                 $firstname = $_POST['FirstName'];
                 $fullname = "$firstname "."$surname";
                 $title = $_POST['Title'];
                 $gender;
                 $DOB = $_POST['DOB'];
                 $CelNo = $_POST['cellno'];
                 $address = $_POST['Address'];
                 $email = $_POST['Email'];
                 $medicalaidno = $_POST['Medical_Aid_No'];
                 $medicalaidname = $_POST['Medical_Aid_Name'];
                 $medicalaidTelno = $_POST['Medical_Aid_Tel_No'];
                 $medicalaidExpdate = $_POST['Expiring_Date'];
                 $message;  
                 $prevID = $_SESSION['wrongid'];
                 $prevEmail= $_SESSION['wrongemail'];
                 $prevMedAidNo = $_SESSION['wrongmedaidno'];
                 
                 if($title == 'Mr'){
                   $gender = "M"; 
                 }
                 else
                 {
                  $gender = "F";   
                 }
                 
                 $Selectquery = "select patientid from patient where patientid = '$id'";
                 $queryresults = mysql_query($Selectquery);
                 $Idcheck1 = mysql_fetch_row($queryresults);
                
                 
                //check if trying to change id number
               if(empty($Idcheck1[0])){
                   //if changing email too
                    
                 if($email != $prevEmail){
                     //check if email provided is used by another user
                        $Selectquery = "select fullname from log where username = '$email'";
                        $queryresults = mysql_query($Selectquery);
                        $emailcheckfullname = mysql_fetch_row($queryresults);
                     //if not used, we do this
                 if(empty($emailcheckfullname[0])){
                  $Selectquery = "insert into patient(patientid,surname,firstname,title,dob,cellno,email,gender,address) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender','$address')";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','patient')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update consultation set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update account set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update appointment set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "delete from Patient where patientid = '$prevID'";
                  $queryresults = mysql_query($Selectquery);
                  $Selectquery = "delete from log  where username = '$prevEmail'";
                  $queryresults = mysql_query($Selectquery);
                  
                  //check if enter medicaladi details
                  if(!empty($medicalaidno) && !empty($medicalaidname) && !empty($medicalaidTelno) && !empty($medicalaidExpdate)){
                  
                  $Selectquery = "select medicalaidno from medicalaid where MedicalAidNo = '$medicalaidno'";
                  $queryresults = mysql_query($Selectquery);
                  $medicalaidnocheck = mysql_fetch_row($queryresults);
                  
                  //if entered medical aid exist
                  if(!empty($medicalaidnocheck[0])){
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set name = '$medicalaidname' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set tel = '$medicalaidTelno' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set expiry_date = '$medicalaidExpdate' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  } 
                     else{
                      //if entered medical aid does not exist
                  $Selectquery = "insert into medicalAid(medicalAidNo,name,tel,expiry_date) value('$medicalaidno','$medicalaidname','$medicalaidTelno','$medicalaidExpdate')";
                  $insertquery = mysql_query($Selectquery);      
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  }
                  }
                  $message = "Patient $surname has changed his ID and email, others optional info has been deleted, Please use default password to log in to Patient Account";
                }
                 //if email used by another user we display this
                 else{
                   $message = "The email provided $email is in used by $emailcheckfullname, No updated has been Processed";   
                 }
                 }
                 //if email provided did not change to the privious email do this
                 else{
                   
                  $Selectquery = "insert into patient(patientid,surname,firstname,title,dob,cellno,gender) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$gender')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update consultation set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update account set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update appointment set patientid = '$id' where patientid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  
                  //delete to not duplicate unique key email
                  $Selectquery = "delete from patient where patientId = '$prevID'";
                  $deleteresults = mysql_query($Selectquery);
                  
                  $Selectquery = "update patient set email = '$email' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update log set password = '$id' where username = '$email'";
                  $updateresults = mysql_query($Selectquery);
                  
                  $message = "Patient $surname has changed his ID,others optional info has been deleted, Please use default password to log in to Patient Account";
                
                  //check if enter medicaladi details
                  if(!empty($medicalaidno) && !empty($medicalaidname) && !empty($medicalaidTelno) && !empty($medicalaidExpdate)){
                  
                  $Selectquery = "select medicalAidNo from medicalAid where medicalAidNo = '$medicalaidno'";
                  $queryresults = mysql_query($Selectquery);
                  $medicalaidnocheck = mysql_fetch_row($queryresults);
                  
                  //if entered medical aid exist
                  if(!empty($medicalaidnocheck[0])){
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set name = '$medicalaidname' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set tel = '$medicalaidTelno' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set expiry_date = '$medicalaidExpdate' where medicalAidNo = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);   
                  
                  } 
                     else{
                      //if entered medical aid does not exist
                  $Selectquery = "insert into MedicalAid(medicalAidNo,name,tel,expiry_date) value('$medicalaidno','$medicalaidname','$medicalaidTelno','$medicalaidExpdate')";
                  $insertquery = mysql_query($Selectquery);      
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  }
                  }
                  
                  $message = "Patient $surname has changed his ID,others optional info has been deleted, Please use default password to log in to Patient Account";
                
                 }
                 }else {
                    //if did not change id number
                    
                  $Selectquery = "update patient set surname = '$surname' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set firstname = '$firstname' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set title = '$title' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set gender = '$gender'where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set DOB = '$DOB' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set cellno = '$CelNo' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update patient set address = '$address' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update log set fullname = '$fullname' where username = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $message = "Patient $surname Updated successful";
                  
                 
                  //if trying to change email
                  if($email != $prevEmail){
                        $Selectquery = "select fullname from log where username = '$email'";
                        $queryresults = mysql_query($Selectquery);
                        $emailcheckfullname = mysql_fetch_row($queryresults);
                        if(empty($emailcheckfullname[0])){
                          $Selectquery = "update patient set email = '$email' where patientid = '$id'";
                          $insertquery = mysql_query($Selectquery);
                          
                          $Selectquery = "update log set username = '$email' where username = '$prevEmail'";
                          $insertquery = mysql_query($Selectquery);
                          
                        }else{
                         $message .= ", Email already exit, used by $emailcheckfullname[0] ";  
                        }
                  }
                  
                  if(!empty($medicalaidno) && !empty($medicalaidname) && !empty($medicalaidTelno) && !empty($medicalaidExpdate)){
                  
                  $Selectquery = "select medicalaidno from medicalaid where medicalaidno = '$medicalaidno'";
                  $queryresults = mysql_query($Selectquery);
                  $medicalaidnocheck = mysql_fetch_row($queryresults);
                  
                  //if entered medical aid exist
                  if(!empty($medicalaidnocheck[0])){
                  $Selectquery = "update patient set medicalaidno = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set name = '$medicalaidname' where medicalaidno = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set tel = '$medicalaidTelno' where medicalaidno = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update medicalaid set expiry_date = '$medicalaidExpdate' where medicalaidno = '$medicalaidno'";
                  $insertquery = mysql_query($Selectquery);
                     } 
                     else{
                      //if entered medical aid does not exist
                  $Selectquery = "insert into medicalaid(medicalaidno,name,tel,expiry_date) value('$medicalaidno','$medicalaidname','$medicalaidTelno','$medicalaidExpdate')";
                  $insertquery = mysql_query($Selectquery);      
                  $Selectquery = "update patient set medicalAidNo = '$medicalaidno' where patientid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  }
                  }
                  
                  
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
                 unset($_SESSION['wrongid']);
                 unset($_SESSION['wrongemail']);
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
