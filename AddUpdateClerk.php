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
                                    <h4 align ="center" style="padding-top: 0px">OPTIONS FOR CLERK</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <form action="AddUpdateClerk.php" method="POST">
                                       <label align ="center">Update Clerk</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default" class="AlignLeft">Update Clerk</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-6">
                                       <form action="AddUpdateClerk.php" method="POST">
                                            <label align ="center">Add Clerk</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default" class="AlignLeft">Add Clerk</button>
                               </div>
                                       </form> 
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Classes/AddClerk.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Classes/UpdateClerk.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
<!--                If the button to add Clerk pressed -->
                <?php
                if(isset($_POST['submit_NewClerk'])){
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
                 $message;
                 
                 
                 if($title == 'Mr'){
                   $gender = "M"; 
                 }
                 else
                 {
                  $gender = "F";   
                 }
                 
                 $Selectquery = "select surname from Clerk where email = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck1 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select surname from Clerk where Clerkid = '$id'";
                 $queryresults = mysql_query($Selectquery);
                 $surnamecheck2 = mysql_fetch_row($queryresults);
                 
                 $Selectquery = "select fullname from log where username = '$email'";
                 $queryresults = mysql_query($Selectquery);
                 $fullnamecheck = mysql_fetch_row($queryresults);
                 
                 //check if email exit in Clerk tbl
                 if(!empty($surnamecheck1[0])){
                $message = "This email exist in the database used by Clerk $surnamecheck1[0], please provide a different email";
                 }else if(!empty($surnamecheck2[0])){
                 //check if id exist in  
                $message = "This id exist in the database used by Clerk $surnamecheck2[0], please provide a different id";    
                 }else if(!empty($fullnamecheck[0])){
                    //check if email address exit in log in tbl
                $message = "This email exist in the log in database used by $fullnamecheck[0], please provide a different email";   
                 }
                 else{
                     //insert to the database
                  $Selectquery = "insert into Clerk(Clerkid,surname,firstname,title,dob,cellno,email,gender) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','clerk')";
                  $insertquery = mysql_query($Selectquery); 
                  
                  if($insertquery){
                   $message = "Clerk $surname Has been added in the database successful";   
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
            if (isset($_POST['submit_UpClerk'])) {
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
                 
                 $Selectquery = "select clerkid from clerk where clerkid = '$id'";
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
                  $Selectquery = "insert into clerk(clerkid,surname,firstname,title,dob,cellno,email,gender) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$email','$gender')";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "insert into log(username,fullname,password,rights) value('$email','$fullname','$id','clerk')";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update appointment set clerkid = '$id' where clerkid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update payment set clerkid = '$id' where clerkid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "delete from clerk where clerkId = '$prevID'";
                  $queryresults = mysql_query($Selectquery);
                  $Selectquery = "delete from log  where username = '$prevEmail'";
                  $queryresults = mysql_query($Selectquery);
                  $message = "Clerk $surname has changed his ID, and email others optional info has been deleted, Please use default password to log in to clerk Account";
                }
                 //if email used by another user we display this
                 else{
                   $message = "The email provided $email is in used by $emailcheckfullname, No updated has been Processed";   
                 }
                 }
                 //if email provided did not change to the privious email do this
                 else{
                     //delete to not duplicate unique key email
                 
                  
                  $Selectquery = "insert into clerk(clerkid,surname,firstname,title,dob,cellno,gender) value('$id','$surname','$firstname','$title','$DOB','$CelNo','$gender')";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "update appointment set clerkid = '$id' where clerkid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update payment set clerkid = '$id' where clerkid = '$prevID'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $Selectquery = "delete from clerk where clerkId = '$prevID'";
                  $deleteresults = mysql_query($Selectquery);
                  
                  $Selectquery = "update clerk set email = '$email' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update log set password = '$id' where username = '$email'";
                  $updateresults = mysql_query($Selectquery);
                  $message = "Dr. $surname has changed his ID,others optional info has been deleted, Please use default password to log in to clerk Account";
                }
                 }else {
                    
                    
                  $Selectquery = "update clerk set surname = '$surname' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update clerk set firstname = '$firstname' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update clerk set title = '$title' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update clerk set gender = '$gender'where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update clerk set DOB = '$DOB' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update clerk set cellno = '$CelNo' where clerkid = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  $Selectquery = "update log set fullname = '$fullname' where username = '$id'";
                  $insertquery = mysql_query($Selectquery);
                  
                  $message = "Clerk $surname Updated successful";
                  
                  if($email != $prevEmail){
                        $Selectquery = "select fullname from log where username = '$email'";
                        $queryresults = mysql_query($Selectquery);
                        $emailcheckfullname = mysql_fetch_row($queryresults);
                        if(empty($emailcheckfullname[0])){
                          $Selectquery = "update clerk set email = '$email' where clerkid = '$id'";
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
