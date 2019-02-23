<?php
if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['email']) || $_SESSION['right'] != 'patient'){
    header("Location: signout.php");
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        //include script for css
        include './Classes/CssLink.html';
        
        //include for mysql API connection
        include './Classes/connection.php';
        
        //include javascript page for Available hours
        include './Classes/gethourscript.html';
        ?>       
    </head> 
            
    
    <body>
       
       <?php
       //include header design page
      include './Patient/PatientHeader.html';
      date_default_timezone_set('Africa/Johannesburg');
       ?>
        
        
        <div class ="jumbotron" style="margin-top: -15px">
       <?php
       
       $email = $_SESSION['email'];
       
      $Selectquery = "select patientid, surname,firstname from patient where email = '$email'";
      $queryresults = mysql_query($Selectquery);
      $rows = mysql_fetch_row($queryresults); 
      $_SESSION['person_id'] = $rows [0];
       ?>
            
   
    <div class="container"  align="center" style="padding-left: 10%">
    <div class="panel panel-default col-lg-9">
        <div class="panel-body"> 
                       <div class="panel-body">
                           <div class="page-header">
                               <h4 align ="center" style="padding-top: 0px">Appointment Form</h4>
                           </div>
                           
         <form action="Appointment.php" class="form-horizontal" method="POST">
           
         <div class="form-group">
             <div class="row">
                 
                 <div class="col-md-6">
            <label for="ID-Number" class="" style="margin-bottom:0px">ID Number</label>
        <div>
            <?php
                echo "<input type='text' class='form-control' name='ID-number' placeholder='Enter your ID Number' value='$rows[0]' disabled>";
            ?>
            
        </div>
                 </div>
                 <div class="col-md-6">
                     <label for="Surname" class="" style="margin-bottom:0px">Full Name</label>
        <div >
            <?php
           echo "<input type='text' class='form-control' name='Surname' placeholder='Enter your Surname' value='$rows[1] $rows[2]' disabled>";
            ?>
        </div>
             </div> 
                 
             </div>
        </div> <!--End Form Group-->
        
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
            <label for="Appointment_Date" class="" style="margin-bottom:0px">Appointment Date</label>
        <div>
            
            
            <input type="date" onchange="showUser(this.value)" max="<?php echo date("Y-m-d", strtotime("+2 weeks")); ?>" min="<?php echo date("Y-m-d",  strtotime("+1 days")); ?>" class="form-control" name="Appointment_Date" required>
        </div>
                </div>
                <div class="col-md-6">
                <label for="Appointment_Time" class="" style="margin-bottom:0px">Appointment Time</label>
                
          <div id = "txtHint">
            <div>
            <select  name = 'time' class="form-control">
                
               <?php 
                for ($i = 8; $i < 17; $i++) {
                    $descr;
                    
                    
                    if ($i < 12) {
                        $descr = "AM";
                    } else {
                        $descr = "PM";
                    }


                    $fisttime = "$i:00";
                    $secondtime = "$i:30";
                    
                    
                echo "<option value ='$i:00'>$fisttime $descr</option>";
                echo "<option value ='$i:30'>$secondtime $descr</option>";
                
                
                }
               ?>
            </select>
            
            
           </div> 
              <div class="row" style="margin-bottom: -20px">
            <br/>
            <div class="col-md-6">
                <a href ="Appointment.php" ><button type="button" name= "submit_Reg" class="btn btn-default" class="AlignLeft"> Reset </button></a>
            </div>
            <div class="col-md-6">
                <div id="hidd">
                  <button type='submit'  name= 'submit_Reg' class='btn btn-default' class='AlignLeft'>Submit</button>
                </div>    
            </div>
            
           </div>
     </div> 
            </div>
        </div> <!--End Form Group-->
         
        </div>
       </form> 
                           
                           
     </div>
     </div>
    </div>
        </div>
   
          
        
       <?php
        
      //submit appointment for registed patient
      if(isset($_POST['submit_Reg'])){
          
          $id = $_SESSION["person_id"];
          $appointdate = $_POST['Appointment_Date'];
          $appointtime = $_POST['time'];
        
      $Selectquery = "insert into appointment(patientid,time,date,appointmentdate,appointmenttime) values('$id',curtime(),curdate(),'$appointdate','$appointtime')";
      $queryresults = mysql_query($Selectquery);   
          
          
      $Selectquery = "select surname, title from patient where PatientID = '$id'";
      $queryresults = mysql_query($Selectquery);
      $rows = mysql_fetch_row($queryresults); 
          
      $surname = $rows[0];
      $title = $rows[1];
        ?>
            <br><br>
     <div class="container"  align="center" style="padding-left: 10%">
    <div class="panel panel-default col-lg-9">
        <div class="panel-body"> 
     <h5 align ="center" style="padding-top: 0px;color: #F80000"><?php
     $appointdate = date('d-M-Y',  strtotime($appointdate));
     echo "$title $surname, Your appointment has been submited for $appointdate at $appointtime. Thank you for choosing "
             . "Lerato Clinic";
      }   
     ?>
     </h5> 
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
