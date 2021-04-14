<?php
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

    $date = $_POST['date'];
    $grateful = $_POST['phrases'];
    $content = $_POST['content'];
    $mood = $_POST['mood'];

    if(!$date or !$grateful or !$content)
    {
        echo "Please Fill out all the Fields";
    }
    else
    {
        $sql = "SELECT * FROM `diaryentries` WHERE `user_id` = '$current_user' AND `date` = '$date'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row)
        {   
            $stmt = $conn->prepare("UPDATE `mood` SET `mood`= ? WHERE `user_id` = ? AND `date` = ?");
            $stmt->bind_param('sss', $mood, $current_user, $date);
            if($stmt->execute())
            {
                echo "Mood Table Updated";
            }

            $stmt = $conn->prepare("UPDATE `diaryentries` SET `grateful_text`= ?, `diary_text`= ? WHERE `user_id` = ? AND `date` = ?");
            $stmt->bind_param('ssss', $grateful, $content, $current_user, $date);

            if($stmt->execute())
            {
                echo "diary table updated";
            }
            else{
                echo("Error description: " . $stmt -> error);
              }
        }
        else
        {
            $stmt = $conn->prepare("INSERT INTO `mood` (`mood_id`, `user_id`, `date`, `mood`) VALUES (NULL, ?, ?, ?)");
            $stmt->bind_param('sss', $current_user, $date, $mood);

            if($stmt->execute())
            {
                echo "Submitted to mood table";
            }

            $stmt = $conn->prepare("INSERT INTO `diaryentries` (`id`, `user_id`, `date`, `grateful_text`, `diary_text`, `mood_id`) VALUES (NULL, ?, ?, ?, ?, (SELECT `mood_id` FROM `mood` WHERE `user_id` = ? AND `date` = ?))");
            $stmt->bind_param('ssssss', $current_user, $date, $grateful, $content, $current_user, $date);

            if($stmt->execute())
            {
                echo "diary table updated";
            }
            else{
                echo("Error description: " . $stmt -> error);
              }
        }
        echo "Submitted";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>