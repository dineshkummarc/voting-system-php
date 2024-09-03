<?php
//logout handle
if (isset($_POST['logout_submit'])) {
    session_start();
    $_SESSION['logged-in'] = 'no';
    $_SESSION['user_email'] = null;
    header('Location:login.php');
    exit();
}
?>
<nav class="navbar navbar-expand-sm navbar-dark bg-info text-white">
    <a class="navbar-brand" href="#">Votyyy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-xl" href="./register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./login.php">Login</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0 mr-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
        </form>
        <?php
        session_start();
        if ($_SESSION['logged-in'] == 'yes') {
            echo "
            <h5 class='mr-3'>{$_SESSION['user_email']}</h5>
            <form class='form-inline my-2 my-lg-0' method='POST'>
               <button class='btn btn-dark my-2 my-sm-0' type='submit' name='logout_submit'>Logout</button>
            </form>
            ";
        }
        ?>
    </div>
</nav>