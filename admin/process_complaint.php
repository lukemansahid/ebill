<?php 
    require_once('../Includes/config.php'); 

    $cid=$_POST['cid'];
    if (isset($_POST["complaint_process"])) {
        if(isset($_POST["cid"])) {
            $query = "UPDATE complaint SET status='PROCESSED' WHERE id={$cid}";
            $result = mysqli_query($con,$query);
            if($result === FALSE) {
                die(mysql_error()); // TODO: better error handling
            }
        }
    }
    header("Location:complaint.php");
 ?>