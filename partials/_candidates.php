<?php
$restrict_page();
$candidates = $candidate->getData();
//make it work when candidates return null
if ($candidates !== null && count($candidates) > 0) {
    $keys_with_duplicates = array_keys($candidates[0]);
    //removing the time key from array
    $keys = array_filter($keys_with_duplicates, function ($var) {
        return $var != 'time';
    });
}
//deleting candidate
if (isset($_POST['delete_candidate'])) {
    $candidate_id = $db->con->real_escape_string($_POST['candidate_id']);
    $candidate->deleteData($candidate_id);
    header('Location:' . $_SERVER['REQUEST_URI']);
    exit();
}
//adding candidates to db
if (isset($_POST['add_candidate'])) {
    $candidate_name = $db->con->real_escape_string($_POST['candidate_name']);
    $candidate_position = $db->con->real_escape_string($_POST['candidate_position']);
    //name is short
    if (!isset($candidate_name) || strlen($candidate_name) < 3 || strlen($candidate_position) < 1) {
        header('Location:candidates.php?error=please fill both of the fields');
        exit();
    }
    //all of the inputs are valid
    else {
        $candidate->addData($candidate_name, $candidate_position);
        header('Location:candidates.php');
        exit();
    }
}



// all of the different positions to display as options

$positions = $position->getData();
$positions_arr = array_map(function ($position) {
    return $position['position_name'];
}, $positions);
?>
<div class="container">
    <?php include('./partials/_admin-links.php'); ?>
    <main>
        <!-- INPUT SECTION -->
        <section class='d-flex align-items-center flex-column justify-content-center'>
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
            <h1 class='mb-4'>add new candidates</h1>
            <!-- FORM FOR ADD -->
            <form method='POST' class='d-flex my-4 flex-md-row flex-column justify-content-center align-items-center'>
                <label for="position">candidate name:</label>
                <input type="text" class='form-control mx-3' name="candidate_name" placeholder="candidate name">
                <select name="candidate_position" class='custom-select'>
                    <option value=''>select position</option>
                    <?php foreach ($positions_arr as $position) { ?>
                        <option value="<?php echo $position ?>"><?php echo $position ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class='btn btn-primary' name="add_candidate">Add</button>
            </form>
            <!-- END FORM FOR ADD -->
        </section>
        <!-- END INPUT SECTION -->
        <!-- DISPLAY SECTION -->
        <section class='d-flex align-items-center flex-column justify-content-center p-3 mt-2 border-top border-info'>
            <h1 class='mb-4'>all candidates</h1>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <?php if (isset($keys)) foreach ($keys as $key) : ?>
                            <th scope="col">
                                <h5><?php echo $key ?></h5>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($candidates)) foreach ($candidates as $candidate) :
                    ?>
                        <tr class="bg-primary">
                            <td>
                                <h6><?php echo $candidate['candidate_id']; ?></h6>
                            </td>
                            <td>
                                <h6><?php echo $candidate['candidate_name']; ?></h6>
                            </td>
                            <td>
                                <h6><?php echo $candidate['candidate_position']; ?></h6>
                            </td>
                            <td>
                                <form method='POST'>
                                    <input type="hidden" name="candidate_id" value="<?php echo $candidate['candidate_id'] ?>">
                                    <button class='btn btn-danger p-1' name="delete_candidate">
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