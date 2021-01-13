<!doctype html>
<html lang="en">

<head>
    <title>Register</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <?php
    $mode = filter_input(INPUT_GET, 'mode');
    if ($mode == 'password') {
        $oldpassword = filter_input(INPUT_POST, 'oldpassword');
        $newpassword = filter_input(INPUT_POST, 'newpassword');
        $re_password = filter_input(INPUT_POST, 're_password');
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);

        if (!empty($oldpassword) && !empty($newpassword) && !empty($re_password)) {
            $sql = "SELECT `password` FROM `users` WHERE `email` = '" . $_SESSION['email'] . "';";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("could not send the data to the database: " . $conn->error);
                $stmt->bind_result($retrievedData['password']);
                $stmt->store_result();
                $stmt->fetch()
                    or die("Could not retrieve data Or the user does not exists");
                if ($stmt->num_rows == 1) {

                    if (password_verify($oldpassword, $retrievedData['password'])) {
                        if ($newpassword === $re_password) {
                            $newpassword = password_hash($re_password, PASSWORD_BCRYPT);
                            $sql = "UPDATE `users` SET `password`= '" . $newpassword . "' WHERE `email` = '" . $_SESSION['email'] . "';";
                            $stmt->close();
                            UpdatePass($sql);
                        } else {
                            echo "new password and repeated password dont match";
                            header("refresh:3;url=register.php?mode=changepass");
                            die();
                        }
                    } else {
                        die("Incorrect Old Password!");
                        header("refresh:3;url=register.php?mode=changepass");
                    }
                }
            } else {
                die("An error has occured: " . $conn->error);
                header("refresh:5;url=register.php?mode=changepass");
            }
        } else {
            echo "Please fill in all passwords";
            header("refresh:5;url=register.php?mode=changepass");
        }
        $conn->close();
    } else if (isset($_POST['update'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
        $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_STRING);
        $house_number = filter_input(INPUT_POST, 'house_number', FILTER_SANITIZE_NUMBER_INT);
        $telephone_number = filter_input(INPUT_POST, 'telephone_number', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($email) && !empty($last_name) && !empty($first_name) && !empty($country) && !empty($postal_code) && !empty($telephone_number)) {
            if (empty($city)) {
                $city = " ";
            }
            if (empty($street)) {
                $street = " ";
            }
            if (empty($house_number)) {
                $house_number = 0;
            }
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);
            $sql = "UPDATE `users` SET `last_name`= '" . $last_name . "',`first_name`= '" . $first_name . "',`country`= '" . $country . "',`city`= '" . $city . "',`street`= '" . $street . "',`postal_code`= '" . $postal_code . "',`house_number`= " . intval($house_number) . " ,`telephone_number`= " . $telephone_number . ",`email`= '" . $email . "' WHERE `email` = '" . $_SESSION['email'] . "';";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("could not update your account: " . $conn->error);
                echo "Successfully Updated!";
                $_SESSION['email'] = $email;
                $stmt->close();
                $conn->close();
                header("refresh:1;url=myaccount.php?");
                die();
            } else {
                die("An error has occured: " . $conn->error);
            }
        } else {
            echo "Please fill in all the required parameters!";
            header("refresh:3;url=register.php?");
            die();
        }
    } else {
        header("refresh:3;url=register.php?");
        die();
    }

    function UpdatePass($query)
    {
        global $conn;
        $config = parse_ini_file('../config.ini');
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        if ($stmt = $conn->prepare($query)) {
            $stmt->execute()
                or die("could not update your account: " . $conn->error);
            echo "Successfully Updated!";
            $stmt->close();
            $conn->close();
            header("refresh:5;url=myaccount.php?");
            die();
        } else {
            die("An error has occured: " . $conn->error);
        }
    }
    ?>
</body>

</html>