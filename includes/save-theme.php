<?php
require_once '../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['theme']) && in_array($input['theme'], ['light', 'dark'])) {
        $_SESSION['theme'] = $input['theme'];
        
        // Sauvegarder en base de données si l'utilisateur est connecté
        if (is_logged_in()) {
            update_site_setting('dark_mode', $input['theme'] === 'dark' ? '1' : '0');
        }
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Thème non valide']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?>