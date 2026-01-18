<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: auth/login.php');
        exit;
    }
}

function getUserData() {
    if (!isLoggedIn()) {
        return null;
    }
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function logout() {
    session_destroy();
    header('Location: auth/login.php');
    exit;
}

function checkPermission($requiredRole = 'user') {
    $user = getUserData();
    if (!$user) {
        return false;
    }
    
    if ($requiredRole === 'admin' && $user['role'] !== 'admin') {
        return false;
    }
    
    return true;
}
?>