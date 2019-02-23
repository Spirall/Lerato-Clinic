<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) && $_SESSION['right'] != 'admin'){
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
                                    <h4 align ="center" style="padding-top: 0px">OPTIONS FOR ADMINISTRATOR</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <form action="AddUpdateAdmin.php" method="POST">
                                       <label align ="center">Update Administrator</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default form-control" class="AlignLeft">Update Administrator</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-6">
                                        <form action="AddUpdateAdmin.php" method="POST">
                                            <label align ="center">Add Administrator</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default form-control" class="AlignLeft">Add Administrator</button>
                               </div>
                                       </form> 
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Classes/AddAdmin.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Classes/UpdateAdmin.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
<!--         If the button to add admin pressed -->
                <?php
                if(isset($_POST['submit_NewAdmin'])){
                 $username = $_POST['username']; 
                 $fullname = $_POST['fullname'];
                 $password = $_POST['password'];
                 $confirmpassword = $_POST['confirmpassword'];
                 $message;
                 
                 $Selectquery = "select fullname from log where username = '$username'";
                 $queryresults = mysql_query($Selectquery);
                 $fullnamecheck = mysql_fetch_row($queryresults);
                 
                 //check if email exit in doctor tbl
                 if(empty($fullnamecheck[0])){
                  if($password == $confirmpassword){
                   $Selectquery = "insert into log(username,fullname,password,rights) value('$username','$fullname','$password','admin')";
                   $insertquery = mysql_query($Selectquery);
                      
                   $message = "Administrator $fullname added into the database";  
                  }else{
                    $message = "Passwords do not match, Admin $fullname not added in the database";  
                  }
                  }
                 else{
                    $message = "This username is used by $fullnamecheck[0], PLease provide a different username";
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
            if (isset($_POST['submit_UpAdmin'])) {
                 $username = $_POST['username']; 
                 $fullname = $_POST['fullname'];
                 $pastusername = $_SESSION['wrongusername'];
                 
                  //check if trying to change username
                 if($username != $pastusername){
                 $Selectquery = "select Fullname from log where username = '$username'";
                 $queryresults = mysql_query($Selectquery);
                 $fullnamecheck = mysql_fetch_row($queryresults);
                
                //if username not used
                if(empty($fullnamecheck[0])){
                  
                 $Selectquery = "update log set username = '$username' where username = '$pastusername'";
                 $insertquery = mysql_query($Selectquery);   
                 $Selectquery = "update log set fullname = '$fullname' where username = '$username'";
                 $insertquery = mysql_query($Selectquery);
                    
                 $message = "Administrator $fullname has been updated to username $username";
                }
                else{
                    //if username used
                 $message = "This Username is in used by $fullnamecheck[0], PLease provide another username";   
                 }
                 
                }
                //if not trying to change username
                else{
                 $Selectquery = "update log set fullname = '$fullname' where username = '$username'";
                 $insertquery = mysql_query($Selectquery);
                 $message = "Administrator $fullname has been updated";
                }
                
                
                ?>
            </div>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-2">
                    </div>
                    <div class="panel panel-default col-md-3" style="margin-top: 5px">
                        <div class="panel-body">
                            <h6 align ="center" style="padding-top: 0px"><?php echo $message; ?></h6>
                        </div>
                    </div>
                </div>
                <?php
                unset($_SESSION['wrongusername']);
                
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
