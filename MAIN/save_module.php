<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("data.json");
    $modules = json_decode($data, true);

    $newModule = [
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "video_url" => $_POST['video_url'],
        "icon" => $_POST['icon'],
        "modules" => intval($_POST['modules'])
    ];

    $modules[] = $newModule;

    file_put_contents("data.json", json_encode($modules, JSON_PRETTY_PRINT));

    header("Location: adminpanel.php?page=modules");
    exit();
}
?>
