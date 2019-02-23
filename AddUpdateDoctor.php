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
This is a page to add or update doctor, we got two options here, add or update
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
                                <?php if(!isset($_POST['submit_Update']) && !isset($_POST['submit_Add']) && !isset($_POST['submit_Schedule'])){ ?>
                                <div class="container" style="padding-left: 10%">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">OPTIONS FOR DOCTOR</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <form action="AddUpdateDoctor.php" method="POST">
                                       <label align ="center">Update Doctor</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default" class="AlignLeft">Update Doctor</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-4">
                                       <form action="AddUpdateDoctor.php" method="POST">
                                            <label align ="center">Add Doctor</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default" class="AlignLeft">Add Doctor</button>
                               </div>
                                       </form> 
                                    </div>
                                     <div class="col-md-4">
                                       <form action="AddUpdateDoctor.php" method="POST">
                                            <label align ="center">Add Schedule</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Schedule" class="btn btn-default" class="AlignLeft">Add Schedule</button>
                               </div>
                                       </form> 
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Classes/AddDoctor.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Classes/UpdateDoctor.php';
                                }
                                elseif(isset($_POST['submit_Schedule'])){
                                    include './Classes/AddSchedule.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
 <!-- If the button to add doctor schedule pressed -->
                <?php
                                
                if(isset($_POST['submit_schedule'])){
                 $docid = $_POST['docid'];
                 
                 if(!empty($_POST['Monday'])){
                  $DeleteMonday= FALSE;
                 if($_POST['Monday'] != "Delete"){  
                 $mondaytime = $_POST['Monday'];
                 $starttimemonday = substr($mondaytime,0, strpos($mondaytime, "-"));
                 $endtimemonday = substr($mondaytime, strpos($mondaytime, "-") + 1);
                  }else
                     $DeleteMonday= TRUE; 
                 }
                 
                 if(!empty($_POST['Tuesday'])){
                   $DeleteTuesday= FALSE;
                 if($_POST['Tuesday'] != "Delete"){  
                 $tuesdaytime = $_POST['Tuesday'];
                 $starttimetuesday = substr($tuesdaytime,0, strpos($tuesdaytime, "-"));
                 $endtimetuesday = substr($tuesdaytime, strpos($tuesdaytime, "-") + 1);
                 }else
                     $DeleteTuesday= TRUE;
                 } 
                 
                 if(!empty($_POST['Wednesday'])){
                  $DeleteWednesday= FALSE;
                 if($_POST['Wednesday'] != "Delete"){ 
                 $wednesdaytime = $_POST['Wednesday'];
                 $starttimewedn = substr($wednesdaytime,0, strpos($wednesdaytime, "-"));
                 $endtimewedn = substr($wednesdaytime, strpos($wednesdaytime, "-") + 1);
                }else
                    $DeleteWednesday = TRUE;
                 }
                 
                 if(!empty($_POST['Thursday'])){
                   $DeleteThursday= FALSE;
                 if($_POST['Thursday'] != "Delete"){  
                 $thurdaytime = $_POST['Thursday'];
                 $starttimethursday = substr($thurdaytime,0, strpos($thurdaytime, "-"));
                 $endtimethursday = substr($thurdaytime, strpos($thurdaytime, "-") + 1);
                 }else
                  $DeleteThursday= TRUE;   
                }
                
                 if(!empty($_POST['Friday'])){
                 $DeleteFriday= FALSE;
                 if($_POST['Friday'] != "Delete"){
                 $fridaytime = $_POST['Friday'];
                 $starttimefriday = substr($fridaytime,0, strpos($fridaytime, "-"));
                 $endtimefriday = substr($fridaytime, strpos($fridaytime, "-") + 1);
                 }else
                    $DeleteFriday= TRUE; 
                 }
                 
                 
                 if(!empty($_POST['Saturday'])){
                 $DeleteSaturday= FALSE;
                 if($_POST['Saturday'] != "Delete"){
                 $saturdaytime = $_POST['Saturday'];
                 $starttimesat = substr($saturdaytime,0, strpos($saturdaytime, "-"));
                 $endtimesat = substr($saturdaytime, strpos($saturdaytime, "-") + 1);
                 }else
                 $DeleteSaturday= TRUE;    
                 }
                 if(!empty($_POST['Sunday'])){
                 $DeleteSunday= FALSE;
                 if($_POST['Sunday'] != "Delete"){    
                 $sundaytime = $_POST['Sunday'];
                 $starttimesunday = substr($sundaytime,0, strpos($sundaytime, "-"));
                 $endtimesunday = substr($sundaytime, strpos($sundaytime, "-") + 1);
                 }else 
                 $DeleteSunday= TRUE;    
                 }
                 $message;
                 
                 
                 //check if monday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Monday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $mondaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Monday'])){
                 if($DeleteMonday == FALSE){    
                 if(empty($mondaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Monday','$starttimemonday','$endtimemonday','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimemonday', endtime = '$endtimemonday' where days = 'Monday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                 }else{
                 $Selectquery = "delete from schedule where days = 'Monday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                 }
                 
                 //check if tuesday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Tuesday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $tuesdaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Tuesday'])){
                  if($DeleteTuesday == FALSE){
                  if(empty($tuesdaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Tuesday','$starttimetuesday','$endtimetuesday','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimetuesday', endtime = '$endtimetuesday' where days = 'Tuesday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                  }else{
                   $Selectquery = "delete from schedule where days = 'Tuesday' and doctorid = '$docid'";
                   $queryresults = mysql_query($Selectquery);   
                  }
                 }
                 
                 //check if wednesday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Wednesday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $wednesdaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Wednesday'])){
                  if($DeleteWednesday == FALSE){
                  if(empty($wednesdaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Wednesday','$starttimewedn','$endtimewedn','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimewedn', endtime = '$endtimewedn' where days = 'Wednesday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                     }else{
                       $Selectquery = "delete from schedule where days = 'Wednesday' and doctorid = '$docid'";
                       $queryresults = mysql_query($Selectquery);  
                     }
                 }
                 
                 //check if thursday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Thursday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $thursdaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Thursday'])){
                     if($DeleteThursday == FALSE){
                  if(empty($thursdaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Thursday','$starttimethursday','$endtimethursday','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimethursday', endtime = '$endtimethursday' where days = 'Thursday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 } 
                     }else{
                      $Selectquery = "delete from schedule where days = 'Thursday' and doctorid = '$docid'";
                      $queryresults = mysql_query($Selectquery);    
                     }
                 }
                 
                 //check if friday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Friday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $fridaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Friday'])){
                  if($DeleteFriday == FALSE){
                  if(empty($fridaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Friday','$starttimefriday','$endtimefriday','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimefriday', endtime = '$endtimefriday' where days = 'Friday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                  } 
                 }else{
                  $Selectquery = "delete from schedule where days = 'Friday' and doctorid = '$docid'";
                  $queryresults = mysql_query($Selectquery);   
                 }  
                 }
                 
                 //check if saturday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Saturday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $saturdaycheck1 = mysql_fetch_row($queryresults);
                    
                 if(!empty($_POST['Saturday'])){
                     if($DeleteSaturday == FALSE){
                  if(empty($saturdaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Saturday','$starttimesat','$endtimesat','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimesat', endtime = '$endtimesat' where days = 'Saturday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                     }else{
                       $Selectquery = "delete from schedule where days = 'Saturday' and doctorid = '$docid'";
                       $queryresults = mysql_query($Selectquery);  
                     }
                 }
                 
                 //check if sunday exist to update
                 $Selectquery = "select starttime from schedule where days = 'Sunday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);
                 $sundaycheck1 = mysql_fetch_row($queryresults);
                 
                 if(!empty($_POST['Sunday'])){
                     if($DeleteSunday == FALSE){
                  if(empty($sundaycheck1)){
                 $Selectquery = "insert into schedule(days,starttime,endtime,doctorid) value('Sunday','$starttimesunday','$endtimesunday','$docid')";
                 $queryresults = mysql_query($Selectquery);   
                 }else{
                 $Selectquery = "update schedule set starttime = '$starttimesunday', endtime = '$endtimesunday' where days = 'Sunday' and doctorid = '$docid'";
                 $queryresults = mysql_query($Selectquery);   
                 }
                     }else{
                     $Selectquery = "delete from schedule where days = 'Sunday' and doctorid = '$docid'";
                     $queryresults = mysql_query($Selectquery);    
                     }
                 }
                 
                 if(empty($_POST['Monday']) && empty($_POST['Tuesday']) && empty($_POST['Wednesday']) && empty($_POST['Thursday']) && empty($_POST['Friday']) && empty($_POST['Saturday']) && empty($_POST['Sunday'])){
                 $message = "Schedule for doctor id $docid Not updated, Please make sure to select a value for schedule";    
                 }else{
                 $message = "Schedule for doctor id $docid updated";    
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

            <!-- If the button to add doctor pressed -->            
                <?php
            }
               
                if(isset($_POST['submit_NewDoc'])){
                 $id = $_POST['ID-number']; 
                 $id = trim($id);
                 $surname = $_POST['Surname'];
                 $firstname = $_POST['FirstName'];
                 $fullname = "$firstname "."$surname";
                 $title = $_POST['Title'];
                 $gender;
                 $DOB= $_POST['DOB'];
                 $CelNo = $_POST['cellno'];
                 $email = $_POST['Email'];
                 $docdesc = $_POST['Description'];
                 $message;
                 
                 if($title == 'Mr'){
                   $gender = "M"; 
                 }
                 else
                 {
                  $gender = "F";   
                 }
                 
                 $Selectquery = "select surname from doctor where email = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck1 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select surname from doctor where doctorid = '$id'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck2 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select fullname from log where username = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $fullnamecheck = mysql_fetch_row($queryresults);
                 
                 //check if email exit in doctor tbl
                 if(!empty($surnamecheck1[0])){
                $message = "This email exist in the database used by Dr. $surnamecheck1[0], please provide a different email";
                 }else if(!empty($surnamecheck2[0])){
                 //check if id exist in  
                $message = "This id exist in the database used by Dr. $surnamecheck2[0], please provide a different id";    
                 }else if(!empty($fullnamecheck[0])){
                    //check if email address exit in log in tbl
                $message = "This email exist in the log in database used by $fullnamecheck[0], please provide a different email";   
                 }
                 else{
                     //insert to the database
                  $Selectquery = "insert into doctor(doctorid,surname,firstname,title,dob,cellno,email,gender,doctor_descr) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender','$docdesc')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','doctor')";
                  $insertquery = mysql_query($Selectquery); 
                  
                  if($insertquery){
                   $message = "Dr. $surname Has been added in the database successful";   
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
                            <h6 align ="center" style="padding-top: 0px"><?php echo $message; ?></h6>
                        </div>
                    </div>
                </div>
            
                <?php
            }
            if (isset($_POST['submit_UpDoc'])) {
                 $id = $_POST['ID-number']; 
                 $id = trim($id);
                 $surname = $_POST['Surname'];
                 $firstname = $_POST['FirstName'];
                 $fullname = "$firstname "."$surname";
                 $title = $_POST['Title'];
                 $gender;
                 $DOB= $_POST['DOB'];
                 $CelNo = $_POST['cellno'];
                 $email = $_POST['Email'];
                 $docdesc = $_POST['Description'];
                 $message;  
                 $prevID = $_SESSION['wrongid'];
                 $prevEmail= $_SESSION['wrongemail'];
                 
                 
                 if($title == 'Mr'){
                   $gender = "M"; 
                 }
                 else
                 {
                  $gender = "F";   
                 }
                 
                 $Selectquery = "select doctorid from doctor where doctorid = '$id'";
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
                  $Selectquery = "insert into doctor(doctorid,surname,firstname,title,dob,cellno,email,gender,doctor_descr) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender','$docdesc')";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','doctor')";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update consultation set doctorid = '$id' where doctorid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "delete from doctor where doctorId = '$prevID'";
                  $queryresults = mysql_query($Selectquery);
                  $Selectquery = "delete from log  where username = '$prevEmail'";
                  $queryresults = mysql_query($Selectquery);
                  $message = "Dr. $surname has changed his ID, and email others optional info has been deleted, Please use default password to log in to doctor Account";
                }
                 //if email used by another user we display this
                 else{
                   $message = "The email provided $email is in used by $emailcheckfullname, No updated has been Processed";   
                 }
                 }
                 //if email provided did not change to the privious email do this
                 else{
                  $Selectquery = "insert into doctor(doctorid,surname,firstname,title,dob,cellno,gender,doctor_descr) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$gender','$docdesc')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update consultation set doctorid = '$id' where doctorid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);

                     //delete to not duplicate unique key email
                  $Selectquery = "delete from doctor where doctorId = '$prevID'";
                  $deleteresults = mysql_query($Selectquery); 
                  
                  $Selectquery = "update doctor set email = '$email' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update log set password = '$id' where username = '$email'";
                  $updateresults = mysql_query($Selectquery);
                  $message = "Dr. $surname has changed his ID,others optional info has been deleted, Please use default password to log in to doctor Account";
                }
                 }else {
                    
                    
                  $Selectquery = "update doctor set surname = '$surname' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update doctor set firstname = '$firstname' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update doctor set title = '$title' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update doctor set gender = '$gender'where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update doctor set DOB = '$DOB' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update doctor set cellno = '$CelNo' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update doctor set doctor_descr = '$docdesc' where doctorid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update log set fullname = '$fullname' where username = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $message = "Dr. $surname Updated successful";
                  
                 
                  if($email != $prevEmail){
                        $Selectquery = "select fullname from log where username = '$email'";
                        $queryresults = mysql_query($Selectquery);
                        $emailcheckfullname = mysql_fetch_row($queryresults);
                        if(empty($emailcheckfullname[0])){
                          $Selectquery = "update doctor set email = '$email' where doctorid = '$id'";
                          $insertquery = mysql_query($Selectquery);
                          
                          $Selectquery = "update log set username = '$email' where username = '$prevEmail'";
                          $insertquery = mysql_query($Selectquery);
                          
                        }else{
                         $message .= ", Email already exit, used by $emailcheckfullname ";  
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
                            <h6 align ="center" style="padding-top: 0px"><?php echo $message; ?></h6>
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
