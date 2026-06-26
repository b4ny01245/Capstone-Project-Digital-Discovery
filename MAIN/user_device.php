<?php
$content = json_decode(file_get_contents("device.json"), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $content['title']; ?></title>
<link rel="shortcut icon" href="<?php echo $content['logo']; ?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="css/cyber.css">
</head>
<body>
<div class="container">
    <!-- Header -->
    <header id="home">
        <div class="header-top">
            <div class="logo"><img src="<?php echo $content['logo']; ?>" alt="Logo"></div>
            <h1><?php echo $content['header']; ?></h1>
            <nav class="navbar" id="navbar">
                <a href="user.php"><span><i class="fas fa-home"></i> Home</span></a>
                <a href="about.html"><span><i class="fas fa-question"></i> About Us</span></a>
                <a href="user.php#courses"><span><i class="fas fa-graduation-cap"></i> Lessons</span></a>
            </nav>
        </div>
    </header>

    <a href="user.php" class="bttn1" title="Return to Home">
        <button><i class="fas fa-arrow-left"></i></button>
    </a>

    <!-- Description -->
    <section class="playlist-details">
        <div class="column">
            <h3><?php echo $content['description']['title']; ?></h3>
            <p><?php echo $content['description']['english']; ?><br>
            <em><?php echo $content['description']['waray']; ?></em></p>
        </div>
    </section>

    <!-- Lessons -->
    <section class="playlist-videos">
        <h1 class="heading">Lesson Videos</h1>
        <div class="box-container">
            <?php foreach($content['lessons'] as $lesson): ?>
                <a class="box" href="<?php echo $lesson['link']; ?>">
                    <img src="<?php echo $lesson['img']; ?>" alt="<?php echo $lesson['title']; ?>">
                    <h3><?php echo $lesson['title']; ?></h3><br>
                    <hr>
                    <em><?php echo $lesson['waray']; ?></em>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        &copy; 2025 <?php echo $content['header']; ?>
    </footer>
</div>
</body>
</html>
