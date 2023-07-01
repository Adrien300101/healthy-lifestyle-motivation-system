<?php
include_once("../config.php");
include_once("./email/register-operations-send-email.php");

if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['con_password']) && isset($_POST['check'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con_password = $_POST['con_password'];
    $check = $_POST['check'];
    $validation = 0;

    if ($check == "false") {
        $validation = 1;
        $data['checkbox_error'] = "Please accept the privacy policy and terms and conditions before proceeding!";
    } else {
        $data['checkbox_error'] = "";
    }

    if (empty($fname)) {
        $validation = 1;
        $data['fname_error'] = "This field cannot be left empty!";
    } else {
        $data['fname_error'] = "";
    }

    if (empty($lname)) {
        $validation = 1;
        $data['lname_error'] = "This field cannot be left empty!";
    } else {
        $data['lname_error'] = "";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validation = 1;
        $data['email_error'] = "Email is invalid!";
    } else {
        $check_email = DB::queryFirstField("SELECT user_id FROM users WHERE email = %s", $email);
        if ($check_email != null) {
            $data['email_error'] = "This email is already in use. Please sign in";
            $validation = 1;
        } else {
            $data['email_error'] = "";
        }
    }

    if (empty($password)) {
        $validation = 1;
        $data['password_error'] = "This field cannot be left empty!";
    } else {
        $data['password_error'] = "";
    }

    if (empty($con_password)) {
        $validation = 1;
        $data['con_password_error'] = "This field cannot be left empty!";
    } else {
        $data['con_password_error'] = "";
    }

    if ($password != $con_password) {
        $validation = 1;
        $data['con_password_error'] = "Passwords do not match!";
    } else {
        $data['con_password_error'] = "";
    }

    if ($validation == 0) {
        $initial = substr($fname, 0, 1).substr($lname, 0, 1);

        DB::insert('users', [
            'first_name' => $fname,
            'last_name' => $lname,
            'initial' => $initial,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'session_id' => bin2hex(random_bytes(5)),
            'user_status' => 0
        ]);

        $user_id = DB::insertId();

        $exercise_list = DB::query("SELECT exercise_id FROM exercise_list WHERE status = %i", 0);

        foreach ($exercise_list as $exercise) {
            DB::insert('daily_exercise_goal', [
                'exercise_id' => $exercise['exercise_id'],
                'user_id' => $user_id,
                'reps_limit' => 0,
                'exercise_status' => 0,
                'date_created' => date("Y-m-d H:i:s")
            ]);
        }

        $check_email = send_verification_email($email, $fname." ".$lname);
        if ($check_email == false) {
            $email_status = 1;
        } else {
            $email_status = 0;
        }

        $email_fields = [
            'user_id' => $user_id,
            'date_sent' => date("Y-m-d H:i:s"),
            'type' => 0,
            'status' => $email_status
        ];

        DB::insert("email_logs", $email_fields);

        $data['error'] = 0;
        $data['error_msg'] ="Registration was successful! Please verify your email by clicking the link sent to your email";
    } else {
        $data['error'] = 1;
        $data['error_msg'] ="Please ensure all fields are correct!";
    }

} else {
    //incomplete parameter(s)
	$data['error'] = 1;
	$data['error_msg'] = "Oops, something went wrong, please try again later";
}

echo json_encode($data);

?>
