<?php
/**
 * Configuration de la base de données
 * OSPDU - Organe Solidaire pour la Protection Sociale et le Développement Durable
 */

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'ospduorg_ospd11');
define('DB_USER', 'ospduorg_ospd11');
define('DB_PASS', 'ABevGFVWQxcHEG6fuLAd');

// Tentative de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Configuration générale du site
define('SITE_URL', 'http://ospdurdc.ospdu.org');
define('ADMIN_URL', SITE_URL . '/admin');
define('UPLOAD_PATH', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Démarrage de la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>