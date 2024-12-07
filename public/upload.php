<?php

require_once '../vendor/autoload.php'; // Composer autoload
require_once '../src/Parser.php'; // Include the parser class

use HomeownerParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check file type
    if ($file['type'] !== 'text/csv') {
        die('<div class="alert alert-danger">Error: Only CSV files are allowed.</div>');
    }

    // Save the uploaded file to the data directory
    $uploadPath = '../data/' . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        die('<div class="alert alert-danger">Error: File upload failed.</div>');
    }

    // Parse the CSV
    $parser = new Parser();
    $people = $parser->parseCsv($uploadPath);

    // Display parsed results
    echo '<div class="container mt-5">';
    echo '<h1 class="text-center mb-4">Parsed Data</h1>';
    echo '<pre>' . print_r($people, true) . '</pre>';
    echo '<a href="index.php" class="btn btn-secondary mt-3">Back to Upload</a>';
    echo '</div>';
}
