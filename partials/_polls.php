<?php
//page restriction
if(session_status() == PHP_SESSION_NONE){
    sesssion_start();
}
if(!isset($_SESSION['logged-in'])) {
    header('Location:login.php');
    exit();
    echo 'yoo';
}
if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] =='no' ){
    header('Location:login.php');
    exit();
}


// all of the different positions to display as options
$positions = $position->getData();
$positions_arr = array_map(function ($positionn) {
    return $positionn['position_name'];
}, $positions);
if(isset($_POST['show_candidate'])){
    $position = $db->con->real_escape_string($_POST['position']);
    //setting this superglobal var for adding the position to user table
    //for preventing multiple votes for same psoition
    $_SESSION['voted_position'] = $position;
    $candidates = $candidate->getData();
    //this new array is the array that just contains the selected position 
    $new = array_filter($candidates,function($candidate) use($position){
        return ($candidate['candidate_position'] == $position);
    });
    // we should get the names from the new array to display them for radio btns
    $names = array_map(function($candidate){
        return $candidate['candidate_name'];
    },$new);
}
//vote submition
if(isset($_POST['vote_submit'])){
    $voted_for = $db->con->real_escape_string($_POST['person']);
    //increase the vote in candidates table
    $increase_vote_query = "UPDATE `candidate` SET votes = votes+1 WHERE `candidate_name`='$voted_for'";
    $result = $db->con->query($increase_vote_query);
    $email = $_SESSION['user_email'];
    $voted_position = $_SESSION['voted_position'];
    //concatenate the string(voted_for) in users table with the selected position for
    //restricting from multiple votes for the same position
    $concatenate_query = "UPDATE `user` SET voted_for = CONCAT(voted_for,'$voted_position') WHERE `email`='$email'";
    $result2 = $db->con->query($concatenate_query);
        //also upading the session for restricting the mulitiple votes
        $_SESSION['voted_for'] = $_SESSION['voted_for']."$voted_position";
        //return $_SESSION['voted_for'];
        //echo $_SESSION['voted_for'];
        header('Location:polls.php?msg=your vote applied successfuly');
        exit();
}
?>
<div class="container">
<main>
        <!-- INPUT SECTION -->
        <section class='d-flex align-items-center flex-column justify-content-center'>
            <h1 class='mb-4 pr'>select a position</h1>
            <form method='POST' class='d-flex my-4 flex-md-row flex-column justify-content-center align-items-center'>
                <select name="position" class='custom-select'>
                <!-- strpos will return integer if there is some mathced record otherwise it will return boolean -->
                    <?php foreach ($positions_arr as $position) { ?>
                    <?php if( gettype(strpos($_SESSION['voted_for'], $position)) == 'boolean'){?>
                        <option value="<?php echo $position ?>">
                            <?php echo $position?>
                        </option>
                    <?php }?>
                    <?php } ?> 
                </select>
                <button type="submit" class='btn btn-primary p-0' name="show_candidate">show candidates</button>
            </form>
        </section>
        <!-- END INPUT SECTION -->

        <!-- DISPLAY SECTION --> 
        <section class='d-flex align-items-center flex-column justify-content-center
         border-top border-info p-3 mt-2'>
         <?php
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
            <h1 class='mb-4'>available candidates</h1> 
            <form method='POST'>
            <?php if(isset($names)) foreach($names as $name):?>
            <div class="form-check my-1">
               <input class="form-check-input" type="radio" name="person" 
               id="<?php echo $name?>" value="<?php echo $name?>">
               <label class="form-check-label" for="<?php echo $name?>"><?php echo $name?></label>
            </div>
            <?php endforeach;?>
            <button class='btn btn-primary' name="vote_submit">Vote</button>
           </form>
        </section>
        <!-- END DISPLAY SECTION -->
    </main>
</div>