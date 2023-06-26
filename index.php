<!DOCTYPE html>
<html>
<head>
    <title>Subir y categorizar archivos PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="mb-4">Subir y categorizar archivos PDF</h1>
            <form id="uploadForm" enctype="multipart/form-data" method="POST">
                <div class="form-group">
                    <label for="pdfFiles">Selecciona uno o varios archivos PDF:</label>
                    <input type="file" class="form-control-file" id="pdfFiles" name="pdfFiles[]" accept=".pdf" multiple required>
                </div>

                <div class="form-group">
                    <label for="keyword">Palabra clave de categorización:</label>
                    <input type="text" class="form-control" id="keyword" name="keyword" required>
                </div>

                <button type="submit" class="btn btn-primary">Subir archivos</button>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $keyword = $_POST['keyword'];
                $files = $_FILES['pdfFiles'];
                $folderPath = 'pdfs/';
                $matchedFiles = [];

                foreach ($files['tmp_name'] as $key => $tmpName) {
                    $fileName = $files['name'][$key];
                    $fileTmp = $files['tmp_name'][$key];

                    if (pathinfo($fileName, PATHINFO_EXTENSION) === 'pdf') {
                        $pdfContent = file_get_contents($fileTmp);
                        if (strpos($pdfContent, $keyword) !== false) {
                            move_uploaded_file($fileTmp, $folderPath . $fileName);
                            $matchedFiles[] = $fileName;
                        }
                    }
                }

                if (!empty($matchedFiles)) {
                    $message = 'Los archivos PDF se han analizado y los que contienen la palabra clave se han guardado en la carpeta "pdfs".';
                }
            }
            ?>

            <?php if (isset($message)) : ?>
                <div id="message" class="mt-3 alert alert-success"><?php echo $message; ?></div>
                <script>
                    setTimeout(function() {
                        document.getElementById('message').style.display = 'none';
                    }, 3000);
                </script>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
