<?php
    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "n00575sm";
    $database_pass = "Mozzer_2310";
    $database_name = "2020_comp10120_x6";

    $conn = mysqli_connect($database_host, $database_user, $database_pass, $database_name);

    if (!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }

    echo "<script>console.log('Connected successfully');</script>";

    $sql = "SELECT * FROM users";
    $records = $conn->query($sql);

    $output =   "<table border='2'>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <th>Password</th>";
    
    while ($row = $records->fetch_assoc())
    {
        $output .=  "<tr>
                        <td>$row[id]</td>
                        <td>$row[username]</td>
                        <td>$row[email]</td>
                        <td>$row[password]</td>
                    </tr>";
    }
    $output .=  "</table>";
    echo $output;


?>
