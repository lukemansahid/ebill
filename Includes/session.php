<?php
    require_once("config.php");
    session_start();
    $logged = false;
    //checking if anyone(admin/email)is logged in or not
    if(isset($_SESSION['logged'])){
        if ($_SESSION['logged'] == true){
            $logged = true ;
            $email = $_SESSION['email'];
        }
    } else {$logged = false;}

    if($logged != true){
        if (isset($_POST['email']) && isset($_POST['pass'])){
        $user_unsafe=$_POST['email'];
        $pass_unsafe=$_POST['pass'];

        $user = mysqli_real_escape_string($con,$user_unsafe);
        $password = mysqli_real_escape_string($con,$pass_unsafe);

            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = mysqli_stmt_init($con);
            if (mysqli_stmt_prepare($stmt,$sql)){
                mysqli_stmt_bind_param($stmt,"s",$user);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)){
                    $passCheck = password_verify($password,$row['pass']);
                    if($passCheck == true){
                       // session_start();
                        $_SESSION['logged']=true;
                        $_SESSION['user'] = $row['name'];
                        $_SESSION['email'] = $row['email'];

                        if($row['user_role'] ==1){
                            $_SESSION['aid']=$row['id'];
                            $_SESSION['account']="admin";
                            header("Location:admin/index.php");
                        }elseif($row['user_role'] ==2){
                            $_SESSION['uid']=$row['id'];
                            $_SESSION['account']="user";
                            header("Location:user/index.php");
                        }

                    }else{
                        header("Location:index.php?login=wrongpass");
                        exit();
                    }

                }else{
                    header("Location:index.php?login=noUser");
                    exit();
                }

            }

  }


    }
?>