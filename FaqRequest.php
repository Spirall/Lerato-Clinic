<?php
if (!isset($_SESSION)) {
    session_start();
}
 if(!isset($_SESSION['email']) && $_SESSION['right'] != 'doctor'){
    header("Location: index.php"); 
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
        include 'Classes/CssLink.html';
        date_default_timezone_set('Africa/Johannesburg');
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">
     </head>
     
    <body>
        <?php
    //call navigation 
    include 'Pages/DoctorHeader.html';
    //call connection to mysql
    include 'Classes/connection.php';
    
    if(isset($_POST['respond'])){
              $response = $_POST['response'];
              $email = $_POST['email'];
              $questionno = $_POST['questionno'];
              $questionno = wordwrap($questionno, 50,"<br>\n");
              $message;  
              $mail = mail($email, 'Response From Lerato Clinic', $response);
              
             if($mail){
              $message = "Response sent succesfuly to $email";
              $Selectquery = "update faq set `read` = 'Y' where questionno = '$questionno'";
              $queryresults = mysql_query($Selectquery);
             }else{
             
               $message = "could not sent email to $email";  
             }
    
    }
    ?>
        <div class ="jumbotron" style="margin-top: -15px;">
          <?php
            if(!isset($_POST['view'])){
            ?>
            <div class="row" style="  margin-top: -25px;margin-left: 5px;margin-right: 5px;">
                    <div class="panel panel-default col-lg-12">
                    <div class="panel-body">
                               <div class="col-lg-12" style="height: 300px;overflow:scroll">                             
                                <h4 align="center" style="margin-bottom: 1px">FAQ'S REQUEST</h4>
                                <p align="center" style="font-size: 16px;margin-bottom: 1px"></p>
                                
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center"> 
                                <tr align="center">
                                     <td><b>Full name</b></td>
                                     <td><b>Gender</b></td>
                                     <td><b>Age</b></td>
                                     <td><b>Cell Number</b></td>
                                     <td><b>Email</b></td>
                                     <td><b>Source</b></td>
                                     <td><b>View Question</b></td>
                                </tr>
                               <?php
                                $Selectquery = "select surname,firstname,gender,dob,cellno,email,source,questionno from faq where `read` = 'N'";
                                $queryresults = mysql_query($Selectquery);
                                while($result = mysql_fetch_row($queryresults)){
                                ?>
                                <tr align="center">
                                     <td><?php echo "$result[0] $result[1]"; ?></td>
                                     <td><?php echo $result[2]; ?></td>
                                     <td><?php                                      
                                     $age = date("Y-m-d") - $result[3]; 
                                     echo $age; ?></td>
                                     <td><?php echo $result[4]; ?></td>
                                     <td><?php echo $result[5]; ?></td>
                                     <td><?php echo $result[6]; ?></td>
                                     <td>
                                         <form action="FaqRequest.php" method="POST"> 
                                            <input type="hidden" name="consultionid" value="<?php echo $result[7]; ?>">
                                            <input type="submit" name="view" value="View Question">
                                        </form>
                                     </td>
                                </tr>
                                  <?php
                                }
                                  ?>
                               </table>                                
                            </div>
                           </div>
                       </div>
                    </div>
            <?php
            }
            ?>
            
            
            <?php
            if(isset($_POST['view'])){
              include './Doctor/ShowFaqRequest.php';  
            }
            
            if(isset($_POST['respond'])){
              
             ?>
            
            <div class="row" style="  margin-top: -25px;margin-left: 5px;margin-right: 5px;">
                    <div class="panel panel-default col-lg-12">
                    <div class="panel-body">
                        <p align="center" style="margin-bottom: 1px;color: #F80000;font-size: 16px"><?php echo $message;?></p>
                    </div>
                    </div>
            </div>
              
            <?php 
            }
            ?>
            </div>        
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
     </body>
</html>
