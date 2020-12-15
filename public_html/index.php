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
            <input name="submit" type="submit" value=" ">
        </form>
    </div>
    <content>
        <?php
        $conn = new mysqli('localhost', 'root', '');
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db('hotel_system')
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
        /*if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                if ($counter) {
                    echo "<section>
                    <div class='imageBox' style='background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;'>
                    </div>
                    </div>
                    <div class='information'>
                        <div>
                            <h2>Apartment 1</h2><br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        </div>
                        <div class='button_info_right'>
                            <form action='#'></form>
                            <input type='submit' name='button_info' value='More Information'>
                            </form>
                        </div>
                    </div>
                </section>";
                } else {
                    echo " <section>
                    <div class='information'>
                        <div>
                            <h2>Apartment 2</h2><br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                        </div>
                        <div class='button_info_left'>
                            <form method='POST' action=''></form>
                            <input type='submit' name='button_info' value='More Information'>
                            </form>
                        </div>
                    </div>
                    <div class='imageBox' style='background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;'>
                    </div>
                </section";
                }
                //$counter++;
            }
        } else {
            die("There are no apartments available at this time. Check back later or contact the administrator.");
        }*/
        ?>

        <section>
            <div class='imageBox' style='background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;'>
            </div>
            </div>
            <div class='information'>
                <div>
                    <h2>Apartment 1</h2><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                </div>
                <div class='button_info_right'>
                    <form action='#'></form>
                    <input type='submit' name='button_info' value='More Information'>
                    </form>
                </div>
            </div>
        </section>
        <section>
            <div class='information'>
                <div>
                    <h2>Apartment 2</h2><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                </div>
                <div class='button_info_left'>
                    <form method='POST' action=''></form>
                    <input type='submit' name='button_info' value='More Information'>
                    </form>
                </div>
            </div>
            <div class='imageBox' style='background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;'>
            </div>
        </section>

    </content>

    <?php include 'php/footer.php' ?>
</body>

</html>