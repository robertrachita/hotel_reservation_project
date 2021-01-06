<!doctype html>
<html lang="en">

<head>
    <title>Arjen's Plak</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">
-->
</head>

<body>
    <?php include 'php/header.php' ?>
    <div class="searchbox">
        <form action="" method="POST">
            <input name="entryDate" type="date" placeholder="Arrival">
            <input name="entryDate" type="date" placeholder="Departure">
            <input name="submit" type="submit" value=' '>
        </form>
    </div>
    <content>
        <?php
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        $sql = "SELECT `apartment_id`, `name`, `description`, `capacity` FROM `apartments` ;";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die("Could not send the data to the database: " . $conn->errno);
            $stmt->bind_result($id, $name, $description, $capacity);
            $stmt->store_result();
        } else {
            die("Could not prepare statement: " . $conn->errno);
        }
        $counter = 1;
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $path = "images/apartments/".$id."/header_image.{jpeg,gif,png,jpg}";
                $image = glob($path, GLOB_BRACE);
                //echo $image[0];
               // echo "<img src='".$image[0]."' alt='error' >";
                if ($counter%2 !== 0) {
                   echo "<section>
                    <div class='imageBox' style='background: url(".$image[0]."); background-size: 100% 100%;'>
                    </div>
                    <div class='information'>
                        <div>
                            <h2>".$name."</h2><br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        </div>
                        <div class='button_info_right'>
                            <form method='POST' action='apartment.php?id=".$id."'>
                            <input type='submit' name='button_info' value='More Information'>
                            </form>
                        </div>
                    </div>
                </section>";
                $counter++;
                } else {
                    echo " <section>
                    <div class='information'>
                        <div>
                            <h2>".$name."</h2><br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        </div>
                        <div class='button_info_left'>
                            <form method='POST' action='apartment.php?id=".$id."'>
                            <input type='submit' name='button_info' value='More Information'>
                            </form>
                        </div>
                    </div>
                    <div class='imageBox' style='background: url(".$image[0]."); background-size: 100% 100%;'>
                    </div>
                </section>";
                $counter--;
                }
            }
            $stmt->close();
            $conn->close();
        } else {
            die("There are no apartments available at this time. Check back later or contact the administrator.");
        }
        ?>

    </content>

    <?php include 'php/footer.php' ?>
</body>

</html>