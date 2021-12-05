<!-- NOTE
SINGLE PAGE FORM ALONG WITH VALIDATION
NO PHP LEAKS BACK TO THE INDEX 
 -->
<?php
require_once("Includes/session.php");
$nameErr = $phoneErr = $addrErr = $emailErr = $passwordErr = $confpasswordErr = "";
$name = $email = $password = $confpassword = $address = "";
$flag=0;

//CHECK IF A VALID FORM STRING
function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

if(isset($_POST["reg_submit"])) {
        $name = test_input($_POST['name']);
        $email = test_input($_POST['email']);
        $contactNo = test_input($_POST['contactNo']);
        $password = test_input($_POST["inputPassword"]);
        $confpassword = test_input($_POST["confirmPassword"]);
        $address = test_input($_POST["address"]);

        // NAME VALIDATION
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
            $flag=1;
            echo $nameErr;
        } else {
            $name = test_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed"; 
                $flag=1;
                header("Location:index.php?signup=char");
            }
        }

        // EMAIL VALIDATION
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $flag=1;
            } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format"; 
                $flag=1;
                header("Location:index.php?signup=emailFormat&name=$name&email=$email&phone=$contactNo&address=$address");
            }
        }

        // PASSWORD VALIDATION
        if (empty($_POST["inputPassword"])) 
        {
            $passwordErr = "PASSWORD missing";
            $flag=1;
        }
        else 
        {
            $password = $_POST["inputPassword"];
        }
        // CONFIRM PASSWORD
        if (empty($_POST["confirmPassword"])) 
        {
            $confpasswordErr = "missing";
            $flag=1;
        }
        else {
            if($_POST['confirmPassword'] == $password){
                $confpassword = $_POST["confirmPassword"];
            } else {
                $confpasswordErr = "Not same as password!";
                $flag = 1;
                header("Location:index.php?signup=pwdMatch&name=$name&email=$email&phone=$contactNo&address=$address");
            }
        }

        // ADDRESS VALIDATION
        if (empty($_POST["address"])) {
            $addrErr = "Address is required";
            $flag=1;
        } else {
            $address = test_input($_POST["address"]);
        }

        //CONTACT VALIDATION
        if (empty($_POST["contactNo"])) {
            $flag=1;
            $contactNo = "";
            // echo "error here";
        } else {
            $contactNo = test_input($_POST["contactNo"]);
            if(!preg_match("/^d{10}$/", $_POST["contactNo"])){
                $phoneErr="10 digit phone no allowed.";
                echo $_POST['contactNo'];
            }
        }

        // Only if succeed from the validation through out
        echo $flag; 
        if($flag == 0)
        {
            require_once("Includes/config.php");
            $getUser = "SELECT email FROM user WHERE email = ?";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt,$getUser)){
                header("Location:index.php?signup=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt,"s",$email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if ($rowCount > 0){
                    header("Location:index.php?signup=userExist&name=$name&email=$email&phone=$contactNo&address=$address");
                    exit();
                }else{
                    $sql = "INSERT INTO user (`name`,`email`,`phone`,`pass`,`address`) VALUES(?,?,?,?,?)";
                    $stmt = mysqli_stmt_init($con);
                    if (!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location:index.php?signup=sqlerror");
                        exit();
                    }else{
                        $hasPwd = password_hash($password,PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt,"sssss",$name,$email,$contactNo,$hasPwd,$address);
                        mysqli_stmt_execute($stmt);
                        header("Location:index.php?signup=success");
                        exit();
                    }
                }
            }
        }
    }
?>


<form action="signup.php" method="post" class="form-horizontal" role="form" onsubmit="return validateForm()">
    <center>
        <div class="row form-group">
            <div class="col-md-12">
                <?php  if (isset($_GET['name'])){
                    $name = $_GET['name'];
                    echo '<input type="name" class="form-control" name="name" id="name" placeholder="Full Name" value="'.$name.'" required>';
                }else{
                    echo '<input type="name" class="form-control" name="name" id="name" placeholder="Full Name" required>';
                } ?>
                <!-- <label><?php echo $nameErr;?></label> -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?php  if (isset($_GET['email'])){
                    $email = $_GET['email'];
                    echo '<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="'.$email.'" required>';
                }else{
                    echo ' <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>';
                } ?>
                <!-- <label><?php echo $emailErr;?></label> -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Password" required>
                <!-- <label><?php echo $passwordErr;?></label> -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
                <!-- <label><?php echo $confpasswordErr;?></label><label><?php echo $confpasswordErr;?></label> -->
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <?php  if (isset($_GET['phone'])){
                    $phone = $_GET['phone'];
                    echo '<input type="tel" class="form-control" name="contactNo" placeholder="Contact No." value="'.$phone.'" required>';
                }else{
                    echo '<input type="tel" class="form-control" name="contactNo" placeholder="Contact No." required>';
                } ?>
                <!-- <label><?php echo $phoneErr;?></label> -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?php  if (isset($_GET['address'])){
                    $address = $_GET['address'];
                    echo '<input type="address" class="form-control" name="address" placeholder="Address" value="'.$address.'" required>';
                }else{
                    echo '<input type="address" class="form-control" name="address" placeholder="Address" required>';
                } ?>
                <!-- <label><?php echo $addrErr;?></label> -->
            </div>
        </div>
        <div class="form-group">
            <div class="col-1">
                <button name="reg_submit" class="btn btn-primary">Sign Up</button>
            </div>
        </div>
    </center>

    <?php
    if (isset($_GET['signup'])){
        $checkError = $_GET['signup'];
        if ($checkError =="empty"){
            echo "<h3 class='errorMessage'> You did not fill in all fields!</h3>";
            exit();
        }elseif ($checkError =="char"){
            echo "<h3 class='errorMessage'> You used Invalid Characters!</h3>";
            exit();
        }elseif ($checkError =="pwdMatch"){
            echo "<h3 class='errorMessage'> Your password does not match!</h3>";
            exit();
        }elseif ($checkError =="emailFormat"){
            echo "<h3 class='errorMessage'> Invalid email format!</h3>";
            exit();
        }elseif ($checkError =="userExist") {
            echo "<h3 class='errorMessage'> User already taken!</h3>";
            exit();
        }elseif ($checkError =="sqlerror") {
            echo "<h3 class='errorMessage'> Your sql query failed!</h3>";
            exit();
        }elseif ($checkError =="success") {
            echo "<h3 class='successMessage'> Successfully added new user!</h3>";
            exit();
        }
    }
    ?>
</form>


