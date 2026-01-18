<?php

define('SITE_NAME', 'Admin ISTDR-V');
define('SITE_URL', 'https://app.istdrv-ac.org');
define('UPLOAD_PATH', 'uploads/');
define('MAX_FILE_SIZE', 45 * 1024 * 1024); // 5MB


//define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'ico', 'webp']);

define('ALLOWED_IMAG_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'ico', 'webp']);
define('ALLOWED_VIDEO_TYPES', ['mp4', 'mov', 'avi', 'webm']);
define('ALLOWED_DOCUMENT_TYPES', ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']);
define('ALLOWED_IMAGE_TYPES', array_merge(
    ALLOWED_IMAG_TYPES,
    ALLOWED_VIDEO_TYPES,
    ALLOWED_DOCUMENT_TYPES
));


require_once 'database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($pdo) {
    $database->createTables();
}

// Fonctions utilitaires
function getTableIcon($tableName) {
    $icons = [
        'user' => 'fas fa-users',
        'categories' => 'fas fa-tags',
        'products' => 'fas fa-box',
        'orders' => 'fas fa-shopping-cart',
        'customers' => 'fas fa-user-friends',
        'settings' => 'fas fa-cog',
        'reports' => 'fas fa-chart-bar',
        'default' => 'fas fa-table'
    ];
    
    return $icons[$tableName] ?? $icons['default'];
}

function formatTableName($tableName) {
    return ucfirst(str_replace('_', ' ', $tableName));
}

function uploadImage($file, $uploadDir = 'uploads/') {
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
    
    // Vérifier le type de fichier
    if (!in_array($fileType, ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'message' => 'Type de fichier non autorisé'];
    }
    
    // Vérifier la taille
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'Fichier trop volumineux'];
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $fileName, 'path' => $targetPath];
    }
    
    return ['success' => false, 'message' => 'Erreur lors de l\'upload'];
}

function deleteImage($filename, $uploadDir = 'uploads/') {
    $filepath = $uploadDir . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
        return true;
    }
    return false;
}
?>