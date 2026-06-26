<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];

    $data = file_get_contents("data.json");
    $modules = json_decode($data, true);

    // Filter out yung module na may title na match
    $modules = array_filter($modules, function($item) use ($title) {
        return $item['title'] !== $title;
    });

    // Reindex array para hindi sira yung JSON
    $modules = array_values($modules);

    file_put_contents("data.json", json_encode($modules, JSON_PRETTY_PRINT));

    header("Location: adminpanel.php?page=modules"); // balik sa main page
    exit();
}
?>
