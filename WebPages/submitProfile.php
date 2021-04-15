<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    session_start();
    $current_user = $_SESSION["user_id"];
    
    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "n00575sm";
    $database_pass = "Mozzer_2310";
    $database_name = "2020_comp10120_x6";
    
    $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);

    if (!$conn){
        die("connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `users` WHERE `id` = $current_user";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_username = $row["username"];
    $current_email = $row["email"];

    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['newPassword'];
    $oldPassword = $_POST['oldPassword'];

    // function updatedb($newUsername, $newEmail, $newPassword, $oldPassword, $current_username){
    //     global $conn;
        if($oldPassword){
            $stmt = $conn->prepare("SELECT `id`,`email`, `password` FROM `users` WHERE `username`= ?");
            $stmt->bind_param('s', $current_username);
            $stmt->execute();

            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){	
                $user_password = $row['password'];
                $salt = substr($user_password, -4);
                $hash = substr($user_password, 0, -4);

                if (hash('sha512', $oldPassword . $salt) == $hash){
                    if($newUsername){
                        $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");
                        $stmt->bind_param('s', $newUsername);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows >= 1) {
                            while($row = $result->fetch_assoc())
                            {
                                if($newUsername==$row['username']){
                                    echo "Username already exists";
                                }
                            }
                        }
                        else{
                            $stmt = $conn->prepare("UPDATE `users` SET `username`=? WHERE `id`=?");
                            $stmt->bind_param('ss', $newUsername, $current_user);

                            if ($stmt->execute()) {
                                echo "1";
                                header('Location: Profile.php');
                            }
                        }
                    }
                    if($newEmail){
                        $stmt = $conn->prepare("SELECT email FROM users WHERE username=?");
                        $stmt->bind_param('s', $newEmail);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows >= 1) {
                            while($row = $result->fetch_assoc())
                            {
                                if($newEmail==$row['email']){
                                    echo "E-Mail already exists";
                                }
                            }
                        }
                        else{
                            $stmt = $conn->prepare("UPDATE `users` SET `email`=? WHERE `id`=?");
                            $stmt->bind_param('ss', $newEmail, $current_user);

                            if ($stmt->execute()) {
                                echo "2";
                                header('Location: Profile.php');
                            }
                        }
                    }
                    if($newPassword){
                        $salt = str_pad((string) rand(1, 1000), 4, '0', STR_PAD_LEFT);
                        $newPassword = hash('sha512', $newPassword . $salt) . $salt;
                        $stmt = $conn->prepare("UPDATE `users` SET `password`=? WHERE `id`=?");
                        $stmt->bind_param('ss', $newPassword, $current_user);

                        if ($stmt->execute()) {
                            echo "3";
                            header('Location: Profile.php');
                        }
                    }
                }
                else{
                    echo "Old Password is incorrect";
                }
            }
        }
        else{
            echo "Please Enter Old Password";
        }
    // }

    // $username = test_input($newUsername);
    // $password_new = test_input($newPassword);
    // $email = test_input($newEmail);
    // if ($newUsername != "" && strlen($username)<5) {
    //     echo "Username should be at least 5 characters";
    // }
    // else if ($newEmail != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     echo "Invalid email format";
    // }
    // else if ($newPassword != "" && strlen($password_new)<8) {
    //     echo "Password should be at least 8 characters";
    // }
    // else{
    //     updatedb($newUsername, $newEmail, $newPassword, $oldPassword, $current_username);
    // }
?>