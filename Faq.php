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
        include './Classes/CssLink.html';
        ?>
    </head> 
    <body>
        <?php
        include "./Pages/Header.php";
        include './Classes/connection.php';
        
        date_default_timezone_set('Africa/Johannesburg');
        ?>


        <div class ="jumbotron" style="margin-top: -15px;padding-top: 25px;">
            <div class="appoint">
                <div class="container"  align="center" style="padding-left: 10%;">
                    <div class="panel panel-default col-lg-9">
                        <div class="panel-body"> 
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Ask Question Form</h4>
                                </div>

                                
                                <?php
                                if(!isset($_POST['submit'])){
                                ?>
                                <form action="Faq.php" class="form-horizontal" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Surname" class="" style="margin-bottom:0px">Surname</label>
                                                <div>
                                                    <input type="text" pattern="[A-Za-z]{3,50}" title="Please start with a capital letter and legth between 3 to 30,No numbers and space allowed" class="form-control" name="surname" placeholder="Enter your Surname" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="First Name" class="" style="margin-bottom:0px">First Name</label>
                                                <div>
                                                    <input type="text" pattern="[A-Za-z /\\]{3,50}" title="Please start with a capital letter and legth between 3 to 30,No numbers allowed" class="form-control" name="firstname" placeholder="Enter your First Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--End Form Group-->


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Gender" class="" style="margin-bottom:0px">Gender</label>
                                                <div>
                                                    <select name = 'gender' class="form-control">
                                                        <option value ='M'>Male</option>
                                                        <option value ='F'>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="DOB" class="" style="margin-bottom:0px">Date of Birth</label>
                                                <div>
                                                    <input type="date" min="<?php echo date("Y-m-d", strtotime("-90 years")); ?>" max="<?php echo date("Y-m-d", strtotime("-5475 days")); ?>" class="form-control" name="DOB" placeholder="Enter your Date of Birth" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div> <!--End Form Group-->


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Cell Number" class="" style="margin-bottom:0px">Cell Number</label>
                                                <div>
                                                    <input type="tel" pattern="[0-9 \\+]{10,15}" class="form-control" name="cellno" placeholder="Enter your Cell Number" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="Email" class="" style="margin-bottom:0px">Email Address</label>
                                                <div>
                                                    <input type="email" name="email" class="form-control" placeholder="Enter your Email" required>
                                                </div>
                                            </div> 
                                        </div>
                                    </div> <!--End Form Group-->

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="source" class="" style="margin-bottom:0px;">How did you hear about us</label>
                                                <div>
                                                    <select name = 'source' class="form-control">
                                                        <option value ='Google'>Google Search</option>
                                                        <option value ='News Letter'>News Letter</option>
                                                        <option value ='Our Website'>Our Website</option>
                                                        <option value ='Someone'>From Someone</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--End Form Group-->

                                    <div class="form-group">
                                        <div class="row">
                                            <div   align="Center">
                                                <label for="Question" class="" style="margin-bottom:0px">Question</label>
                                                <div>
                                                    <textarea rows= "6" maxlength="1000" class="form-control" name='question' autofocus required=""></textarea>
                                                </div>
                                            </div>
                                        </div> <!--End Form Group-->

                                        <br/>
                                        <button type="submit" name = "submit" class="btn btn-default" class="AlignLeft">Submit</button>



                                    </div>
                                </form>
                                <?php
                                }
                                else{
                                  
                                    $surname=$_POST['surname'];
                                    $firstname = $_POST['firstname'];
                                    $gender= $_POST['gender'];
                                    $DOB= $_POST['DOB'];
                                    $CellNo= $_POST['cellno'];
                                    $Email= $_POST['email'];
                                    $source= $_POST['source'];
                                    $Question= $_POST['question'];
                                    
                                    $Selectquery = "insert into faq(Surname,Firstname,Gender,DOB,CellNo,Email,Source,Question)"
                                            . " values('$surname','$firstname','$gender','$DOB','$CellNo','$Email','$source','$Question')";
                                    $queryresults = mysql_query($Selectquery);
                                  
                                ?>                        
                                <div class="form-group">
                                    <div class="row">
                                        <p style="color: #F80000">Your question has been sent, Verified your email within 2 weeks for you feed back.</p> 
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
