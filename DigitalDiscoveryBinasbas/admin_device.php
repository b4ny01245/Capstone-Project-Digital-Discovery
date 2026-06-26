<?php

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$jsonFile = "device.json";
$content = json_decode(file_get_contents($jsonFile), true);

// Delete lesson
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_title'])) {
    foreach ($content['lessons'] as $key => $lesson) {
        if ($lesson['title'] === $_POST['delete_title']) {
            unset($content['lessons'][$key]);
            $content['lessons'] = array_values($content['lessons']);
            file_put_contents($jsonFile, json_encode($content, JSON_PRETTY_PRINT));
            $success = "Lesson deleted successfully!";
            break;
        }
    }
}

// Add new lesson
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && !isset($_POST['delete_title'])) {
    $newLesson = [
        'title' => $_POST['title'],
        'waray' => $_POST['waray'],
        'link' => $_POST['link'],
        'img' => $_POST['img']
    ];
    $content['lessons'][] = $newLesson;
    file_put_contents($jsonFile, json_encode($content, JSON_PRETTY_PRINT));
    $success = "Lesson added successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $content['title']; ?> - Admin</title>
<link rel="shortcut icon" href="<?php echo $content['logo']; ?>" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link rel="stylesheet" href="css/cyber.css">
<style>
:root {
    --bgcol:#a86c3e;
    --hov:#7c4f2c;
    --accent:#A3C1AD;
    --green:#258300;
}
body {font-family: Arial, sans-serif;}
.container {padding:0px;}
.box-container {display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px; margin-top:20px;}
.box {position:relative; border-radius:10px; overflow:hidden; transition:all 0.3s ease; background:#fff; box-shadow:0 3px 10px rgba(0,0,0,0.1);}
.box:hover {transform:translateY(-5px); box-shadow:0 10px 20px rgba(0,0,0,0.15);}
.box img {width:100%; height:150px; object-fit:cover;}
.box h3 {margin:10px; color:var(--hov);}
.box hr {border:none; border-top:1px solid #eee; margin:10px 0;}
.box em {margin:0 10px 10px; display:block; font-style:italic; color:#555;}

/* Delete button */
.delete-form {position:absolute; top:10px; right:10px; z-index:10;}
.delete-form button {background:#e74c3c; color:#fff; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; font-weight:bold; transition:all 0.3s ease; display:flex; align-items:center; gap:5px;}
.delete-form button:hover {background:#c0392b; transform:scale(1.05);}

/* Add Lesson Box */
.add-box {display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:200px; border:2px dashed var(--bgcol); border-radius:10px; cursor:pointer; text-align:center; padding:20px; transition:all 0.3s ease; background:rgba(168,108,62,0.1);}
.add-box:hover {background:rgba(168,108,62,0.2); transform:translateY(-5px);}
.add-box i {font-size:3rem; color:var(--bgcol); margin-bottom:15px;}
.add-box h3 {color:var(--hov); font-size:1.3rem; margin:0;}

.add-form {display:none; flex-direction:column; gap:10px; background:#fff; padding:15px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
.add-form.active {display:flex;}
.add-form input {padding:10px; border:2px solid #ddd; border-radius:8px; font-size:14px;}
.add-form input:focus {outline:none; border-color:var(--accent);}
.add-form button {padding:10px; border:none; border-radius:8px; cursor:pointer; font-weight:600; color:#fff; background:var(--green); transition:all 0.3s ease;}
.add-form button:hover {background:#1e6a00;}
.add-form .cancel {background:#e74c3c;}
.add-form .cancel:hover {background:#c0392b;}

.success-msg {text-align:center; background:rgba(37,131,0,0.1); color:var(--green); padding:10px; margin-bottom:15px; border-radius:8px; font-weight:bold;}
</style>
</head>
<body>
<div class="container">
<section class="playlist-videos">
<h1 class="heading">Device Lessons</h1>
<?php if(isset($success)) echo "<p class='success-msg'><i class='fas fa-check-circle'></i> $success</p>"; ?>
<div class="box-container">
    <?php foreach($content['lessons'] as $lesson): ?>
    <div class="box">
        <a href="<?php echo $lesson['link']; ?>">
            <img src="<?php echo $lesson['img']; ?>" alt="<?php echo $lesson['title']; ?>">
            <h3><?php echo $lesson['title']; ?></h3>
            <hr>
            <em><?php echo $lesson['waray']; ?></em>
        </a>
        <form method="POST" class="delete-form">
            <input type="hidden" name="delete_title" value="<?php echo $lesson['title']; ?>">
            <button type="submit" title="Delete Lesson">❌Delete</button>
        </form>
    </div>
    <?php endforeach; ?>

    <div class="add-box" id="addBox">
        <i class="fas fa-plus"></i>
        <h3>Add New Lesson</h3>
        <div class="add-form" id="addForm">
            <form method="POST">
                <input type="text" name="title" placeholder="Lesson Title" required>
                <input type="text" name="waray" placeholder="Waray Description" required>
                <input type="text" name="link" placeholder="Lesson Link" required>
                <input type="text" name="img" placeholder="Image URL" required>
                <button type="submit"><i class="fas fa-save"></i> Add Lesson</button>
                <button type="button" class="cancel" id="cancelAdd"><i class="fas fa-times"></i> Cancel</button>
            </form>
        </div>
    </div>
</div>
</section>
</div>

<script>
document.getElementById("addBox").addEventListener("click", function(e){
    if(e.target.closest('.add-box')){
        this.querySelector('.add-form').classList.add('active');
        this.querySelector('i,h3').style.display='none';
    }
});
document.getElementById("cancelAdd").addEventListener("click", function(){
    let box = document.getElementById("addBox");
    box.querySelector('.add-form').classList.remove('active');
    box.querySelector('i,h3').style.display='block';
});
</script>
</body>
</html>
