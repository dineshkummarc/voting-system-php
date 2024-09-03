<?php
$restrict_page();
$positions = $position->getData();
//make it work when positions return null
if ($positions !== null && count($positions) > 0) {
    $keys_with_duplicates = array_keys($positions[0]);
    //removing the time key from array
    $keys = array_filter($keys_with_duplicates, function ($var) {
        return $var != 'time';
    });
}


// deleting positions with delete button
if (isset($_POST['delete_position'])) {
    $position_id = $db->con->real_escape_string($_POST['position_id']);
    $position->deleteData($position_id);
    header('Location:' . $_SERVER['REQUEST_URI']);
    exit();
}



//adding data to positions table
if (isset($_POST['add_position'])) {
    $position_name = $db->con->real_escape_string($_POST['position_name']);
    //position name input is invalid(short)
    if (strlen($position_name) < 3) {
        header('Location:' . $_SERVER['REQUEST_URI'] . '?error=make sure your position contains at least 3 characters');
        exit();
    }
    //position name is valid (long enough)
    else {
        $position->addData($position_name);
        header('Location:' . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>
<div class="container">
    <?php include('./partials/_admin-links.php'); ?>
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
    <main>
        <!-- INPUT SECTION -->
        <section class='d-flex align-items-center flex-column justify-content-center'>
            <h1 class='mb-4'>add new positions</h1>
            <form method='POST' class='form-inline my-4'>
                <label for="position">position name</label>
                <input type="text" class='form-control mx-3' name="position_name" placeholder="position">
                <button type="submit" class='btn btn-primary' name="add_position">Add</button>
            </form>
        </section>
        <!-- END INPUT SECTION -->

        <!-- DISPLAY SECTION -->
        <section class='d-flex align-items-center flex-column justify-content-center border-top border-info p-3 mt-2'>
            <h1 class='mb-4'>available Positions</h1>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <?php
                        if (isset($keys)) foreach ($keys as $key) :

                        ?>
                            <th scope="col">
                                <h5><?php echo "$key" ?></h5>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($positions)) foreach ($positions as $position) :
                    ?>
                        <tr class="bg-primary">
                            <td>
                                <h6><?php echo $position['position_id'] ?></h6>
                            </td>
                            <td>
                                <h6><?php echo $position['position_name'] ?></h6>
                            </td>
                            <td>
                                <form method='POST'>
                                    <input type="hidden" value="<?php echo $position['position_id'] ?>" name="position_id">
                                    <button class='btn btn-danger p-1' name="delete_position">
                                        <h5>Delete</h5>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <!-- END DISPLAY SECTION -->

    </main>
</div>