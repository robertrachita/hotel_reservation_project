<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='js/script.js'></script>
</head>
<body>
    <?php include 'php/header.php' ?>
    <article>
        <h1>Articles</h1> <br><br><br>
        <div class="top">
            <div>
                <a href="news1.php?id=3"><img src="images/travel.jpg">
                <h3>Explore Netherlands</h3></a> 
            </div>
            <div>
                <a href="news1.php?id=4"><img src="images/winter.jpg">
                <h3>It's Getting Colder in Netherlands</h3></a>
            </div>
            <div>
                <a href="news1.php?id=5"><img src="images/party.jpg">
                <h3>Nightlife in Netherlands</h3></a>
            </div>
            <div>
                <a href="news1.php?id=6"><img src="images/money.jpg">
                <h3>Cost of Life in Netherlands</h3></a>
            </div> 
        </div><br><br><br><hr><br><br>
        <div class="bottom">
            <div class="left">
                <div class="news">
                    <img src="images/scc.jpg">
                    <div>
                        <a href="news1.php?id=7"><h2>Why Study Career Coaching is Important for Your Life</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci esse quos aliquam ea fugiat explicabo rerum veritatis! Quaerat, alias nisi!</p>
                        </a>
                    </div>
                </div>
                <br><br><hr><br>
                <div class="news">
                    <img src="images/brain.png">
                    <div>
                        <a href="news1.php?id=8"><h2>Too Much Coding Can Harm Your Brain</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde dicta culpa asperiores enim sapiente cupiditate illum, corporis, ullam nisi aliquid accusamus ipsam sit quae, reprehenderit cumque possimus nam aut. Explicabo.</p>
                        </a>     
                    </div>
                </div>
                <br><br><hr><br>
                <div class="news">
                    <img src="images/cyber.jpg">
                    <div>
                        <a href="mews1.php?id=9"><h2>Cybernetic Arms for Humans</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, iure?</p>
                        </a>     
                    </div>
                </div>
                <br><br><hr><br>
            </div>
            <div class="right">
                <h1>Covid News</h1>
                <div>
                    <a href="news1.php?id=1"><img src="images/covid.jpg">
                    <h2>Vaccine for Covid-19</h2></a>
                </div>
                <br><br>
                <div>
                    <a href="news1.php?id=2"><img src="images/covid-19.jpg">
                    <h2>Covid-19 Cases in Netherlands</h2></a>
                </div>
            </div>
        </div>
    </article>
    <?php include 'php/footer.php' ?>
</body>
</html>