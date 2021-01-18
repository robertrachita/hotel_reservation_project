<!doctype html>
<html lang="en">

<head>
    <title>Respond</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php';
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE && $_SESSION['authorisation'] !== 1) {
        echo "Your do not have the authorisation to be here";
        header("refresh:2;url=index.php?");
        die();
    }
    ?>
    <div class="reservation_box">
        <?php
        $submit = filter_input(INPUT_POST, 'submit');
        $id = filter_input(INPUT_GET, 'id');
        if (isset($submit)) {
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (empty($message)) {
                die("You need to type in the message!");
            }
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);
            $today = date("Y-m-d");
            $sql = "UPDATE `contact` SET `response` = '" . $message . "', `date_response` = '" . $today . "' WHERE `contact_id` = " . $id . " ;";
            echo $sql;
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("Could not run query: " . $conn->error);
                echo "Success!";
                header("refresh:2;url=view_contact.php?");
                die();
            } else {
                die("Could not prepare statement: " . $conn->error);
            }
        } else {
            echo "<form method='POST'>
            <label for='message'>Your response</label>
            <input type='text' name='message' id='message' required>
            <input type='hidden' name='id' value='" . $id . "'><br>
            <input type='submit' name='submit' value='Submit'>
            </form>";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>