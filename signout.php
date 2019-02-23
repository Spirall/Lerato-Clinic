<?php
if (!isset($_SESSION)) {
    session_start();
}
unset($_SESSION['email']);
unset($_SESSION['right']);
unset($_SESSION['person_id']);
header("Location: index.php");
exit();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

</html>
