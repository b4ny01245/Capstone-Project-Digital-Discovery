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
    <style>
        /* Additional styles for delete and add functionality */
        :root {
            --bgcol: #a86c3e;
            --hov: #7c4f2c;
            --accent-color: #A3C1AD;
            --waray: #258300;
        }
        
        #courses h2 {
            margin-bottom: 30px;
            color: var(--hov);
            position: relative;
            padding-bottom: 10px;
        }
        
        #courses h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }
        
        .add-module-box {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(168, 108, 62, 0.1);
            border: 2px dashed var(--bgcol);
            border-radius: 10px;
            min-height: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .add-module-box:hover {
            background: rgba(168, 108, 62, 0.2);
            transform: translateY(-5px);
        }
        
        .add-module-box i {
            font-size: 3rem;
            color: var(--bgcol);
        }
        
        .box {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .box form {
            position: absolute;
            bottom: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .box:hover form {
            opacity: 1;
        }
        
        .box form button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .box form button:hover {
            background: #c0392b;
            transform: scale(1.05);
        }
        
        #addForm {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 1px solid var(--accent-color);
            animation: fadeIn 0.5s ease;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #addForm h3 {
            color: var(--hov);
            margin-bottom: 15px;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 8px;
        }
        
        #addForm h3::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }
        
        #addForm form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        #addForm input {
            padding: 8px 12px;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        #addForm input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(163, 193, 173, 0.2);
        }
        
        #addForm button[type="submit"] {
            background: var(--bgcol);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 5px;
        }
        
        #addForm button[type="submit"]:hover {
            background: var(--hov);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            #addForm {
                padding: 15px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
$data = file_get_contents("data.json");
$modules = json_decode($data, true);
?>
<section id="courses" class="courses">
    <h2>Learning Modules</h2>
    <div class="box-container" id="lessonsContainer">
        <?php foreach ($modules as $item): ?>
            <div class="box">
    <a href="<?= $item['video_url'] ?>" class="button-link">
        <img src="<?= $item['icon'] ?>" alt="<?= $item['title'] ?> Icon">
        <span><?= $item['modules'] ?> <?= $item['modules'] > 1 ? 'modules' : 'video' ?></span>
        <h3><?= $item['title'] ?></h3><br>
        <hr>
        <span><?= $item['description'] ?></span>
    </a>
    <!-- Delete Button -->
    <form method="POST" action="delete_module.php">
        <input type="hidden" name="title" value="<?= $item['title'] ?>">
        <button type="submit" title="Delete Module"><i class="fas fa-trash-alt"></i></button>
    </form>
</div>
        <?php endforeach; ?>
        
        <!-- Add Module Box -->
        <div class="box add-module-box" id="addModuleBox">
            <i class="fas fa-plus"></i>
        </div>
    </div>
</section>
<!-- Hidden Form -->
<div id="addForm" style="display:none;">
    <h3>Add New Module</h3>
    <form method="POST" action="save_module.php">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="text" name="video_url" placeholder="Video URL" required>
        <input type="text" name="icon" placeholder="Icon (image path)" required>
        <input type="number" name="modules" placeholder="Number of modules/videos" required>
        <button type="submit">Save Module</button>
    </form>
</div>
    </div>
    <script>
document.getElementById("addModuleBox").addEventListener("click", function(){
    let form = document.getElementById("addForm");
    form.style.display = (form.style.display === "none") ? "block" : "none";
    
    // Scroll to form when opened
    if (form.style.display === "block") {
        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
</body>
</html>