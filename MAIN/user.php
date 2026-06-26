<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Digital Discovery for Seniors</title>
    <link rel="shortcut icon" href="xFiles/xlogo.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="css/index.css">
    <!-- CDN (Content Delivery Network) -->
    <!-- Intro.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>

</head>

<body>
    <div class="container">

        <!-- Header -->
        <header id="home">
            <div class="header-top" data-step="2"
                data-intro="Here you can see the Logo, Name and Menu of our website. This is what we call the HEADER.<br><br> <hr> Dinhi po makikita itun Logo, ngaran, ngan Menu hitun amun website. Tinatawag po ine natun nga HEADER">
                <div class="logo">
                    <img src="xFiles/xlogo.jpg" alt="Logo">
                </div>
                <h1>DIGITAL DISCOVERY FOR ELDERLY PEOPLE</h1>
                <nav class="navbar" id="navbar" data-step="3"
                    data-intro="Use this Navigation Bar to choose where you want to go in our website.<br><br> <hr> Gamita ine nga Navigation Bar para mag pili kun hain mo karuyag kumadto ha am website">
                    <a href="#home"><span data-step="4"
                            data-intro="Click here when you want to go back to start.<br><br> <hr>Pinduta ine kun karuyag mo hibalik ha katinikangan."><i
                                class="fas fa-home"></i>Home</span></a>
                    <a href="about.html"><span data-step="5"
                            data-intro="Click here when you want to know the developers. <br><br> <hr>Pinduta ine kun karuyag mo hibaro mahitungod han nag himo hine."><i
                                class="fas fa-question"></i>About Us</span></a>
                    <a href="#courses"><span data-step="6"
                            data-intro="Click here when you're ready to learn.<br><br> <hr>Pinduta ine kun karuyag mo na mag tikang mag aram."><i
                                class="fas fa-graduation-cap"></i>Lessons</span></a>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="home-grid" data-step="7"
            data-intro="This is the information or explanation about our website <br><br> <hr>Asya po ine itun haliputay nga impormasyon o eksplinasyon mahitungod han amun website">
            <div class="text">
                <div class="bttn" data-step="1"
                    data-intro="Here you can choose whether you want to be guided or you want to be directed to start learning. <br><br> <hr>Didi puydi ka po mag Pili kun karuyag mo mag pa alalay o kun karuyag mo deritso mag aram">
                    <a class="button-link"><button onclick="introJs().start()">
                            <i class="fas fa-user"></i> GUIDE ME <br> Alalayi ako
                        </button></a>
                    <a href="#courses" class="button-link">
                        <button><i class="fas fa-play"></i> START LEARNING <br>Tikangi Pag-aram</button></a>
                </div>
                <blockquote>
                    Digital Discovery for Elders is an interactive learning platform
                    designed to help Filipino senior citizens build confidence, improve digital skills, and stay safe
                    online.<br>
                    Learn at your own pace with easy-to-use lessons made just for you.
                </blockquote>
                <blockquote class="waray">
                    An Digital Discovery para ha mga elders amo an usa nga interactive nga plataporma na ginhimo para
                    mabuligan an mga Pilipino nga senior citizen nga magka may ada kumpiyansa, mapa-uswag an ira
                    digital nga mga abilidad, ngan magin talwas ha paggamit han internet.<br>
                    Mag-aram ha imo kalugaringon nga
                    oras pinaagi han gin pasayon nga mga leksyon nga gin-andam para ha imo.
                </blockquote>
            </div>
            <div class="image">
                <img src="xFiles/R.jpg" alt="Elderly couple" />
            </div>
        </section>
        <?php
$data = file_get_contents("data.json");
$modules = json_decode($data, true);
?>
        <section id="courses" class="courses" data-step="8"
            data-intro="Here you can see the learning modules. <br>-Dinhi naman makikita an kada modyul.">
            <div class="box-container" id="lessonsContainer">
                <?php foreach ($modules as $item): ?>
                <div class="box">
                    <a href="<?= $item['video_url'] ?>" class="button-link">
                        <img src="<?= $item['icon'] ?>" alt="<?= $item['title'] ?> Icon">
                        <span>
                            <?= $item['modules'] ?>
                            <?= $item['modules'] > 1 ? 'modules' : 'video' ?>
                        </span>
                        <h3>
                            <?= $item['title'] ?>
                        </h3><br>
                        <hr>
                        <span>
                            <?= $item['description'] ?>
                        </span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
<!-- Floating Comment Box -->
<div id="comment-container">
    <div id="comment-button">
        <i class="fas fa-comment-dots"></i>
    </div>
    <div id="comment-window">
        <div id="comment-header">
            <span>Suggestions & Comments</span>
            <button id="comment-close">&times;</button>
        </div>
        <div id="comment-form">
            <form id="suggestion-form" action="save_comment.php" method="POST">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="comment">Your Comment/Suggestion:</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Submit</button>
                </div>
            </form>
        </div>
        <div id="comment-thanks" style="display: none;">
            <div class="thank-you-message">
                <i class="fas fa-check-circle"></i>
                <h3>Thank You!</h3>
                <p>Your comment has been submitted successfully.</p>
                <button id="new-comment-btn">Submit Another Comment</button>
            </div>
        </div>
    </div>
</div>

<style>
#comment-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    font-family: Arial, sans-serif;
}

#comment-button {
    width: 60px;
    height: 60px;
    background-color: #258300;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    color: white;
    font-size: 24px;
}

#comment-window {
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 350px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
}

#comment-header {
    background-color: #a86c3e;
    color: white;
    padding: 10px 15px;
    border-radius: 10px 10px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#comment-close {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

#comment-form {
    padding: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.submit-btn {
    background-color: #258300;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

.submit-btn:hover {
    background-color: #7c4f2c;
}

.thank-you-message {
    text-align: center;
    padding: 20px;
}

.thank-you-message i {
    font-size: 48px;
    color: #258300;
    margin-bottom: 15px;
}

.thank-you-message h3 {
    margin-bottom: 10px;
}

#new-comment-btn {
    background-color: #258300;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 15px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const commentButton = document.getElementById('comment-button');
    const commentWindow = document.getElementById('comment-window');
    const commentClose = document.getElementById('comment-close');
    const commentForm = document.getElementById('suggestion-form');
    const commentThanks = document.getElementById('comment-thanks');
    const newCommentBtn = document.getElementById('new-comment-btn');

    // Toggle comment window
    commentButton.addEventListener('click', function() {
        commentWindow.style.display = commentWindow.style.display === 'flex' ? 'none' : 'flex';
    });

    commentClose.addEventListener('click', function() {
        commentWindow.style.display = 'none';
    });

    // Handle form submission
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(commentForm);
        
        // Send data to server
        fetch('save_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show thank you message
                commentForm.style.display = 'none';
                commentThanks.style.display = 'block';
                
                // Reset form
                commentForm.reset();
            } else {
                alert('Error submitting comment. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting comment. Please try again.');
        });
    });

    // Reset form for new comment
    newCommentBtn.addEventListener('click', function() {
        commentForm.style.display = 'block';
        commentThanks.style.display = 'none';
    });
});
</script>

        </section>
        <!-- Footer -->
        <footer>
            © 2025 DIGITAL DISCOVERY FOR ELDERLY PEOPLE
        </footer>

</body>

</html>