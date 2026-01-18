<?php
require_once '../config/config.php';

// 📁 Dossier de destination
$uploadDir = __DIR__ . '/../uploads/images-news-events/';
$webPath   = SITE_URL . '/uploads/images-news-events/';

// 📦 Créer le dossier si inexistant
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 📤 Clé du fichier : SunEditor utilise "file-0"
$fileKey = 'file-0';

if (!empty($_FILES[$fileKey]['name'])) {
    $file = $_FILES[$fileKey];

    // 🔒 Limite de taille
    if ($file['size'] > 2 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['errorMessage' => 'Image trop volumineuse (max 2 Mo).']);
        exit;
    }

    // 🔒 Types autorisés
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['errorMessage' => 'Format d\'image non autorisé.']);
        exit;
    }

    // 🧼 Nettoyer le nom
    $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // ✅ Réponse exacte que SunEditor attend pour afficher l'image
        echo json_encode([
            'result' => [
                [
                    'url' => $webPath . $filename,
                    'name' => $filename,
                    'size' => $file['size']
                ]
            ],
            'success' => true
        ]);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['errorMessage' => 'Erreur lors de l’envoi du fichier.']);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['errorMessage' => 'Aucun fichier reçu.']);
    exit;
}
