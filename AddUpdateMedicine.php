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
                                    <h4 align ="center" style="padding-top: 0px">OPTIONS FOR MEDICINE</h4>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <form action="AddUpdateMedicine.php" method="POST">
                                       <label align ="center">Update Medication</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-repeat"></span>
                                      </span>
                                       <button type="submit" name="submit_Update" class="btn btn-default" class="AlignLeft">Update Medication</button>
                                   </div>  
                                        </form>  
                                    </div>
                                    <div class="col-md-6">
                                        <form action="AddUpdateMedicine.php" method="POST">
                                            <label align ="center">Add Medication</label>
                                   <div class="input-group">
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-plus"></span>
                                      </span>
                                       <button type="submit" name="submit_Add" class="btn btn-default" class="AlignLeft">Add Medication</button>
                               </div>
                                       </form> 
                                    </div>
                                </div>
                                </div>
                               <?php
                                }
                                else if(isset($_POST['submit_Add'])){
                                    include './Pages/AddMed.php';
                                }
                                elseif(isset($_POST['submit_Update'])){
                                    include './Pages/UpdateMed.php';
                                }
                                ?>
                              
                            </div>
                   </div>
                
                
<!--                If the button to add medicine pressed -->
                <?php
                if(isset($_POST['submit_NewMed'])){
                 $MedCode = $_POST['medcode']; 
                 $name = $_POST['name'];
                 $Descr = $_POST['description'];
                 $inhouse = $_POST['inhouse'];
                 $qty = 0;
                 $message;
                 
                 
                 if( $inhouse == 'Y'){
                  $qty = $_POST['qty']; 
                 }
                 
                 
                 $Selectquery = "select name from medication where medicinecode = '$MedCode'";
                 $queryresults = mysql_query($Selectquery);
                 $namecheck1 = mysql_fetch_row($queryresults);
                 
                 //check if email exit in doctor tbl
                 if(empty($namecheck1[0])){
                    if($name !=$namecheck1[0]){
                   $Selectquery = "insert into medication(medicinecode,name,description,inhouse,qty) value('$MedCode','$name','$Descr','$inhouse',$qty)";
                   $insertquery = mysql_query($Selectquery);
                   $message="$name added into the database!";
                    }
                    else{
                    $message="$name exist already in the database!";    
                    }
                 }else{
                  $message="Medicine code $MedCode is in used by medicine $namecheck1[0]!";   
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
            }
            if (isset($_POST['submit_UpMed'])) {
                
                 $name = $_POST['name']; 
                 $descr = $_POST['description'];
                 $discontinue = $_POST['Discontinue'];
                 $inhouse = $_POST['inhouse'];
                 $qty = 0;
                 
                 if( $inhouse == 'Y'){
                  $qty = $_POST['qty']; 
                 }
                 
                 $prevname = $_SESSION['wrongname'];
                 
                 //check if trying to change medicine name
                 if($name != $prevname){
                 $Selectquery = "select name from medication where name = '$name'";
                 $queryresults = mysql_query($Selectquery);
                 $namecheck1 = mysql_fetch_row($queryresults);
                 //if name not used 
                if(empty($namecheck1[0])){
                 $Selectquery = "update medication set name = '$name', discontinue = '$discontinue', description = '$descr', inhouse = '$inhouse',qty = $qty where name = '$prevname'";
                 $insertquery = mysql_query($Selectquery);
                 
                 $message = "Medicine $prevname updated to $name sucessful";
                 }
                 else {
                 $message = "This medicine $name exist in the database";
                }
                 }
                    else {
                $Selectquery = "update medication set discontinue = '$discontinue', description = '$descr', inhouse = '$inhouse',qty = $qty where name = '$prevname'";
                $insertquery = mysql_query($Selectquery);
                     
                 $message = "$name updated sucessful";
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
                
                unset($_SESSION['wrongname']);
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
