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
    $grateful = $_POST['title'];
    $content = $_POST['content'];
    $mood = $_POST['mood'];

    if(!$date or !$grateful or !$content)
    {
        echo "Please Fill out all the Fields";
    }
    else
    {
        $grateful = str_replace("'","''",$grateful);
        $content = str_replace("'","''",$content);
        $sql = "SELECT * FROM `diaryentries` WHERE `user_id` = '$current_user' AND `date` = '$date'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row)
        {   
            $sql = "UPDATE `mood` SET `mood`='$mood' WHERE `user_id` = '$current_user' AND `date` = '$date'";
            $rs = mysqli_query($conn, $sql);

            if($rs)
            {
                echo "Mood Table Updated";
            }

            $sql = "UPDATE `diaryentries` SET `grateful_text`='$grateful', `diary_text`='$content' WHERE `user_id` = '$current_user' AND `date` = '$date'";

            if (!$conn -> query($sql)) {
                echo("Error description: " . $conn -> error);
              }
        }
        else
        {
            $sql = "INSERT INTO `mood` (`mood_id`, `user_id`, `date`, `mood`) VALUES (NULL, '$current_user', '$date', '$mood');";
            $rs = mysqli_query($conn, $sql);

            if($rs)
            {
                echo "Submitted to Mood Table";
            }

            $sql = "INSERT INTO `diaryentries` (`id`, `user_id`, `date`, `grateful_text`, `diary_text`, `mood_id`) VALUES (NULL, '$current_user', '$date', '$grateful', '$content', (SELECT `mood_id` FROM `mood` WHERE `user_id` = '$current_user' AND `date` = '$date'))";

            if (!$conn -> query($sql)) {
                echo("Error description: " . $conn -> error);
              }
        }
        echo "Submitted";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>