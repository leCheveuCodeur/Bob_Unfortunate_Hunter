<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js" async></script>
    <title>Exo 4 </title>
</head>

<body>
    <main>
        <h1>Bob, unfortunate hunter.</h1>
        <div class="launchStory">
            <h2>Launch the story</h2> <input type="button" value="CLICK HERE !" id="refresh" />
            <p class="note">Or with the F5 key on the keyboard</p>
        </div>
        <h2>Initialisation of game :</h2>
        <section class="initOfGame">
            <div>
                <div class="cards">
                    <h3>Bob the Hunter</h3>
                    <table>
                        <tr>
                            <td>Nb of Bullets :</td>
                            <td><?php echo $bobTheHunter->getNbBullets(); ?></td>
                        </tr>
                        <tr>
                            <td>Satiety level :</td>
                            <td><?php echo $bobTheHunter->getSatietylevel(); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card2">
                <p class="versus">VS</p>
                <div class="cards">
                    <h3>The Forest</h3>
                    <table>
                        <tr>
                            <td>Forest size (km2) :</td>
                            <td><?php echo Forest::getTotalSquareKm(); ?></td>
                        </tr>
                        <tr>
                            <td>Nb of Holes :</td>
                            <td><?php echo count(Forest::getHoles()); ?></td>
                        </tr>
                        <tr>
                            <td>Nb of Rabbits :</td>
                            <td><?php echo count(Forest::getRabbits()); ?></td>
                        </tr>
                        <tr>
                            <td>Nb of Trees :</td>
                            <td><?php echo $getTrees = is_null(Forest::getTrees()) ? 0 : count(Forest::getTrees()); ?></td>
                    </table>
                </div>
            </div>
        </section>
        <section>
            <h2>Story</h2>
            <table class="story">
                <thead>
                    <tr>
                        <td>Km no.</td>
                        <td>Story</td>
                        <td>Nb of remaining Bullets</td>
                        <td>Satiety level</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $bobTheHunter->huntTheRabbits();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>