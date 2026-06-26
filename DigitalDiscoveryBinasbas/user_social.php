<?php
$jsonFile = "social.json";
$content = json_decode(file_get_contents($jsonFile), true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Digital Discovery for Seniors</title>
   <link rel="shortcut icon" href="xFiles/xlogo.jpg" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link rel="stylesheet" href="css/cyber.css">
</head>

<body>
   <div class="container">
      <!-- Header -->
      <header id="home">
         <div class="header-top">
            <div class="logo"><img src="xFiles/xlogo.jpg" alt="Logo"></div>
            <h1>DIGITAL DISCOVERY FOR ELDERLY PEOPLE</h1>
            <nav class="navbar" id="navbar">
               <a href="user.php"><i class="fas fa-home"></i>Home</a>
               <a href="about.html"><i class="fas fa-question"></i>About Us</a>
               <a href="user.php#courses"><i class="fas fa-graduation-cap"></i>Lessons</a>
            </nav>
         </div>
      </header>

      <a href="user.php" class="bttn1" title="Return to Home">
         <button><i class="fas fa-arrow-left"></i></button>
      </a>

      <!-- Social Media Learning Info -->
      <section class="playlist-details">
         <div class="column">
            <div class="details">
               <h3>Social Media Learning</h3>
               <p>
                  This topic helps our elders learn how to use common social media applications.
                  <br>
                  <em>Ine nga aradman makakabulig haat mga elders pag hibaro kun paunan-o itun pag gamit hitun mga kumon nga ginagamit nga social media applikasyon</em>
               </p>
            </div>
         </div>
      </section>

      <!-- Lesson Videos -->
      <section class="playlist-videos">
         <h1 class="heading">Lesson Videos</h1>
         <div class="box-container">
            <?php foreach ($content['lessons'] as $lesson): ?>
               <a class="box" href="<?= $lesson['file'] ?>">
                  <i class="fas fa-play"></i>
                  <img src="<?= $lesson['image'] ?>" alt="<?= $lesson['title'] ?>">
                  <h3><?= $lesson['title'] ?></h3>
                  <br><hr>
                  <em><?= $lesson['description'] ?></em>
               </a>
            <?php endforeach; ?>
         </div>
      </section>

      <!-- Footer -->
      <footer class="footer">
         &copy; 2025 Digital Discovery for Elderly People
      </footer>
   </div>
</body>
</html>
