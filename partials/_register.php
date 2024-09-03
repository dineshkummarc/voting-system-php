<?php
if (isset($_POST['register_submit'])) {
    $email = $db->con->real_escape_string($_POST['email']);
    $password = $db->con->real_escape_string($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    //check if there is an email with the same email
    $find_query = "SELECT * FROM `user` WHERE `user`.`email`='$email'";
    $result = $db->con->query($find_query);
    $row = mysqli_fetch_row($result);
    if ($row) {
        //duplicated email
        header('Location:register.php?error=there is already a user with this email');
        exit();
    }
    //we can continue to registeration (no duplicate email)
    else {
        //EMAIL IS NOT VALID
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location:register.php?error=please enter a valid email');
            exit();
        }
        //EMAIL IS VALID
        else {
            $insert_query = "INSERT INTO `user` (`email`,`password`) VALUES ('$email','$hashed_password')";
            $result = $db->con->query($insert_query);
            if ($result) {
                //return $result;
                header('Location:login.php?msg=you are registered successfully now you can login');
                exit();
            } else {
                echo 'insertion to db is failed';
            }
        }
    }
}
?>
<div class="container">
    <form class="py-3" method="POST">
        <?php
        if (isset($_GET['error'])) {
            echo "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
               {$_GET['error']}
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
               </button>
            </div>
        ";
        }

        ?>

        <h1 class="mb-3">Register</h1>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email">
            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="register_submit">Register</button>
    </form>
</div>