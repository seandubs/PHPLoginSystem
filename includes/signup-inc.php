<?php

if(!isset($_POST['submit'])){
    header("Location: ../signup.php");
    exit();
} else {
    include_once './dbconnection.php';
    $first = mysqli_real_escape_string($dbConn, $_POST['first']);
    $last = mysqli_real_escape_string($dbConn, $_POST['last']);
    $email = mysqli_real_escape_string($dbConn, $_POST['email']);
    $uid = mysqli_real_escape_string($dbConn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($dbConn, $_POST['pwd']);

    //Error handlers
    //Check for empty fields
    if(empty($first) || empty($last) || empty($email)|| empty($uid)|| empty($pwd)){
        header("Location: ../signup.php?signup=empty");
        exit();
    } 
    else {
        //Check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
            header("Location: ../signup.php?signup=invalid");
            exit();
        }
        else{
            //Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=email");
                exit();
            }
            else{
                //Check for duplicate uid
                $sql = "SELECT * FROM users WHERE user_ui='$uid'";
                $result = mysqli_query($dbConn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0) {
                    header("Location: ../signup.php?signup=usertaken");
                    exit();
                }
                else {
                    //hashing password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    //insert user into the database
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd');";
                    mysqli_query($dbConn, $sql);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
}