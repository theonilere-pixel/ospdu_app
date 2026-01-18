<?php
global $database, $page, $table;

// Récupérer les tables de la base de données
$tables = $database->getAllTables();

// Configuration des icônes pour chaque table
$tableIcons = [
    'user' => ['icon' => 'fas fa-users', 'color' => 'bg-blue-600'],
    'carousel' => ['icon' => 'fas fa-images', 'color' => 'bg-indigo-600'],
    'contacts' => ['icon' => 'fas fa-address-book', 'color' => 'bg-pink-600'],
    'event_registrations' => ['icon' => 'fas fa-calendar-check', 'color' => 'bg-teal-600'],
    'events' => ['icon' => 'fas fa-calendar-alt', 'color' => 'bg-cyan-600'],
    'gallery' => ['icon' => 'fas fa-image', 'color' => 'bg-yellow-600'],
    'messages' => ['icon' => 'fas fa-envelope', 'color' => 'bg-red-600'],
    'news' => ['icon' => 'fas fa-newspaper', 'color' => 'bg-gray-600'],
    'actualites' => ['icon' => 'fas fa-newspaper', 'color' => 'bg-green-600'],
    'etudiants' => ['icon' => 'fas fa-graduation-cap', 'color' => 'bg-orange-600'],
    'default' => ['icon' => 'fas fa-table', 'color' => 'bg-gray-600']
];
?>

<div id="sidebar" class="bg-gray-800 text-white w-64 transition-all duration-300 ease-in-out overflow-y-auto">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-700">
        <div class="flex items-center">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-chart-bar text-white"></i>
            </div>
            <div class="sidebar-text">
                <h1 class="text-lg font-bold">ISTDR DU VOLCAN</h1>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
        <!-- Dashboard -->
        <a href="index.php?page=dashboard" class="flex items-center px-6 py-3 sidebar-item <?php echo ($page === 'dashboard') ? 'bg-blue-600 border-r-4 border-blue-400' : ''; ?>">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-chart-line text-white text-sm"></i>
            </div>
            <span class="sidebar-text font-medium">Tableau de bord</span>
        </a>

        <!-- Gestion des utilisateurs (admin seulement) -->
        <?php if (checkPermission('admin')): ?>
            <a href="index.php?table=users" class="flex items-center px-6 py-3 sidebar-item <?php echo ($table === 'users') ? 'bg-blue-600 border-r-4 border-blue-400' : ''; ?>">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
                <span class="sidebar-text font-medium">Créer un Utilisateur</span>
            </a>
        <?php endif; ?>

        <!-- Séparateur -->
        <div class="border-t border-gray-900 my-4"></div>
        <!-- Tables dynamiques -->
        <?php foreach ($tables as $tableName): ?>
            <?php if ($tableName !== 'user'): // Les utilisateurs ont un traitement spécial 
            ?>
                <?php
                $iconConfig = $tableIcons[$tableName] ?? $tableIcons['default'];
                $isActive = ($table === $tableName);
                ?>
                <a href="index.php?table=<?php echo $tableName; ?>"
                    class="flex items-center px-6 py-3 sidebar-item <?php echo $isActive ? 'bg-blue-600 border-r-4 border-blue-400' : ''; ?>">
                    <div class="w-8 h-8 <?php echo $iconConfig['color']; ?> rounded-lg flex items-center justify-center mr-3">
                        <i class="<?php echo $iconConfig['icon']; ?> text-white text-sm"></i>
                    </div>
                    <span class="sidebar-text font-medium"><?php echo ucfirst(str_replace('_', ' ', $tableName)); ?></span>
                    <i class="fas fa-chevron-down ml-auto sidebar-text transition-transform duration-300"></i>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>

    <!-- Profil utilisateur en bas -->
    <div class="bottom-0 left-0 right-0 p-6 border-t border-gray-700" style="width: 18%; position:absolute">
        <div class="flex items-center cursor-pointer bg-gray-600 hover:bg-gray-700 rounded-lg p-2 transition-colors" onclick="openProfileModal()">
                        <div class="sidebar-text">
                <p class="font-medium"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
                <p class="text-sm text-gray-400"><?php echo ucfirst($user['role']); ?></p>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="sidebarToggle" class="absolute -right-3 top-20 bg-gray-800 border-2 border-gray-600 rounded-full w-6 h-6 flex items-center justify-center hover:bg-gray-700 transition-colors">
        <i class="fas fa-chevron-left text-white text-xs"></i>
    </button>
</div>