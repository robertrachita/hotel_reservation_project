<!doctype html>
<html lang="en">

<head>
    <title>Arjen's Plak</title>
    <link rel='stylesheet' href='css/styles.css' type="text/css">
    <meta charset="utf-8">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>

<body>
    <?php include 'php/header.php' ?>
    <content>
        <?php
        $id = filter_input(INPUT_GET, 'id');
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        $sql = "SELECT  `name`, `description`, `capacity` FROM `apartments` WHERE `apartment_id`=" . $id . " ;";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die("Could not send the data to the database: " . $conn->errno);
            $stmt->bind_result($name, $description, $capacity);
            $stmt->store_result();
            $stmt->fetch();
        } else {
            die("Could not prepare statement: " . $conn->errno);
        }
        $path = "images/apartments/" . $id . "/header_image.{jpeg,gif,png,jpg}";
        $headerimage = glob($path, GLOB_BRACE);
        //echo "<img id='apartment-img' src='" . $headerimage[0] . "' alt='header_image'>";
        ?>
        <div class="apartment-container">

            <!--<div class='mySlides'>
                <div class='numbertext'>1 / 6</div>
                <img src="<?php echo $headerimage[0]; ?>" style='width:100%' alt='image'>
            </div>-->
            <?php
            $path = "images/apartments/" . $id . "/";
            if (is_dir($path)) {
                $folder = scandir($path);
                unset($folder[0]);
                unset($folder[1]);
                $file_count = count($folder);
                $i = 1;
                foreach ($folder as $file) {
                    if ($i == 1) {
                        echo "<div class='mySlides' style='display: block;'>
                    <div class='numbertext'>" . $i . "/" . $file_count . "</div>
                    <img src=" . $path . $file . " style='width:100%' alt='image'>
                    </div>";
                    }
                    else if ($i != 1) {
                        echo "<div class='mySlides'>
                    <div class='numbertext'>" . $i . "/" . $file_count . "</div>
                    <img src=" . $path . $file . " style='width:100%' alt='image'>
                     </div>";
                    }
                    $i++;
                }
            }
            ?>
            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

            <div class="caption-container">
                <p id="caption"><?php echo $name; ?></p>
            </div>

            <div class="row">
                <?php
                $i = 1;
                foreach ($folder as $file) {
                    echo "<div class='column'>
                    <img class='demo cursor' src=" . $path . $file . " style='width:100%' onclick='currentSlide(" . $i . ")' alt='small_image'>
                </div>";
                    $i++;
                }
                ?>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nobis repudiandae sapiente modi placeat dignissimos nesciunt illum dicta alias ducimus totam!</p><br>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore architecto explicabo totam pariatur impedit eius ipsum blanditiis ab assumenda animi maxime illo placeat aliquam nulla ex atque, adipisci cupiditate a, distinctio ducimus beatae sed rem numquam. Magnam repellat sit perspiciatis quidem velit illum, minima, inventore beatae laboriosam dolore hic placeat!</p><br>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repudiandae optio itaque, sed inventore adipisci officia eos quisquam vero magni commodi ipsa iusto ducimus. Excepturi incidunt necessitatibus quo nihil tempora labore inventore quis saepe explicabo harum aliquam ullam, perferendis beatae similique molestias. Dignissimos voluptas excepturi doloribus exercitationem ducimus consectetur omnis ullam accusamus sint dicta magnam quam, laboriosam error dolorum provident ab? Sit voluptate facere sapiente aspernatur perspiciatis! Tempora dolore, sapiente est aliquam illo eligendi amet illum ut quos, numquam magnam impedit. Nobis quam accusantium illum ipsa rem cumque hic est. Laudantium eaque quas blanditiis quo sapiente similique temporibus consequatur distinctio eum!	</p>
        </div>
    </content>

    <?php include 'php/footer.php' ?>
</body>

</html>