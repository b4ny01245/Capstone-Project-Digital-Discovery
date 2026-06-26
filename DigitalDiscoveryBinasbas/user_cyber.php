<?php
$content = json_decode(file_get_contents("cyber.json"), true);
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
            <div class="logo">
                <img src="<?php echo $content['logo']; ?>" alt="Logo">
            </div>
            <h1><?php echo $content['header']; ?></h1>
            <nav class="navbar" id="navbar">
                <?php foreach($content['nav'] as $nav): ?>
                    <a href="<?php echo $nav['href']; ?>">
                        <span><i class="<?php echo $nav['icon']; ?>"></i><?php echo $nav['label']; ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <a href="user.php#courses" class="bttn1" title="Return to Home">
        <button><i class="fas fa-arrow-left"></i></button>
    </a>

    <?php if(isset($content['contents'])): ?>
        <?php foreach($content['contents'] as $block): ?>
            <!-- Video Section -->
            <section class="watch-video">
                <div class="video-wrapper">
                <iframe 
    src="<?php echo $block['video']['src']; ?>" 
    width="800" 
    height="450" 
    allow="autoplay" 
    allowfullscreen>
</iframe>

                    <h3 class="main-vid-title">
                        <?php echo $block['video']['title']; ?> <br>
                        <em><?php echo $block['video']['subtitle']; ?></em>
                    </h3>
                </div>
            </section>

            <!-- Description Section -->
            <section class="content-section">
                <div class="content">
                    <h2><?php echo $block['description']['title']; ?></h2>
                    <p class="english"><?php echo $block['description']['english']; ?></p>
                    <p class="waray"><em><?php echo $block['description']['waray']; ?></em></p>

                    <h3>Simple Tips for Cybersecurity</h3>
                    <?php if(isset($block['tips'])): ?>
                        <?php foreach($block['tips'] as $tip): ?>
                            <div class="tip">
                                <?php if(isset($tip['img'])): ?>
                                    <img src="<?php echo $tip['img']; ?>" alt="tip image" class="tip-img right">
                                <?php endif; ?>
                                <p class="english"><?php echo $tip['english']; ?></p>
                                <p class="waray"><em><?php echo $tip['waray']; ?></em></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <h3>🎯 Key Point</h3>
                    <p class="english"><?php echo $block['keypoint']['english']; ?></p>
                    <p class="waray"><em><?php echo $block['keypoint']['waray']; ?></em></p>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        &copy; 2025 <?php echo $content['header']; ?>
    </footer>
</div>
</body>
</html>
