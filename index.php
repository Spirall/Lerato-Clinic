<?php
session_start();
include './Classes/connection.php';

if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
      
      $Selectquery = "select username,rights,password from log where username = '$email' and password = '$password'";
      $queryresults = mysql_query($Selectquery);
      $rows = mysql_fetch_row($queryresults); 
     
      if(!empty($rows[0])){
        if($password==$rows[2]){
      $_SESSION['email'] = $rows[0];
      $_SESSION['right'] = $rows[1];
      
      
      if($rows[1] == 'doctor'){
          header("Location: DoctorHome.php");
          exit;
      }else if($rows[1] == 'clerk'){
          header("Location: ClerkHome.php");
          exit;
      }else if ($rows[1] == 'admin'){
          header("Location: Admin.php");
          exit;
      }else{
          header("Location: HomePage.php");
          exit;
      }
          }
      }
      
      
      }
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
        include './Classes/CssLink.html';
        ?>
        
    </head> 
    
    <body>
        
      <?php
      include './Pages/Header.php';
      ?>
        
        
        <div class ="jumbotron" style="margin-top: -15px;">
          <div class="row"> 
             <div class="col-md-4">
                <section>
                    <div class="carousel slide" id="screenshot-carousel" data-ride="carousel">
                        <ol class ="carousel-indicators">
                            <li data-target="#screenshot-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#screenshot-carousel" data-slide-to="1"></li>
                            <li data-target="#screenshot-carousel" data-slide-to="2"></li>
                            <li data-target="#screenshot-carousel" data-slide-to="3"></li>
                            <li data-target="#screenshot-carousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                
                                 <img src="Images/leratoclinic.jpg" alt="Text of the Image" style="height:327px;width: 100%">
                            </div>
                            <div class="item">
                               <img src="Images/pic3.jpg" alt="Text of the Image" style="height:327px;width: 100%">   
                            </div>
                            <div class="item">
                                <img src="Images/pic1.jpg" alt="Text of the Image" style="height:327px;width: 100%">
                            </div>
                            <div class="item">
                               <img src="Images/pic2.jpg" alt="Text of the Image" style="height:327px;width: 100%">   
                            </div>
                            <div class="item">
                               <img src="Images/inst1.jpg" alt="Text of the Image" style="height:327px;width: 100%">                                     
                            </div>
                        </div>
                        <a href="#screenshot-carousel" class="left carousel-control" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a href="#screenshot-carousel" class="right carousel-control" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </section>
            </div>
                
                <div class="col-md-5">
                      <div class="panel" style="background-color:#eee;">   
                         
                              <h4 align='center'>Welcome</h4>
                              
                              <span style='font-size:13px'>Lerato Clinic is a limited comprehensive health care with vision of providing 
                                  general practice health care services to students and people staying around Vaal University of Technology 
                                  main campus. Lerato Clinic provide only general practice service, the clinic only provides treatment 
                                  for acute and chronic illnesses, preventive care and health education to patients.
                              </span>
                              <h4 align='center'>Consultation</h4>
                              <span style='font-size:13px'>Lerato Clinic offers health care services to patients of different social classes, 
                                  patients with minimum affordability can pay by tranches.
                              </span>
                              <p></p>
                              <h4 align='center'>Fees</h4>
                              <?php
                              $Selectquery1 = "select price from consultationprice where `type` = 'Adult'";
                              $queryresults1 = mysql_query($Selectquery1);
                              $Adultrows = mysql_fetch_row($queryresults1);
                              
                              $Selectquery2 = "select price from consultationprice where `type` = 'Child'";
                              $queryresults2 = mysql_query($Selectquery2);
                              $Childrows = mysql_fetch_row($queryresults2);
                              ?>
                              <ul style='font-size:13px;padding-left: 20px'><li><b>Children: &nbsp;</b>R<?php echo $Childrows[0];?></li></ul>
                              <ul style='font-size:13px;padding-left: 20px'><li><b>Adult: &nbsp;</b>R<?php echo $Adultrows[0];?></li></ul>
                              
                              <div class="row">
                                  <div class="col-lg-2"></div>
                                  <div class="col-lg-8" style="font-size: 14px" align="center">
                                      <a href="RequestRegistration.php?p=app">
                                      Make an Appointment at Lerato Clinic? 
                                      </a>
                                  </div>
                              </div>   
                              <br>
                      </div>
                    </div>
                
              <div class="col-md-3">
                    <div class="panel panel-default"> 
                       <div class="panel-body">
                           <div class="page-header">
                               <h4 align ="center" style="padding-bottom: 5px;">Login Area</h4>
                           </div>
                           
                           <form role="form" action="index.php" method="POST">
                               <div class="form-group">
                                   <label for="exampleInputEmail1" align ="center" style="padding-bottom: 5px;">Username/Email</label>
                                  <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                      </span>
                               <input type="text" minlength = '4' name="email" class="form-control" placeholder="Enter Email">
                               </div> 
                               </div>
                              
                               <div class="form-group">
                                   <label align ="center" style="padding-bottom: 5px;">Password</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-star"></span>
                                      </span>
                                       <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>    
                               </div>
                               
                               <div>
                                   <?php
                                   if(isset($_POST['submit'])){
                                       ?>
                                   <p align="center" style="font-size:12px;color: #E80000;margin-bottom: -10px;">
                                   <?php
                                   if (empty($rows[0]) || $password!=$rows[2]) {
                                      Echo "Incorrect Username or Password";
                                   }
                                   }
                                   ?>
                                  </p>
                               </div>
                               <hr>
                               <div class="row" style="margin-bottom: 10px;">
                                   <div class="col-md-8" style="padding-top:15px;font-size:12px">
                                       <a href="ForgotPassword.php">Forgot Password?</a>
                                   </div>
                                   <div class="col-md-2">
                               <button type="submit" name="submit" class="btn btn-default" class="AlignLeft">Log In</button>
                                   </div>
                               </div>
                               
                             </form>
                           
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