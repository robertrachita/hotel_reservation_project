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
        <section>
            <div class="imageBox" style="background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;">
            </div>
            </div>
            <div class="information">
                <div>
                    <h2>Apartment 1</h2><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                </div>
                <div class="button_info_right">
                    <form action="#"></form>
                    <input type="button" name="button_info" value="More Information">
                    </form>
                </div>
            </div>
        </section>
        <section>
            <div class="information">
                <div>
                    <h2>Apartment 2</h2><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                </div>
                <div class="button_info_left">
                    <form action="#"></form>
                    <input type="button" name="button_info" value="More Information">
                    </form>
                </div>
            </div>
            <div class="imageBox" style="background: url(images/appartement_iemke_1.jpg); background-size: 100% 100%;">
            </div>
        </section>
    </content>

    <?php include 'php/footer.php' ?>
</body>

</html>