<?php 
    include_once("../config.php");
    include_once("../user/check-user-function.php");

    if (isset($_POST['user_id']) && isset($_POST['fname']) && isset($_POST['lname'])) {

        $user_id = $_POST['user_id'];

        if (check_user($user_id)) {

            $validation = 0;

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];

            if (empty($fname) && empty($lname)) {
                $validation = 1;
                $data['error_msg'] = "Please ensure all fields are correct!";
            } else if (empty($fname)) {
                $validation = 1;
                $data['error_msg'] = "First name field cannot be left empty!";
            } else if (empty($lname)) {
                $validation = 1;
                $data['error_msg'] = "Last name field cannot be left empty!";
            }

            if ($validation == 0) {
                $initial = substr($fname, 0, 1).substr($lname, 0, 1);
                DB::update('users', ['first_name' => $fname, 'last_name' => $lname, "initial" => $initial], "user_id=%i", $user_id);

                $data['error'] = 0;
                $data['error_msg'] = "Personal Info Updated Successfully!";
            } else {
                $data['error'] = 1;
            }
        } else {
            //wrong user
            $data['error'] = 1;
            $data['error_msg'] = "Oops, something went wrong. Please try again later!";
        }
    } else {
        //incomplete parameters
        $data['error'] = 1;
        $data['error_msg'] = "Oops, something went wrong. Please try again later!";
    }

    echo json_encode($data);
?>