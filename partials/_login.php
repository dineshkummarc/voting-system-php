<?php
if (isset($_POST['login_submit'])) {
    $email = $db->con->real_escape_string($_POST['email']);
    $password = $db->con->real_escape_string($_POST['password']);
    //check if the email is alredy in db
    $check_email_exist_query = "SELECT * FROM `user` WHERE `user`.`email`='$email'";
    $result = $db->con->query($check_email_exist_query);
    $row = mysqli_fetch_row($result);
    //there is email in db and we can keep on
    if ($row) {
        //password is incorrect
        if (!password_verify($password, $row[2])) {
            header('Location:login.php?error=password is incorrect');
            exit();
        }
        //password is correct
        else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            // $row[3] is 'no' by default
            $_SESSION['is_admin'] = $row[3];
            $_SESSION['voted_for'] = $row[4];
            $_SESSION['user_email'] = $row[1];
            $_SESSION['logged-in'] = 'yes';
            header('Location:secret.php');
            exit();
        }
    } else {
        header('Location:login.php?error=please register before trying to login');
        exit();
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
        if (isset($_GET['msg'])) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
               {$_GET['msg']}
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
               </button>
            </div>
        ";
        }
        ?>

        <h1 class="mb-3">Login</h1>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email">
            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="login_submit">Login</button>
    </form>
</div>