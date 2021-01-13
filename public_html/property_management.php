<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Admin Panel | Properties</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class="formulier">
        <?php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE ||  $_SESSION['authorisation'] !== 1) {
            echo "Your account does not have the authorisation to view this page.";
            header("refresh:1;url=index.php?");
                            die();
        }
        error_reporting(E_ERROR | E_PARSE);
        $mode = filter_input(INPUT_GET, 'mode');
        $id = filter_input(INPUT_GET, 'id');
        $submit_new = $_POST['submit_new'];
        $submit_edit = $_POST['submit_edit'];
        if (isset($submit_new) && !empty($_FILES['headerimage'])) {
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $capacity = filter_input(INPUT_POST, 'capacity', FILTER_SANITIZE_NUMBER_FLOAT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $price_night = filter_input(INPUT_POST, 'price_night', FILTER_SANITIZE_NUMBER_FLOAT);
            $price_week = filter_input(INPUT_POST, 'price_week', FILTER_SANITIZE_NUMBER_FLOAT);
            $price_weekend = filter_input(INPUT_POST, 'price_weekend', FILTER_SANITIZE_NUMBER_FLOAT);
            $discount = filter_input(INPUT_POST, 'discount', FILTER_SANITIZE_NUMBER_FLOAT);

            if (!empty($name) && !empty($capacity)) {
                $sql = "INSERT INTO `apartments` (`name`, `capacity`, `description`, `price_night`, `price_week`, `price_weekend`, `discount`) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sdsdddd", $name, $capacity, $description, $price_night, $price_week, $price_weekend, $discount);
                    $stmt->execute()
                        or die("could not send the data to the database: " . $conn->error);
                    $last_id = $conn->insert_id;
                    $stmt->close();
                    $conn->close();
                    if (isset($submit_edit)) {
                        echo "Success! You will be redirected shortly back to the admin panel";
                        header("refresh:3;url=admin.php");
                        die();
                    }
                    if (isset($submit_new)) {
                        echo "New entry successfully added to the database";
                        echo '<br>';
                    }
                } else {
                    echo "A problem has happened: " . $conn->error;
                }
            } else {
                echo "Please fill in everything";
            }
        }
        if (isset($submit_edit)) {
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $capacity = filter_input(INPUT_POST, 'capacity', FILTER_SANITIZE_NUMBER_FLOAT);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            //delete this later
            if (empty($description)) {
                $description = ' ';
            }
            $price_night = filter_input(INPUT_POST, 'price_night', FILTER_SANITIZE_NUMBER_FLOAT);
            $price_week = filter_input(INPUT_POST, 'price_week', FILTER_SANITIZE_NUMBER_FLOAT);
            $price_weekend = filter_input(INPUT_POST, 'price_weekend', FILTER_SANITIZE_NUMBER_FLOAT);
            $discount = filter_input(INPUT_POST, 'discount', FILTER_SANITIZE_NUMBER_FLOAT);

            if (!empty($name) && !empty($capacity)) {
                $id = $_SESSION['edit_id'];
                unset($_SESSION['edit_id']);
                $sql = "UPDATE `apartments` SET name = '" . $name . "' , capacity = " . $capacity . " , description = '" . $description . "' , price_night = " . $price_night . " , price_week = " . $price_week . " , price_weekend = " . $price_weekend . " , discount = " . $discount . " WHERE apartment_id = " . $id . " ;";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->execute()
                        or die("could not send the data to the database: " . $conn->error);
                    $stmt->close();
                    $conn->close();
                    echo "Success! You will be redirected shortly back to the admin panel";
                    header("refresh:2;url=admin.php");
                    die();
                } else {
                    echo "A problem has happened: " . $conn->error;
                }
            } else {
                echo "Please fill in everything";
            }
        }
        if (isset($submit_new) && !empty($_FILES['headerimage'])) {
            $file_name = $_FILES['headerimage']['name'];
            $file_size = $_FILES['headerimage']['size'];
            $file_tmp = $_FILES['headerimage']['tmp_name'];
            $file_type = $_FILES['headerimage']['type'];
            $success_header = 0;

            if ($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif') {
                if ($file_size > 5242880) {
                    die("Please upload a smaller file. Max size is 5MB");
                } else {
                    $file_path = 'images/apartments/' . $last_id;
                    if (!file_exists($file_path)) {
                        mkdir($file_path, 0777, true);
                    }
                    $file_path .= '/';
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $file_name = 'header_image.' . $ext;
                    move_uploaded_file($file_tmp, $file_path . $file_name);
                    echo "Header image successfully uploaded";
                    echo '<br>';
                    $success_header = 1;
                }
            }
            if (!empty(array_filter($_FILES['images']['name']))) {
                $file_number = 0;
                $success = 0;
                foreach ($_FILES['images']['tmp_name'] as $key => $value) {
                    $file_name = $_FILES['images']['name'][$key];
                    $file_size = $_FILES['images']['size'][$key];
                    $file_tmp = $_FILES['images']['tmp_name'][$key];
                    $file_type = $_FILES['images']['type'][$key];

                    if ($file_type == 'image/jpeg' || $file_type == 'image/jpg' || $file_type == 'image/png' || $file_type == 'image/gif') {
                        if ($file_size > 5242880) {
                            die("Please upload a smaller file. Max size is 5MB");
                        } else {
                            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            $file_name = 'image_' . $file_number . "." . $ext;
                            move_uploaded_file($file_tmp, $file_path . $file_name);
                            $success = 1;
                            $success_header = 0;
                            $file_number++;
                        }
                    } else {
                        echo "File type not allowed";
                    }
                }
                if ($success == 1) {
                    echo $file_number . " additional image(s) successfully uploaded";
                    echo '<br>';
                    echo "Success! You will be redirected shortly back to the admin panel";
                    header("refresh:3;url=admin.php");
                    die();
                }
            } else {
                echo "File type not allowed";
            }
            if ($success_header == 1 && $success == 0) {
                header("refresh:1;url=admin.php");
                die();
            }
        }
        if ($mode == 'add') {
            echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' enctype='multipart/form-data'>
                <p><label for='name'>Name</label></p>
                <input type='text' name='name' id='name' required>
                <p><label for='capacity'>Capacity</label></p>
                <input type='text' name='capacity' id='capacity' required>
                <p><label for='description'>Description</label></p>
                <textarea id='description' name='description'></textarea>
                <p><label for='price_night'>Price per night</label></p>
                <input type='text' name='price_night' id='price_night'>
                <p><label for='price_week'>Price per week</label></p>
                <input type='text' name='price_week' id='price_week'>
                <p><label for='price_weekend'>Price per weekend</label></p>
                <input type='text' name='price_weekend' id='price_weekend'>
                <p><label for='discount'>Discount</label></p>
                <input type='text' name='discount' id='discount'>
                <p><label for='main_image'>Header Image</label></p>
                <input type='file' name='headerimage' id='main_image'>
                <p><label for='images'>Other Images</label></p>
                <input type='file' name='images[]' id='images' multiple><br>
                <input type='submit' name='submit_new' value='Add new Apartment'>
                <input type='reset' name='reset'>
            </form>";
        } else if ($mode == 'edit') {
            $id = filter_input(INPUT_GET, 'id');
            $_SESSION['edit_id'] = $id;
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);

            $sql = "SELECT `name`, `capacity`, `description`, `price_night`, `price_week`, `price_weekend`, `discount` FROM `apartments` WHERE `apartment_id` = " . $id . ";";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("could not send the data to the database: " . $conn->error);
                $stmt->bind_result($name, $capacity, $description, $price_night, $price_week, $price_weekend, $discount);
                $stmt->store_result();
                $stmt->fetch()
                    or die("Could not retrieve data" . $conn->error);
            } else {
                die("Could not prepare the statement" . $conn->error);
            }
            echo "<form method='POST' >
                <p><label for='name'>Name</label></p>
                <input type='text' name='name' id='name' value='" . $name . "' required>
                <p><label for='capacity'>Capacity</label></p>
                <input type='text' name='capacity' id='capacity' value='" . $capacity . "' required>
                <p><label for='description'>Description</label></p>
                <textarea id='description' name='description' >" . $description . "</textarea>
                <p><label for='price_night'>Price per night</label></p>
                <input type='text' name='price_night' id='price_night' value='" . $price_night . "'>
                <p><label for='price_week'>Price per week</label></p>
                <input type='text' name='price_week' id='price_week' value='" . $price_week . "'>
                <p><label for='price_weekend'>Price per weekend</label></p>
                <input type='text' name='price_weekend' id='price_weekend' value='" . $price_weekend . "'>
                <p><label for='discount'>Discount</label></p>
                <input type='text' name='discount' id='discount' value='" . $discount . "'><br>
                <input type='submit' name='submit_edit'  value='Submit Changes'>
                <input type='reset' name='reset'>
            </form>";
            echo "<form method='POST' action='edit_images.php?id=" . $id . "'>
            <input type='submit' name='edit_images' value='Edit images'>
            </form>";
            $stmt->close();
            $conn->close();
        }

        ?>
    </div>

    <?php include 'php/footer.php' ?>
</body>

</html>