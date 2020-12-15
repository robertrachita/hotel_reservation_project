<!doctype html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
</head>

<body>
    <?php include 'php/header.php' ?>
    <div>
        <form action="property_management.php?mode=add" method="POST">
            <input type='submit' value="Add new Apartment">
        </form>
        <?php
        $conn = new mysqli("localhost", "root", "");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        mysqli_select_db($conn, 'hotel_system')
            or die("Could not load database: " . $conn->connect_error);

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
                for ($i = 0; $i < $index; $i++ )
                {
                    echo "<option value='" . $data_array['id'][$i] . "'>" . $data_array['name'][$i] . "</option>";
                }
                ?>
            </select>
        </form>
        <form method='POST' onsubmit="location.href='delete_ap.php?id=' + document.getElementById('delete').value; return false;">
            <input type="submit" value="Delete Apartment" />
            <select id="delete">
                <?php
                 for ($i = 0; $i < $index; $i++ )
                 {
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