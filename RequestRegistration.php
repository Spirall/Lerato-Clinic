<!DOCTYPE html>
<!--
In this page patient request for registration to the clerk
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        <?php
        include './Classes/CssLink.html';
        include './Classes/connection.php';
        ?>
    </head> 
    <body>
        <?php
        include "./Pages/Header.php";
        date_default_timezone_set('Africa/Johannesburg');
        ?>


        <div class ="jumbotron" style="margin-top: -15px;padding-top: 25px;">
            <div class="appoint">
                <?php
                if(isset($_GET['p'])){
                ?>
                <div class="row" style="margin-bottom: 0px;margin-right: 20px">
                <div class="col-lg-4"></div>
                    <div class="panel panel-default col-lg-5">
                    <div class="panel-body" style="color: #ac2925;font-size: 14px" align="center">
                        To make an appointment, You are required to register first
                    </div>
                </div> 
                    </div>
                <?php
                }
                ?>
                <div class="container"  align="center" style="padding-left: 10%;">
                    <div class="panel panel-default col-lg-9">
                        <div class="panel-body"> 
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Request Online Registration Form</h4>
                                </div>

                                <?php
                                if(!isset($_POST['submit'])){
                                ?>
                            
                                <form action="RequestRegistration.php" class="form-horizontal" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Surname" class="" style="margin-bottom:0px">ID Number</label>
                                                <div>
                                                    <input type="text" pattern="[A-Za-z0-9]{5,15}" title="Please ID should not be less than 5 or greater than 15 characters" class="form-control" name="id" placeholder="Enter your Surname" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="First Name" class="" style="margin-bottom:0px">Surname</label>
                                                <div>
                                                    <input type="text" pattern="[A-Za-z /\\]{3,50}" title="Please start with a capital letter and legth between 3 to 30,No numbers allowed" class="form-control" name="surname" placeholder="Enter your First Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--End Form Group-->


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="First Name" class="" style="margin-bottom:0px">First Name</label>
                                                <div>
                                                    <input type="text" pattern="[A-Za-z /\\]{3,50}" title="Please start with a capital letter and legth between 3 to 30,No numbers allowed" class="form-control" name="firstname" placeholder="Enter your First Name" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="Gender" class="" style="margin-bottom:0px">Title</label>
                                                <div>
                                                    <select name = 'title' class="form-control">
                                                        <option value ='Mr'>Mr</option>
                                                        <option value ='Miss'>Miss</option>
                                                        <option value ='Mrs'>Mrs</option>
                                                    </select>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div> <!--End Form Group-->


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="DOB" class="" style="margin-bottom:0px">Date of Birth</label>
                                                <div>
                                                    <input type="date" min="<?php echo date("Y-m-d", strtotime("-90 years")); ?>" max="<?php echo date("Y-m-d", strtotime("-15 years")); ?>" class="form-control" name="DOB" placeholder="Enter your Date of Birth" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="Cell Number" class="" style="margin-bottom:0px">Cell Number</label>
                                                <div>
                                                    <input type="tel" pattern="[0-9 \\+]{10,15}" class="form-control" name="cellno" placeholder="Enter your Cell Number" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div> <!--End Form Group-->

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Surname" class="" style="margin-bottom:0px">Home Address</label>
                                                <div>
                                                    <textarea rows="5" class="form-control" name="Address" placeholder="Enter Your Address" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="First Name" class="" style="margin-bottom:0px">Email Address</label>
                                                <div>
                                                    <input type="email" title="Please make sure that the Postal Code are number of lenght 4" class="form-control" name="email" placeholder="Enter Postal Code" required>
                                                </div>
                                                <p></p>
                                                <label for="First Name" class="" style="margin-bottom:0px">Postal Code</label>
                                                <div>
                                                    <input type="text" pattern="[0-9]{4}" title="Please make sure that the Postal Code are number of lenght 4" class="form-control" name="Postalcode" placeholder="Enter Postal Code" required>
                                                </div>
                                            </div>
                                        </div> <!--End Form Group-->
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <p></p>
                                    <div class="col-md-6">
                                    <button type="submit" name= "submit" class="btn btn-default form-control">Submit</button>
                                    </div>
                                </form>
                                <?php
                                }
                                else{
                                    
                                    $id = $_POST['id'];
                                    $surname=$_POST['surname'];
                                    $firstname = $_POST['firstname'];
                                    $title= $_POST['title'];
                                    $DOB= $_POST['DOB'];
                                    $CellNo= $_POST['cellno'];
                                    $Email= $_POST['email'];
                                    $Address= $_POST['Address'];
                                    $postalcode = $_POST['Postalcode'];
                                    $gender;
                                    $message;
                                    
                                    
                                    
                                    $Selectquery = "select patientid from patient where patientid = '$id'";
                                    $queryresults = mysql_query($Selectquery);
                                    $idcheck = mysql_fetch_row($queryresults);
                                    
                                    
                                    if(empty($idcheck[0])){
                                        $Selectquery = "select email from patient where email = '$Email'";
                                        $queryresults = mysql_query($Selectquery);
                                        $emailcheck1 = mysql_fetch_row($queryresults);
                                    if(empty($idcheck[0])){    
                                        if($title == 'Mr'){
                                            $gender = "M";
                                        }else{
                                            $gender = "F";
                                        }
                                        
                                      $Selectquery = "insert into requestpatient(patientid,surname,firstname,title, gender,dob,cellno,email,address,postalcode) value('$id','$surname','$firstname','$title','$gender','$DOB','$CellNo','$Email','$Address','$postalcode')";
                                      $queryresults = mysql_query($Selectquery);
                                      if($queryresults){
                                      $message = "Your Request for online registration has been sucessfully sent, you will be contacted within a day";
                                      }else{
                                     $message = "Error Occured, Please try again";      
                                      }}
                                    else{
                                      $message = "The Email address $Email Exist Already";  
                                    }
                                    }else{
                                      $message = "The ID Number $id Exist Already";  
                                    }
                                ?>                        
                                <div class="form-group">
                                    <div class="row">
                                        <p style="color: #F80000"><?php echo $message?></p> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                        </div>
                                    <div class="col-md-6">
                                        <a href="RequestRegistration.php"><button type="submit" name= "back" class="btn btn-default form-control">Back</button>
                                        </a>
                                    </div>            
                                    </div>
                                </div>
                                
                                <?php
                                }
                                ?>
                            
                        </div>
                    </div>
                </div>

            </div> 
        </div>




        <?php
        include "./Pages/Footer.php";
        include 'Classes/JsScript.html';
        ?>

    </body>
</html>
