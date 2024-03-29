<!doctype html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php'; 
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== TRUE ||  $_SESSION['authorisation'] !== 1) {
        echo "Your account does not have the authorisation to view this page.";
        header("refresh:1;url=index.php?");
        die();
    } ?>
    <div class="reservation_box">
        <br><h2>Reservations Options</h2>
        <form action='reservations.php' method='POST'>
            <input type='submit' value='View pending reservations'>
        </form>
        <form action='reservations.php?mode=all' method='POST'>
            <input type='submit' value='View all reservations'>
        </form><br>
        <h2>Users Options</h2>
        <form action='view_users.php' method='POST'>
            <input type='submit' value='View all users'>
        </form>
        <form action='view_contact.php' method='POST'>
            <input type='submit' value='View contact messages'>
        </form><br>
        <h2>Apartments Options</h2>
        <?php
        echo "<form action='property_management.php?mode=add' method='POST'>
            <input type='submit' value='Add new Apartment'>
        </form>";
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);

        $sql = "SELECT `apartment_id`, `name` FROM apartments ;";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die("could not send the data to the database: " . $conn->error);
            $stmt->bind_result($id, $apartment_name);
            $stmt->store_result();
            $data_array = array();
            $index = 0;
            while ($stmt->fetch()) {
                $data_array['id'][$index] = $id;
                $data_array['name'][$index] = $apartment_name;
                $index++;
            }
        } else {
            die("Could not prepare statement: " . $conn->errno);
        }
        /* foreach ($data_array as $key => $value)
        {
            foreach ($value as $apartment)
            {
                echo $key;
                echo "  ";
                echo $apartment;
                echo "<br>";
            }
        }*/
        ?>
        <form method='POST' onsubmit="location.href='property_management.php?mode=edit&id=' + document.getElementById('input').value; return false;">
            <input type="submit" value="Edit Apartment" />
            <select id="input">
                <?php
                for ($i = 0; $i < $index; $i++) {
                    echo "<option value='" . $data_array['id'][$i] . "'>" . $data_array['name'][$i] . "</option>";
                }
                ?>
            </select>
        </form>
        <form method='POST' onsubmit="location.href='delete_ap.php?id=' + document.getElementById('delete').value; return false;">
            <input type="submit" value="Delete Apartment" />
            <select id="delete">
                <?php
                for ($i = 0; $i < $index; $i++) {
                    echo "<option value='" . $data_array['id'][$i] . "'>" . $data_array['name'][$i] . "</option>";
                }
                ?>
            </select>
        </form>

        <?php $conn->close(); ?>
    </div>
    <?php include 'php/footer.php' ?>
</body>

</html>