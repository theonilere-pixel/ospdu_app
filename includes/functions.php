<?php
/**
 * Fonctions utilitaires pour OSPDU
 */

/**
 * Fonction pour nettoyer les données d'entrée
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Fonction pour générer un slug à partir d'un titre
 */
function generate_slug($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

/**
 * Fonction pour vérifier si l'utilisateur est connecté
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Fonction pour vérifier si l'utilisateur est admin
 */
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Fonction pour rediriger
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Fonction pour obtenir la langue actuelle
 */
function get_current_language() {
    return isset($_SESSION['language']) ? $_SESSION['language'] : 'fr';
}

/**
 * Fonction pour obtenir le texte dans la langue actuelle
 */
function get_text($text_fr, $text_en = '', $text_sw = '') {
    $lang = get_current_language();
    switch($lang) {
        case 'en':
            return !empty($text_en) ? $text_en : $text_fr;
        case 'sw':
            return !empty($text_sw) ? $text_sw : $text_fr;
        default:
            return $text_fr;
    }
}

/**
 * Fonction pour formater la date
 */
function format_date($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

/**
 * Fonction pour obtenir l'image avec fallback
 */
function get_image($image_path, $default = 'assets/images/default.jpg') {
    if (!empty($image_path) && file_exists($image_path)) {
        return $image_path;
    }
    return $default;
}

/**
 * Fonction pour obtenir les paramètres du site
 */
function get_site_setting($key, $default = '') {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT setting_value FROM site_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    } catch(PDOException $e) {
        return $default;
    }
}

/**
 * Fonction pour mettre à jour les paramètres du site
 */
function update_site_setting($key, $value) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("UPDATE site_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    } catch(PDOException $e) {
        return false;
    }
}

/**
 * Fonction pour uploader un fichier
 */
function upload_file($file, $directory = 'admin/uploads/') {
    if (!isset($file['error']) || is_array($file['error'])) {
        return false;
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return false;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return false;
        default:
            return false;
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        return false;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed_types = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    $ext = array_search($mime, $allowed_types, true);
    if ($ext === false) {
        return false;
    }

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $ext);
    $filepath = $directory . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        return false;
    }

    return $filepath;
}

/**
 * Fonction pour paginer les résultats
 */
function paginate($total_records, $records_per_page = 10, $current_page = 1) {
    $total_pages = ceil($total_records / $records_per_page);
    $offset = ($current_page - 1) * $records_per_page;
    
    return [
        'total_pages' => $total_pages,
        'current_page' => $current_page,
        'offset' => $offset,
        'limit' => $records_per_page,
        'has_prev' => $current_page > 1,
        'has_next' => $current_page < $total_pages
    ];
}

/**
 * Fonction pour envoyer un email
 */
function send_email($to, $subject, $message, $from = null) {
    if ($from === null) {
        $from = get_site_setting('contact_email', 'noreply@ospdu.org');
    }
    
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    return mail($to, $subject, $message, $headers);
}

/**
 * Fonction pour générer un token CSRF
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Fonction pour vérifier le token CSRF
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>