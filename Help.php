<?php
if (!isset($_SESSION)) {
session_start();
}

if(isset($_GET['help'])){
if($_GET['help'] == "1005"){
 ?>


<?php
if(!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk'){
    header("Location: signout.php");
}

?>

<!--clerk help-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        include './Classes/CssLink.html';
        ?>
        <script src="bootstrap/js/jquery-1.11.2.min.js"> </script>
        
    </head>
    <?php
    //call navigation 
    include './Clerk/ClerkHeader.php';
    
    //call connection to mysql
    include './Classes/connection.php';
    ?>
    
    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <h2 align="center" style="margin-top: -19px">Clerk Help</h2>
            
            <div class="row">
                  <div class="col-lg-2"></div>
            <div class="container col-lg-9">
                
                <div class="panel-group" id="FIRST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-l" data-toggle="collapse" data-parent="#FIRST">
                                How to add a patient
                                </a>
                            </div>
                            <div id="collapse-l" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Patient in the menu bar</li></ul>
                                  <ul><li>Click Add Patient</li></ul>
                                  <ul><li>Fill the patient details then Click Add patient button</li></ul>
                                  <ul><li>Patients can also be registered in See Patient Request</li></ul>
                                </div> 
                            </div>
                       </div> 
                    </div>
                 </div> 
                
                
                <div class="panel-group" id="SECOND">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-2" data-toggle="collapse" data-parent="#SECOND">
                                How to update a patient
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Patient in the menu bar</li></ul>
                                  <ul><li>Click Update Patient</li></ul>
                                  <ul><li>Enter the ID or passport number of the patient</li></ul>
                                  <ul><li>Update the necessary details</li></ul>
                                  <ul><li>Then Click Update Patient button at the bottom</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                <div class="panel-group" id="THIRD">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-3" data-toggle="collapse" data-parent="#THIRD">
                                How to make payment
                                </a>
                            </div>
                            <div id="collapse-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Process Payment in the menu bar</li></ul>
                                  <ul><li>Enter patient ID, Click Search icon</li></ul>
                                  <ul><li>If the patient is a medical aid patient and he or she will pay using medical aid;
                                          Click Medical Aid then press Submit button</li></ul>
                                 <ul><li>If a patient is using cash; Click Cash Payment then enter the amount to be paid</li></ul>
                                 <ul><li>Then click Submit button</li></ul>
                                </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                <div class="panel-group" id="FORTH">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-4" data-toggle="collapse" data-parent="#FORTH">
                                How to see appointments
                                </a>
                            </div>
                            <div id="collapse-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click See appointments in the menu bar</li></ul>
                                  <ul><li>You can sort appointments by date </li></ul>
                                  <ul><li>Enter the ID or passport number of the Clerk</li></ul>
                                  <ul><li>You can sort appointments by date </li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                <div class="panel-group" id="FIVE">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-5" data-toggle="collapse" data-parent="#FIVE">
                                Reports the clerk can view
                                </a>
                            </div>
                            <div id="collapse-5" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Report in the menu bar</li></ul>
                                  <ul><li>There is Consultation and Payment Report</li></ul>
                                  <ul><li>Both reports  can be sorted by date or search a specific patient  details</li></ul>
                                 <ul><li>When you want consultations and payment  report based on dates, Click Sort by Date button</li></ul>
                                  <ul><li>Enter the date you want to start(From) and the end date(To) Then Submit</li></ul>
                                  <ul><li>At the end of each report there is a print button.</li></ul>
                                  <ul><li>Click Print then it will open a new page, its either you print or cancel</li></ul>
                                 
                                </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                <div class="panel-group" id="SIX">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-6" data-toggle="collapse" data-parent="#SIX">
                                How to change personal details and password
                                </a>
                            </div>
                            <div id="collapse-6" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>In Home page there is My Dashboard, click the button with your full name</li></ul>
                                  <ul><li>Change what needs to be changed and press Submit</li></ul>
                                  <ul><li>Change what needs to be changed and press Submit</li></ul>
                                  <ul><li>Enter the old password, new password and confirm new password then Submit</li></ul>
                                </div> 
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
                



<!--Doctor help-->

<?php
} else if($_GET['help'] == "1007"){

if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
    header("Location: signout.php");
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">     
    </head>
    
    <?php
    //call navigation 
    include './Pages/DoctorHeader.html';
    //call connection to mysql
    include './Classes/connection.php';
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <h2 align="center" style="margin-top: -19px">Doctor Help</h2>
            <div class="row">
                  <div class="col-lg-2"></div>
            <div class="container col-lg-9">
                
                
                <div class="panel-group" id="FIRST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-l" data-toggle="collapse" data-parent="#FIRST">
                                How to change personal details and password
                                </a>
                            </div>
                            <div id="collapse-l" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>In Home page there is My Dashboard, click the button with your full name</li></ul>
                                  <ul><li>Change what needs to be changed and press Submit</li></ul>
                                  <ul><li>To change password, press password (it’s the last button)</li></ul>
                                  <ul><li>Enter the old password, new password and confirm new password then Submit</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div>
                 </div> 
                
                
                <div class="panel-group" id="SECOND">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-2" data-toggle="collapse" data-parent="#SECOND">
                                How to view patient records
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click patient Record in the menu bar</li></ul>
                                  <ul><li>Enter  patient ID number then press Enter in the keyboard</li></ul>
                                </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                <div class="panel-group" id="THIRD">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-3" data-toggle="collapse" data-parent="#THIRD">
                                How to record a consultation
                                </a>
                            </div>
                            <div id="collapse-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Consultation in the menu bar</li></ul>
                                  <ul><li>Enter patient ID number then press Enter in the keyboard</li></ul>
                                  <ul><li>A patient must first payment before consulting</li></ul>
                                  <ul><li>Consultation consist of many steps</li></ul>
                                  <ul><li><b>Step 1 :</b> Pervious diagnosis will be displayed in Last diagnosis
                                      <ul><li>Enter New patient weight</li></ul>
                                      <ul><li>Select the blood pressure</li></ul>
                                      <ul><li>Click Next</li></ul>
                                      </li>
                                  </ul>
                                  <ul><li><b>Step 2 :</b> Write down comments
                                      <ul><li>Add diagnosis(Can be many)</li></ul>
                                      <ul><li>If you added a diagnosis by mistake, it can be removed by Clicking
                                              Remove button next to the diagnosis you wish to remove</li></ul>
                                      <ul><li>Click Next</li></ul>
                                      </li>
                                  </ul>
                                  <ul><li><b>Step 3 :</b> Enter quantity
                                      <ul><li>Enter directive for the medicine</li></ul>
                                      <ul><li>If you added a medicine by mistake, it can be removed by Clicking Remove button next 
                                              to the medicine you wish to remove</li></ul>
                                      <ul><li>Click Next</li></ul>
                                      </li>
                                  </ul>
                                  <ul><li><b>Step 1 :</b> It’s the prescription
                                      <ul><li>At the bottom of the page there are three options Print,
                                              Make sick note and Finish Consultation</li></ul>
                                      <ul><li>To save the Consultation you need to Click Finish ConsultationSelect the blood pressure</li></ul>
                                      </li>
                                  </ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                <div class="panel-group" id="FORTH">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-4" data-toggle="collapse" data-parent="#FORTH">
                                How to view FAQ
                                </a>
                            </div>
                            <div id="collapse-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click FAQ request</li></ul>
                                  <ul><li>Click view question button</li></ul>
                                  <ul><li>The is a textbox provided please write the answer</li></ul>
                                  <ul><li>Then Click Submit Responds</li></ul>
                                 </div> 
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

<?php 
} else if($_GET['help'] == "1009"){

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'admin') {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<!--Administrator Help-->
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
            <h2 align="center" style="margin-top: -19px">Administrator Help</h2>
            
            <div class="row">
                  <div class="col-lg-2"></div>
            <div class="container col-lg-9">
                
                
                <div class="panel-group" id="FIRST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-l" data-toggle="collapse" data-parent="#FIRST">
                                How to add a doctor
                                </a>
                            </div>
                            <div id="collapse-l" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Doctor in the menu bar</li></ul>
                                  <ul><li>Click Add Doctor</li></ul>
                                  <ul><li>Fill the Doctor details then Click Add Doctor button</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div>
                 </div> 
                
                
                <div class="panel-group" id="SECOND">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-2" data-toggle="collapse" data-parent="#SECOND">
                                How to update doctor information
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Doctor in the menu bar</li></ul>
                                  <ul><li>Click Update Doctor</li></ul>
                                  <ul><li>Enter the ID or passport number of the Doctor</li></ul>
                                  <ul><li>Update the necessary details</li></ul>
                                  <ul><li>Then Click Doctor button at the bottom</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                <div class="panel-group" id="THIRD">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-3" data-toggle="collapse" data-parent="#THIRD">
                                How to add a Clerk
                                </a>
                            </div>
                            <div id="collapse-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Clerk in the menu bar</li></ul>
                                  <ul><li>Click Add Clerk</li></ul>
                                  <ul><li>Fill the Clerk details then Click Add Clerk button</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                <div class="panel-group" id="FORTH">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-4" data-toggle="collapse" data-parent="#FORTH">
                                How to update Clerk information
                                </a>
                            </div>
                            <div id="collapse-4" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Clerk in the menu bar</li></ul>
                                  <ul><li>Click Update Clerk</li></ul>
                                  <ul><li>Enter the ID or passport number of the Clerk</li></ul>
                                  <ul><li>Update the necessary details</li></ul>
                                  <ul><li>Then Click Update Clerk button at the bottom</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                <div class="panel-group" id="FIVE">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-5" data-toggle="collapse" data-parent="#FIVE">
                                How to add an Administrator
                                </a>
                            </div>
                            <div id="collapse-5" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Admin in the menu bar</li></ul>
                                  <ul><li>Click Add Admin</li></ul>
                                  <ul><li>Fill the Admin details then Click Add Admin button</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                <div class="panel-group" id="SIX">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-6" data-toggle="collapse" data-parent="#SIX">
                                How to update Administrator information
                                </a>
                            </div>
                            <div id="collapse-6" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add/Update Staff in the menu bar</li></ul>
                                  <ul><li>Click Add/Update Admin in the menu bar</li></ul>
                                  <ul><li>Click Update Admin</li></ul>
                                  <ul><li>Enter the ID or passport number of the Admin</li></ul>
                                <ul><li>Update the necessary details</li></ul> 
                                <ul><li>Then Click Update  Admin button at the bottom</li></ul>
                                </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                
                <div class="panel-group" id="SEVEN">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-7" data-toggle="collapse" data-parent="#SEVEN">
                                How to add medication
                                </a>
                            </div>
                            <div id="collapse-7" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add Medicine in the menu bar</li></ul>
                                  <ul><li>Click Add Medicine button</li></ul>
                                  <ul><li>Fill the medicine details then Click Add Medicine button</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                
                
                <div class="panel-group" id="HEIGHT">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-8" data-toggle="collapse" data-parent="#HEIGHT">
                                When a medicine need to be discontinued (update)
                                </a>
                            </div>
                            <div id="collapse-8" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add Medicine in the menu bar</li></ul>
                                  <ul><li>Click Discontinue Medicine button</li></ul>
                                  <ul><li>In Discontinue the  is a drop down list of  Yes or No, you select one of the two</li></ul>
                                 <ul><li>Then Click Update Medicine</li></ul>
                                </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                
                <div class="panel-group" id="NINE">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-9" data-toggle="collapse" data-parent="#NINE">
                                How to add diagnosis
                                </a>
                            </div>
                            <div id="collapse-9" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add diagnosis in the menu bar</li></ul>
                                  <ul><li>Click Add diagnosis button</li></ul>
                                  <ul><li>Fill the diagnosis details then Click Add diagnosis button</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                
                <div class="panel-group" id="TEN">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-10" data-toggle="collapse" data-parent="#TEN">
                                When a diagnosis need to be update
                                </a>
                            </div>
                            <div id="collapse-10" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Add diagnosis in the menu bar</li></ul>
                                  <ul><li>Click Update Medicine button</li></ul>
                                  <ul><li>Fill the diagnosis details to be updated then Click Add diagnosis button</li></ul>
                                 </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                
                
                <div class="panel-group" id="ELEVEN">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-11" data-toggle="collapse" data-parent="#ELEVEN">
                                How to change personal details and password
                                </a>
                            </div>
                            <div id="collapse-11" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>In Home page there is My Dashboard, click the button with your full name</li></ul>
                                  <ul><li>Change what needs to be changed and press Submit</li></ul>
                                  <ul><li>To change password, press password (it’s the last button)</li></ul>
                                  <ul><li>Enter the old password, new password and confirm new password then Submit</li></ul>
                                 </div> 
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



<?php
}else{
 if(!isset($_SESSION['email']) || $_SESSION['right'] != 'patient'){
    header("Location: signout.php");

}
?>

<!--Patient Help-->
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
    include './Patient/PatientHeader.html';
    
    //call connection to mysql
    include './Classes/connection.php';
    ?>
    
    <body>
        <div class ="jumbotron" style="height: 450px;margin-top: -15px;">
            <h2 align="center" style="margin-top: -19px">Patient Help</h2>
            <div class="row">
                  <div class="col-lg-2"></div>
            <div class="container col-lg-9">
                
                
                <div class="panel-group" id="FIRST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-l" data-toggle="collapse" data-parent="#FIRST">
                                How to change personal details and password
                                </a>
                            </div>
                            <div id="collapse-l" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>In Home page there is My Dashboard, click the button with your full name</li></ul>
                                  <ul><li>Change what needs to be changed and press Submit</li></ul>
                                  <ul><li>To change password, press password (it’s the last button)</li></ul>
                                  <ul><li>Enter the old password, new password and confirm new password then Submit</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div>
                 </div> 
                
                
                <div class="panel-group" id="SECOND">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-2" data-toggle="collapse" data-parent="#SECOND">
                                How to make an appointment
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click Make Appointment in the menu bar</li></ul>
                                  <ul><li>Your Identification number and Full name will show in the text box but they are disabled meaning you cannot change it</li></ul>
                                  <ul><li>When you click the appointment date textbox,  there will be a triangle facing down Click it and a date picker will appear and 
                                          you can select the desired date for the appointment</li></ul>
                                  <ul><li>Then Click the drop down list of time and pick the desired time for the appointment. 
                                          NB: You are advised to check the doctor information link before making an appointment.</li></ul>
                                  <ul><li>Click the submit button and your appointment will be saved.</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div> 
                </div>
                
                
                <div class="panel-group" id="THIRD">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-3" data-toggle="collapse" data-parent="#THIRD">
                                How to see your consultations
                                </a>
                            </div>
                            <div id="collapse-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>Click My consultation in the menu bar</li></ul>
                                 </div> 
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
<?php   
}

}else{
?>

<!--Patient Help-->
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
           <h2 align="center" style="margin-top: -19px">Visitor Help</h2>
           <p></p>
            <div class="row">
                <div class="col-lg-2"></div>
            <div class="container col-lg-9">
                
                
                <div class="panel-group" id="FIRST">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-l" data-toggle="collapse" data-parent="#FIRST">
                                How to be registered as a patient
                                </a>
                            </div>
                            <div id="collapse-l" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>You can send a request, Click Request Registration in the menu bar</li></ul>
                                  <ul><li>Fill in the necessary information the Submit</li></ul>
                                  <ul><li>An email will be sent to confirm your details</li></ul>
                                  <ul><li>And a clerk will call you for more details</li></ul>
                              </div> 
                            </div>
                       </div> 
                    </div>
                 </div> 
                
                
                <div class="panel-group" id="SECOND">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a href="#collapse-2" data-toggle="collapse" data-parent="#SECOND">
                                FAQ (Frequent Asked Question)
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <ul><li>No need to be registered, anyone can ask questions</li></ul>
                                  <ul><li>You don’t have to login</li></ul>
                                  <ul><li>Click FAQ in the menu bar</li></ul>
                                  <ul><li>Fill in necessary information</li></ul>
                                  <ul><li>Submit then you’ll be replied to through email</li></ul>
                              </div> 
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


<?php
} 

