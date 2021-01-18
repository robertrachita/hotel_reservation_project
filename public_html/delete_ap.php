<!doctype html>
<html lang="en">

<head>
    <title>Delete</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <div>
        <?php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE ||  $_SESSION['authorisation'] !== 1) {
            echo "Your account does not have the authorisation to view this page.";
            header("refresh:1;url=index.php?");
                            die();
        }
        error_reporting(E_ERROR | E_PARSE);
        $_SESSION['deleteid'] = filter_input(INPUT_GET, 'id');
        $delete = $_POST['delete'];
        if ($delete) {
            $id = $_SESSION['deleteid'];
            unset($_SESSION['deleteid']);
            $config = parse_ini_file('../config.ini');
            $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
            if ($conn->connect_error) {
                die("Conection failed: " . $conn->connect_errno);
            }
            $conn->select_db($config['db_name'])
                or die("Could not load database: " . $conn->errno);

            $sql = "DELETE FROM `apartments` WHERE `apartment_id` = " . $id . " ; ";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->execute()
                    or die("could not send the data to the database: " . $conn->error);
                $stmt->close();
                $conn->close();
                function delete_files($target)
                {
                    if (is_dir($target)) {
                        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

                        foreach ($files as $file) {
                            delete_files($file);
                        }

                        rmdir($target);
                    } elseif (is_file($target)) {
                        unlink($target);
                    }
                }
                delete_files('images/apartments/'.$id.'/');
                echo "Entry deleted successfully!";
                header("refresh:1;url=admin.php");
                die();
            }
        } else {
            echo "<h3>Are you sure you want to delete this apartment?</h3>";
            echo "<form method='POST' action='admin.php'>
            <input type='submit' value='No, go back' name='return' />
            </form>";
            echo "<form method='POST'>
            <input type='submit' class='negative'  id='negativ' name='delete' value='Yes, Delete Apartment'/>
            </form>";
        }
        ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>