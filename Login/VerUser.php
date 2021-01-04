<?php
if (isset($_POST['submit']))
{
     $idNum = $_POST['idNum'];
     $passkey = $_POST['password'];
     
     SendQueryDB($idNum, $passkey);
}

function SendQueryDB($id, $pass)
{
    $servername = "localhost";
    $username = "root@localhost";
    $password = "";
    $DB = "hotel_system";
    $conn = new mysqli($servername, $username, $password, $DB);
    $result = $conn->query("SELECT `password` FROM `users` WHERE `user_id` = " . intval($id));
   if (!empty($result) && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

        $remotePass = $row['password'];
        
        }
        if(password_verify($pass, $remotePass)){
            echo "Success";
        }
        else{
                echo $id . "</br>";
                echo $pass . "</br>";
        }
    }
    else{
        echo "User ID do not exist";
    }
    
    $conn->close();
}
