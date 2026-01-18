<?php
session_start();
require_once 'config/config.php';
require_once 'auth/session.php';

if (!isLoggedIn()) {
    header('Location: auth/login.php');
    exit;
}

$user = getUserData();
$page = $_GET['page'] ?? 'dashboard';
$table = $_GET['table'] ?? '';
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? '';

// Pages autorisées
$allowed_pages = ['dashboard', 'table-manager', 'profile', 'logout'];

if ($page === 'logout') {
    logout();
}

if (!in_array($page, $allowed_pages) && empty($table)) {
    include '404.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISTDRV - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        },
                        dark: {
                            100: '#1f2937',
                            200: '#374151',
                            300: '#4b5563',
                            400: '#6b7280',
                            500: '#9ca3af',
                            600: '#d1d5db',
                            700: '#e5e7eb',
                            800: '#1a202c',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(4px);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .toggle-switch {
            transition: all 0.3s ease;
        }
        .search-bar {
            backdrop-filter: blur(10px);
        }
        .modal-overlay {
            backdrop-filter: blur(5px);
        }
        .image-preview {
            transition: all 0.3s ease;
        }
        .image-preview:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-900 text-white overflow-hidden">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <?php include 'includes/header.php'; ?>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-gray-900 px-6 py-8">
                <?php
                if (!empty($table)) {
                    include 'includes/table-manager.php';
                } else {
                    switch($page) {
                        case 'dashboard':
                            include 'pages/dashboard.php';
                            break;
                        case 'profile':
                            include 'pages/profile.php';
                            break;
                        default:
                            include '404.php';
                    }
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-50 modal-overlay hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-95">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-white">Profil utilisateur</h3>
                    <button onclick="closeProfileModal()" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-2xl text-white"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-white"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                    <p class="text-gray-400"><?php echo htmlspecialchars($user['email']); ?></p>
                    <span class="inline-block px-3 py-1 bg-green-600 text-white text-sm rounded-full mt-2">
                        <?php echo ucfirst($user['role']); ?>
                    </span>
                </div>
                
                <div class="space-y-3">
                    <button onclick="window.location.href='?page=profile'" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>Modifier le profil
                    </button>
                    <button onclick="window.location.href='?page=logout'" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>