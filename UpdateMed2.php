<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'admin') {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<!--
This is the update admin page
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        ?>
        <script src="bootstrap/js/jquery-1.11.2.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#yes").click(function () {
                    $("#Qty").fadeIn("fast");
                });

                $("#no").click(function () {
                    $("#Qty").fadeOut("fast");
                });
            });
        </script>

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
                <div class="col-lg-2"></div>
                <div class="col-md-1"></div>

                <div class="panel panel-default col-md-6" style="border: solid; margin-top: -20px">
                    <div class="panel-body"> 
                        <div class="panel-body">
                            <div class="page-header">
                                <h4 align ="center" style="padding-top: 0px">Update Medicine Form</h4>
                            </div>
                              <?php
                                    $medname =  $_GET['medname'];
                                    
                                    $Selectquery = "select * from medication where name = '$medname'";
                                    $queryresults = mysql_query($Selectquery);
                                    $result = mysql_fetch_row($queryresults);
                            
                            if(!empty($result[0])){
                                $_SESSION['wrongname'] = $result[1];
                              ?>
                            <form action="AddUpdateMedicine.php" class="form-horizontal" method="POST" style="padding-left: 50px;">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Surname" class="" style="margin-bottom:0px">Name</label>
                                            <div>
                                                <input type="text" minlength="2" title="Minimum lenght 2 characters" class="form-control" name="name" placeholder="Enter Medicine Name" value="<?php echo $result[1];?>" required>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                        <label for="Discontinue" class="" style="margin-bottom:0px">Discontinue</label>
                                        <div>
                                            <select name = 'Discontinue' class="form-control">
                                                <?php
                                                if($result[5] == 'N'){
                                               echo "<option value ='N'>No</option>".
                                                "<option value ='Y'>Yes</option>";
                                                }else if($result[5] == 'Y'){
                                                echo "<option value ='Y'>Yes</option>".
                                                    "<option value ='N'>No</option>";
                                                }     
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div> <!--End Form Group-->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="First Name" class="" style="margin-bottom:0px">Description</label>
                                            <div>
                                                <textarea rows= "3" maxlength="500" class="form-control" name='description' autofocus placeholder="Medicine description" required><?php echo $result[2]?></textarea>
                                            </div>
                                        </div>
                                        <p></p>
                                        <div class="col-md-6" align="center">
                                            <label for="First Name" class="" style="margin-bottom:0px" >In House Medicine</label><br>
                                            <?php       
                                            if($result[3] == 'N'){
                                            ?>
                                            No &nbsp;<input type="radio" name="inhouse" id="no" value="N" checked>&nbsp; Yes&nbsp;<input type="radio" name="inhouse" id="yes" value="Y">
                                            <div style="display: none;" id = "Qty">
                                                <input type="number" min="1" class="form-control" max="10000" title="Quanitty from 1 to 10000" name="qty" placeholder="Medicine Quantity" value="1"> 
                                            </div>   
                                              <?php        
                                            }else{
                                             ?>
                                            No &nbsp;<input type="radio" name="inhouse" id="no" value="N">&nbsp; Yes&nbsp;<input type="radio" name="inhouse" id="yes" value="Y"  checked>
                                            <div style="" id = "Qty">
                                                <input type="number" min="1" class="form-control" max="10000" title="Quantity from 1 to 10000" name="qty" placeholder="Medicine Quantity" value="<?php echo $result[4];?>"> 
                                            </div>
                                            <?php
                                            }
                                            ?>
                                                                                                                     
                                        </div>                                                                                  
                                    </div>                                                      
                                </div> <!--End Form Group-->
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <a href ="AddUpdateMedicine.php" ><button type="button" name= "submit_Reg" class="btn btn-default form-control" class="AlignLeft"> << Back </button></a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" name= "submit_UpMed" class="btn btn-default form-control" class="AlignLeft">Update Medicine</button>
                                    </div>
                                </div>
                            </form>
                            
                            
                            
                            <?php
                            }else{
                            ?>
                            <p align="center" style="color: #F80000;font-size: 14px">Medicine <?php echo $medname ?> Not found, Please make you you enter a correct medicine name</p>
                            
                            <div class="row"></div>
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-4">
                                    <form action ="AddUpdateMedicine.php"  method="post">
                                        <button type="submit" name= "submit_Update" class="btn btn-default form-control" class="AlignLeft"> 
                                            << Back 
                                        </button>
                                    </a>
                                     </form>
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
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
    </body>
</html>
