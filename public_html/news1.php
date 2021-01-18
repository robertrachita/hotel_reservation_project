<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>
<body>
    <?php include 'php/header.php';
        $id = $_GET['id'];
        $config = parse_ini_file('../config.ini');
        $conn = new mysqli($config['db_host'], $config['db_user'], $config['db_pass']);
        if ($conn->connect_error) {
            die("Conection failed: " . $conn->connect_errno);
        }
        $conn->select_db($config['db_name'])
            or die("Could not load database: " . $conn->errno);
        $sql = "SELECT `title`,`images` FROM `article` WHERE id = $id ;";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->execute()
                or die ("Could not load the data" . $conn->error);
            $stmt->bind_result($title, $img);
            $stmt->store_result();    
        } else {
            die("Could not load the data " . $conn->error);
        }    

    ?>
    <div class="news_content">
    <?php while ($stmt->fetch()) : ?>
        <h1><?= $title; ?></h1>
        <div class="content_main">
            <div class="cleft"> 
                <img src="images/<?= $img; ?>">
    <?php endwhile; ?>    
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptas aliquid ex soluta similique, debitis sint quidem tempore itaque sequi. Odit repudiandae pariatur hic praesentium perferendis porro sed voluptatibus accusamus at molestias rerum sequi, itaque vitae excepturi ipsam optio repellat exercitationem! Facilis odio eum ullam aperiam error debitis consequatur, quis ipsum.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius id deleniti repellat nihil magni suscipit qui, quis sunt cum possimus rerum consequuntur libero porro eveniet neque mollitia molestiae reiciendis. Aspernatur aliquid eligendi harum quaerat quis cumque corporis. Ad, quasi labore? Porro alias ullam quod fugit quo pariatur quibusdam, sunt consectetur!</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores, fuga alias voluptates fugit earum adipisci nisi consequuntur rem commodi eaque.</p>
                <h3>Lorem Ipsum</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sed minima aperiam itaque dolorum voluptates, maiores soluta quos assumenda facere impedit maxime amet in reiciendis a fuga inventore vel tempora sunt explicabo cumque cupiditate est veritatis! Natus magnam quidem nihil facilis facere dolores omnis ex eum officia! Reiciendis maiores, ipsa quod possimus odit fugiat perferendis quas repellendus minima quae assumenda voluptates.
                     Explicabo eum quasi iure eveniet at sint laborum omnis temporibus suscipit laboriosam sunt est impedit dignissimos adipisci quae, veritatis aliquid eos. Laudantium repellendus natus mollitia doloremque excepturi. Vel sit ut eveniet voluptatibus id voluptatum eius repudiandae sequi. Voluptas, optio ea?</p>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis, deserunt magni modi deleniti, dolores est commodi quod in ab animi inventore sint facere nihil obcaecati facilis, tenetur asperiores corporis eos excepturi voluptatem labore iure nam. Perferendis animi officiis fugit sequi eligendi similique magnam dolores exercitationem quo ea. Minus totam voluptatum ipsam, modi maiores dicta explicabo dolorum, quaerat veritatis ut earum!</p>
            </div>
            <div class="cright">
                <h1>Covid News</h1>
                <div class="right_news">
                    <a href="news1.php?id=1">
                    <img src="images/covid.jpg">
                    <h2>Vaccine for Covid-19</h2>
                    </a>    
                </div>
                <br><br>
                <div class="right_news">
                    <a href="news1.php?id=2">
                    <img src="images/covid-19.jpg">
                    <h2>Covid-19 Cases in Netherlands</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'php/footer.php' ?>
</body>
</html>