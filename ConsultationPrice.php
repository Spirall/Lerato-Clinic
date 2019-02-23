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
This is the page to update consultation
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
    
    
    if(isset($_POST['submitprice'])){
        $Adult = $_POST['Adult'];
        $Child = $_POST['Child'];
        
        $Selectquery2 = "update consultationprice set price = '$Adult' where type = 'Adult'";
        $queryresults2 = mysql_query($Selectquery2);
        
        $Selectquery2 = "update consultationprice set price = '$Child' where type = 'Child'";
        $queryresults2 = mysql_query($Selectquery2);
    }
    
    
    
    ?>

    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2">         
                </div>
                <div class="col-md-1">    
                </div>
                <div class="panel panel-default col-md-6" style="border: solid; margin-top: -20px">
                    <div class="panel-body"> 

                        <div class="page-header" style="">
                            <h4 align ="center">Update Consultation Price</h4>
                        </div>
                        <br>
                        <form action="ConsultationPrice.php" method="post">
                            <div class="row" style="margin-top: -12px">
                                <div class="col-lg-3"></div>

                                <div class="col-lg-7">
                                    <?php
                                    $Selectquery2 = "select * from consultationprice";
                                    $queryresults2 = mysql_query($Selectquery2);
                                    while ($rows = mysql_fetch_row($queryresults2)) {
                                        ?>

                                        <div class="row">
                                            <div class="col-lg-2"> 
                                                <label style="margin-top: 8px"><?php echo $rows[1] . ": "; ?></label>
                                            </div>
                                            <div class="col-lg-10"> 
                                                <input type="number" class="form-control" min="50" step="10" name="<?php echo $rows[1]; ?>" value="<?php echo $rows[2]; ?>">
                                            </div>
                                        </div>
                                    <p></p>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-lg-2"></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-4"> </div>
                                <div class="col-lg-5"> 
                                    <input type="submit" class="btn btn-default form-control" name="submitprice" value="Submit Price">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        if(isset($_POST['submitprice'])){
        ?>
        <script>
        alert( "Prices Updated Successfully");
        </script>
        
        <?php
        }
        ?>
    </body>
</html>
