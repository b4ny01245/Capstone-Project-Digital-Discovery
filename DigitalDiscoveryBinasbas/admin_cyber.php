<?php

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$jsonFile = "cyber.json";
$content = json_decode(file_get_contents($jsonFile), true);
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contents = [];
    if(isset($_POST['video_src'])) {
        // Loop through all content blocks
        for($i=0; $i < count($_POST['video_src']); $i++){
            $block = [
                'video' => [
                    'src' => $_POST['video_src'][$i],
                    'poster' => $_POST['video_poster'][$i],
                    'title' => $_POST['video_title'][$i],
                    'subtitle' => $_POST['video_subtitle'][$i]
                ],
                'description' => [
                    'title' => $_POST['desc_title'][$i],
                    'english' => $_POST['desc_english'][$i],
                    'waray' => $_POST['desc_waray'][$i]
                ],
                'keypoint' => [
                    'english' => $_POST['key_english'][$i],
                    'waray' => $_POST['key_waray'][$i]
                ]
            ];
            // Tips
            $tips = [];
            if(isset($_POST['tip_english'][$i])) {
                for($j=0; $j < count($_POST['tip_english'][$i]); $j++){
                    if(trim($_POST['tip_english'][$i][$j]) !== '' || trim($_POST['tip_waray'][$i][$j]) !== '') {
                        $tip = [
                            'english' => $_POST['tip_english'][$i][$j],
                            'waray' => $_POST['tip_waray'][$i][$j]
                        ];
                        if(!empty($_POST['tip_img'][$i][$j])){
                            $tip['img'] = $_POST['tip_img'][$i][$j];
                        }
                        $tips[] = $tip;
                    }
                }
            }
            $block['tips'] = $tips;
            $contents[] = $block;
        }
    }
    $content['contents'] = $contents;
    // Save updated JSON
    file_put_contents($jsonFile, json_encode($content, JSON_PRETTY_PRINT));
    $success = "Cyber content updated successfully!";
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<div class="cyber-admin-container">
<h1><i class="fas fa-shield-alt"></i> Admin Cybersecurity Content</h1>
<?php if(isset($success)) echo "<p class='success-msg'><i class=\"fas fa-check-circle\"></i> $success</p>"; ?>
<form method="post">
<div id="blocksContainer">
<?php foreach($content['contents'] as $index => $block): ?>
<div class="content-block">
    <button type="button" class="remove-block" onclick="this.parentElement.remove()"><i class="fas fa-trash-alt"></i></button>
    <h2><i class="fas fa-video"></i> Video</h2>
    <input type="text" name="video_src[]" value="<?php echo $block['video']['src']; ?>" placeholder="Video Source">
    <div class="file-input-wrapper">
        <label class="file-input-label">
            <i class="fas fa-image"></i> Choose Poster Image
            <input type="file" name="video_poster_file[]" accept="image/*" onchange="previewImage(this)">
        </label>
    </div>
    <input type="text" name="video_poster[]" value="<?php echo $block['video']['poster']; ?>" placeholder="Poster Image" class="media-url">
    <input type="text" name="video_title[]" value="<?php echo $block['video']['title']; ?>" placeholder="Video Title">
    <input type="text" name="video_subtitle[]" value="<?php echo $block['video']['subtitle']; ?>" placeholder="Video Subtitle">
    <h2><i class="fas fa-info-circle"></i> Description</h2>
    <input type="text" name="desc_title[]" value="<?php echo $block['description']['title']; ?>" placeholder="Description Title">
    <textarea name="desc_english[]" rows="3" placeholder="English Description"><?php echo $block['description']['english']; ?></textarea>
    <textarea name="desc_waray[]" rows="3" placeholder="Waray Description"><?php echo $block['description']['waray']; ?></textarea>
    <h2><i class="fas fa-lightbulb"></i> Tips</h2>
    <div id="tipsContainer<?php echo $index; ?>">
        <?php foreach($block['tips'] as $tip): ?>
        <div class="tip-block">
            <button type="button" class="remove-tip" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            <div class="file-input-wrapper">
                <label class="file-input-label">
                    <i class="fas fa-image"></i> Choose Image
                    <input type="file" name="tip_img_file[<?php echo $index; ?>][]" accept="image/*" onchange="previewImage(this)">
                </label>
            </div>
            <input type="text" name="tip_img[<?php echo $index; ?>][]" value="<?php echo $tip['img'] ?? ''; ?>" placeholder="Image URL" class="media-url">
            <input type="text" name="tip_english[<?php echo $index; ?>][]" value="<?php echo $tip['english']; ?>" placeholder="Tip English">
            <input type="text" name="tip_waray[<?php echo $index; ?>][]" value="<?php echo $tip['waray']; ?>" placeholder="Tip Waray">
        </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="add-tip" onclick="addTip(<?php echo $index; ?>)"><i class="fas fa-plus"></i> Add Tip</button>
    <h2><i class="fas fa-key"></i> Key Point</h2>
    <input type="text" name="key_english[]" value="<?php echo $block['keypoint']['english']; ?>" placeholder="Key Point English">
    <input type="text" name="key_waray[]" value="<?php echo $block['keypoint']['waray']; ?>" placeholder="Key Point Waray">
</div>
<?php endforeach; ?>
</div>
<button type="button" class="add-block"><i class="fas fa-plus"></i> Add New Content Block</button>
<br><br>
<center><button type="submit"><i class="fas fa-save"></i> Save All Changes</button><center>
</form>
</div>

<script>
function addTip(blockIndex){
    const container = document.getElementById('tipsContainer'+blockIndex);
    const div = document.createElement('div');
    div.className = 'tip-block';
    div.innerHTML = `
        <button type="button" class="remove-tip" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
        <div class="file-input-wrapper">
            <label class="file-input-label">
                <i class="fas fa-image"></i> Choose Image
                <input type="file" name="tip_img_file[${blockIndex}][]" accept="image/*" onchange="previewImage(this)">
            </label>
        </div>
        <input type="text" name="tip_img[${blockIndex}][]" placeholder="Image URL" class="media-url">
        <input type="text" name="tip_english[${blockIndex}][]" placeholder="Tip English">
        <input type="text" name="tip_waray[${blockIndex}][]" placeholder="Tip Waray">
    `;
    container.appendChild(div);
}
function addBlock(){
    const container = document.getElementById('blocksContainer');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'content-block';
    div.innerHTML = `
        <button type="button" class="remove-block" onclick="this.parentElement.remove()"><i class="fas fa-trash-alt"></i></button>
        <h2><i class="fas fa-video"></i> Video</h2>
        <input type="text" name="video_src[]" placeholder="Video Source">
        <div class="file-input-wrapper">
            <label class="file-input-label">
                <i class="fas fa-image"></i> Choose Poster Image
                <input type="file" name="video_poster_file[]" accept="image/*" onchange="previewImage(this)">
            </label>
        </div>
        <input type="text" name="video_poster[]" placeholder="Poster Image" class="media-url">
        <input type="text" name="video_title[]" placeholder="Video Title">
        <input type="text" name="video_subtitle[]" placeholder="Video Subtitle">
        <h2><i class="fas fa-info-circle"></i> Description</h2>
        <input type="text" name="desc_title[]" placeholder="Description Title">
        <textarea name="desc_english[]" rows="3" placeholder="English Description"></textarea>
        <textarea name="desc_waray[]" rows="3" placeholder="Waray Description"></textarea>
        <h2><i class="fas fa-lightbulb"></i> Tips</h2>
        <div id="tipsContainer${index}"></div>
        <button type="button" class="add-tip" onclick="addTip(${index})"><i class="fas fa-plus"></i> Add Tip</button>
        <h2><i class="fas fa-key"></i> Key Point</h2>
        <input type="text" name="key_english[]" placeholder="Key Point English">
        <input type="text" name="key_waray[]" placeholder="Key Point Waray">
    `;
    container.appendChild(div);
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Find the associated URL input field
            const urlInput = input.closest('.tip-block, .content-block').querySelector('.media-url');
            if (urlInput) {
                urlInput.value = e.target.result;
                
                // Create preview image if it doesn't exist
                let preview = urlInput.nextElementSibling;
                if (!preview || !preview.classList.contains('media-preview')) {
                    preview = document.createElement('img');
                    preview.className = 'media-preview';
                    urlInput.parentNode.insertBefore(preview, urlInput.nextSibling);
                }
                preview.src = e.target.result;
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Attach addBlock button
document.querySelector('.add-block').addEventListener('click', addBlock);
</script>

<style>
/* Cybersecurity Admin Styles - Matching the admin panel theme */
.cyber-admin-container {
    max-width: 1000px;
    margin: 0 auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.cyber-admin-container h1 {
    text-align: center;
    color: var(--bgcol);
    margin-bottom: 30px;
    font-size: 2.2rem;
    position: relative;
    padding-bottom: 15px;
}

.cyber-admin-container h1::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background-color: var(--accent-color);
    border-radius: 2px;
}

.cyber-admin-container h2 {
    margin-top: 25px;
    margin-bottom: 15px;
    color: var(--hov);
    font-size: 1.5rem;
    position: relative;
    padding-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.cyber-admin-container h2::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: var(--accent-color);
    border-radius: 2px;
}

.cyber-admin-container input, 
.cyber-admin-container textarea {
    width: 100%;
    padding: 12px 15px;
    margin: 5px 0 15px;
    border: 2px solid #f0f0f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background-color: #f9f9f9;
}

.cyber-admin-container input:focus, 
.cyber-admin-container textarea:focus {
    outline: none;
    border-color: var(--accent-color);
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(163, 193, 173, 0.2);
}

.cyber-admin-container button {
    padding: 12px 20px;
    margin-top: 5px;
    cursor: pointer;
    border: none;
    border-radius: 8px;
    background: var(--bgcol);
    color: #fff;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cyber-admin-container button:hover {
    background: var(--hov);
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

.cyber-admin-container button[type="submit"] {
   background-color: var(--hov);
   color: white;
   padding: 12px;
   text-align: center;
   display: block;
   border-radius: 5px;
   text-decoration: none;
   margin-top: 30px;
   font-weight: 600;
   transition: all 0.3s;
   border: 2px solid transparent;
}

.cyber-admin-container button[type="submit"]:hover {
   background-color: #fff;
   color: var(--hov);
   border: 2px solid var(--hov);
}

.cyber-admin-container .content-block {
    border: 2px solid var(--accent-color);
    padding: 25px;
    margin-bottom: 25px;
    position: relative;
    border-radius: 10px;
    background-color: #f9f9fb;
    transition: all 0.3s ease;
}

.cyber-admin-container .content-block:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.cyber-admin-container .tip-block {
    border: 1px solid var(--accent-color);
    padding: 15px;
    margin-bottom: 15px;
    position: relative;
    border-radius: 8px;
    background-color: #fff;
    transition: all 0.3s ease;
}

.cyber-admin-container .tip-block:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.cyber-admin-container .remove-tip, 
.cyber-admin-container .remove-block {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.cyber-admin-container .remove-tip:hover, 
.cyber-admin-container .remove-block:hover {
    background: #c0392b;
    transform: scale(1.05);
}

.cyber-admin-container .add-tip, 
.cyber-admin-container .add-block {
    margin: 15px 0;
    background: var(--bgcol);
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cyber-admin-container .add-tip:hover, 
.cyber-admin-container .add-block:hover {
    background: var(--hov);
    transform: translateY(-2px);
}

.cyber-admin-container .success-msg {
    background: rgba(37, 131, 0, 0.1);
    color: var(--waray);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
    border: 1px solid var(--waray);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.cyber-admin-container #blocksContainer {
    margin-bottom: 30px;
}

/* File input styling */
.cyber-admin-container .file-input-wrapper {
    position: relative;
    overflow: hidden;
    display: inline-block;
    margin-bottom: 15px;
}

.cyber-admin-container .file-input-wrapper input[type=file] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

.cyber-admin-container .file-input-label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    background: var(--accent-color);
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.cyber-admin-container .file-input-label:hover {
    background: #8ba89a;
}

.cyber-admin-container .media-preview {
    margin-top: 10px;
    max-width: 200px;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .cyber-admin-container {
        padding: 20px;
    }
    
    .cyber-admin-container h1 {
        font-size: 1.8rem;
    }
    
    .cyber-admin-container h2 {
        font-size: 1.3rem;
    }
    
    .cyber-admin-container input, 
    .cyber-admin-container textarea {
        font-size: 14px;
        padding: 10px 12px;
    }
    
    .cyber-admin-container button {
        font-size: 14px;
        padding: 10px 15px;
    }
    
    .cyber-admin-container button[type="submit"] {
        font-size: 16px;
        padding: 12px 20px;
    }
    
    .cyber-admin-container .content-block {
        padding: 15px;
    }
}
</style>