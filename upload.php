<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = $_POST['keyword'];
    $uploadsDir = 'uploads/' . $keyword;

    if (!file_exists($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    $uploadedFiles = $_FILES['pdfFiles'];

    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        $filename = $uploadedFiles['name'][$i];
        $tmpFilePath = $uploadedFiles['tmp_name'][$i];
        $newFilePath = $uploadsDir . '/' . $filename;

        move_uploaded_file($tmpFilePath, $newFilePath);
    }

    echo 'Archivos subidos y categorizados correctamente.';
} else {
    echo 'Error en la solicitud.';
}
?>
