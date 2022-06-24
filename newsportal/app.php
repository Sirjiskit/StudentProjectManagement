<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './includes/autoload.php';
$q = filter_input(INPUT_GET, "q", FILTER_SANITIZE_STRING, null);
$model = new User();
if ($q):
    if ($q == "login"):
        $login = $model->Login(filter_input_array(INPUT_POST));
        if ($login["result"] != 1):
            die(json_encode($login));
            exit();
        endif;
        $user = $login["data"];
        Session::init();
        Session::set('loggedIn', true);
        Session::set('userid', $user['userid']);
        Session::set('fullname', $user['fullname']);
        Session::set('phone', $user['phone']);
        Session::set('email', $user['email']);
        Session::set('image', $user['image']);
        die(json_encode(array("result" => 1, "reason" => "logged")));
    endif;
    if ($q == "register"):
        $fullname = filter_input(INPUT_POST, "user-fullname", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "user-email", FILTER_SANITIZE_EMAIL);
        $phone = filter_input(INPUT_POST, "user-phone", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "user-password", FILTER_SANITIZE_STRING);
        if (!$fullname || !$email || !$phone || !$password):
            die(json_encode(array("result" => -1, "reason" => "Required field(s) is/are empty!")));
            exit();
        endif;
        if (!$model->validateEmail($email)):
            die(json_encode(array("result" => -2, "reason" => "Invalid email; please check your email or contact CIT to ge your email address!")));
            exit();
        endif;
        if (!$model->validatePhone($phone)):
            die(json_encode(array("result" => -3, "reason" => "Invalid phone number; please enter a valid phone number!")));
            exit();
        endif;
        if ($model->checkEmail($email)):
            die(json_encode(array("result" => -3, "reason" => "Email address already exists!")));
            exit();
        endif;
        if ($model->checkPhone($phone)):
            die(json_encode(array("result" => -3, "reason" => "Phone number already exists!")));
            exit();
        endif;
        if (!isset($_FILES) || !isset($_FILES["user-file"]["name"])):
            die(json_encode(array("result" => -4, "reason" => "Unsupport image type!")));
            exit();
        endif;
        if (!$model->isAllowed()):
            die(json_encode(array("result" => -5, "reason" => "Not allowed file type!")));
            exit();
        endif;
        if ((float) $_FILES['user-file']['size'] > $model->allowedFileSize) {
            die(json_encode(array("result" => -6, "reason" => "Image exceed the allowed image size 30kb!")));
            exit();
        }
        if (!$model->uploadFiles()):
            die(json_encode(array("result" => -7, "reason" => "Image upload failed!")));
        endif;
        $data = array("email" => $email, "fullname" => $fullname, "password" => Hash::create('sha256', $password, HASH_PASSWORD_KEY), "image" => $model->fileName, "phone" => $phone);
        if (!$model->create($data)):
            unlink(UPLOAD_DR . $model->fileName);
            die(json_encode(array("result" => -8, "reason" => "Unabled to proccess your registration at the moment please try again later!")));
            exit();
        endif;
        Session::init();
        Session::set('loggedIn', true);
        Session::set('userid', $model->lastId());
        Session::set('fullname', $data['fullname']);
        Session::set('phone', $data['phone']);
        Session::set('email', $data['email']);
        Session::set('image', $data['image']);
        die(json_encode(array("result" => 1, "reason" => "Your account successfully created and you have been automatically logged in!")));
    endif;
    if ($q == "upload-profile"):
        if (!isset($_FILES) || !isset($_FILES["user-file"]["name"])):
            die(json_encode(array("result" => -1, "reason" => "Unsupport image type!")));
            exit();
        endif;
        if (!$model->isAllowed()):
            die(json_encode(array("result" => -2, "reason" => "Not allowed file type!")));
            exit();
        endif;
        if ((float) $_FILES['user-file']['size'] > $model->allowedFileSize) {
            die(json_encode(array("result" => -3, "reason" => "Image exceed the allowed image size 30kb!")));
            exit();
        }
        Session::init();
        $userid = Session::get("userid");
        if (!$model->uploadFiles()):
            die(json_encode(array("result" => -3, "reason" => "Image upload failed!")));
        endif;
        $data = array("image" => $model->fileName);
        if (!$model->update($data, $userid)):
            unlink(UPLOAD_DR . $model->fileName);
            die(json_encode(array("result" => -4, "reason" => "Unabled to change profile pic!")));
            exit();
        endif;
        Session::init();
        Session::set('image', $model->fileName);
        die(json_encode(array("result" => 1, "reason" => "Your profile picture succesfully changed!")));
    endif;
    if ($q == "change-password"):
        $oldPassword = filter_input(INPUT_POST, "old-password", FILTER_SANITIZE_STRING);
        $newPassword = filter_input(INPUT_POST, "new-password", FILTER_SANITIZE_STRING);
        $conPassword = filter_input(INPUT_POST, "confirm-password", FILTER_SANITIZE_STRING);
        Session::init();
        $email = Session::get("email");
        if ($newPassword != $conPassword):
            die(json_encode(array("result" => -1, "reason" => "Password not match!")));
            exit();
        endif;
        $user = $model->checkEmail($email);
        if (!$user):
            die(json_encode(array("result" => -2, "reason" => "Unabled to change password please try again later!")));
            exit();
        endif;
        $password = Hash::create('sha256', $oldPassword, HASH_PASSWORD_KEY);
        if ($user["password"] != $password):
            die(json_encode(array("result" => -2, "reason" => "Incorrect current password!")));
            exit();
        endif;
        $userid = Session::get("userid");
        if (!$model->update(array("password" => Hash::create('sha256', $newPassword, HASH_PASSWORD_KEY)), $userid)):
            die(json_encode(array("result" => -3, "reason" => "Failed to change password!")));
            exit();
        endif;
        die(json_encode(array("result" => -3, "reason" => "Password changed!")));
    endif;
endif;
