<?php
// Récupérer les statistiques
$stats = [];

// Compter les utilisateurs
$stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user");
$stmt->execute();
$stats['user'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Compter les actualités (en supposant qu'il y a une table actualites)
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM actualites");
    $stmt->execute();
    $stats['actualites'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (Exception $e) {
    $stats['actualites'] = 0;
}

// Compter les événements
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM events");
    $stmt->execute();
    $stats['events'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (Exception $e) {
    $stats['events'] = 0;
}

// Compter les étudiants
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM etudiants");
    $stmt->execute();
    $stats['etudiants'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (Exception $e) {
    $stats['etudiants'] = 0;
}

// Récupérer les dernières actualités
$actualites = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM actualites ORDER BY created_at DESC LIMIT 10");
    $stmt->execute();
    $actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $actualites = [];
}
?>

<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Tableau de bord</h1>
        <p class="text-gray-400">Gérez tous les contenu de votre site web</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Utilisateurs -->
        <div class="bg-gray-800 rounded-2xl p-6 stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Utilisateurs</h3>
                    <p class="text-2xl font-bold text-white"><?php echo $stats['user']; ?></p>
                </div>
            </div>
        </div>

        <!-- Actualités -->
        <div class="bg-gray-800 rounded-2xl p-6 stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-newspaper text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Actualités</h3>
                    <p class="text-2xl font-bold text-white"><?php echo $stats['actualites']; ?></p>
                </div>
            </div>
        </div>

        <!-- Événements -->
        <div class="bg-gray-800 rounded-2xl p-6 stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-calendar-alt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Événements</h3>
                    <p class="text-2xl font-bold text-white"><?php echo $stats['events']; ?></p>
                </div>
            </div>
        </div>

        <!-- Étudiants -->
        <div class="bg-gray-800 rounded-2xl p-6 stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Étudiants</h3>
                    <p class="text-2xl font-bold text-white"><?php echo $stats['etudiants']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-gray-800 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-700">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Actualités publiées</h2>
                <button onclick="window.location.href='?table=actualites&action=add'" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Ajouter
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Table Controls -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <select class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-gray-400">entries per page</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400">Search:</span>
                    <input type="text" id="tableSearch" placeholder="" class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white w-64">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">
                                Titre
                                <i class="fas fa-sort ml-2"></i>
                            </th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">
                                Extrait
                                <i class="fas fa-sort ml-2"></i>
                            </th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Date</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Statut</th>
                            <th class="text-left py-3 px-4 text-gray-400 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($actualites)): ?>
                            <!-- Exemples par défaut -->
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition-colors">
                                <td class="py-4 px-4 text-white">Célébration de la journée de l'étudiant 2025</td>
                                <td class="py-4 px-4 text-gray-400">Une journée festive et inspirante !</td>
                                <td class="py-4 px-4 text-gray-400">13/07/2025</td>
                                <td class="py-4 px-4">
                                    <span class="bg-green-600 text-white px-2 py-1 rounded-full text-sm">Publié</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition-colors">
                                <td class="py-4 px-4 text-white">Conférence annuelle sur la</td>
                                <td class="py-4 px-4 text-gray-400">Retour sur la conférence</td>
                                <td class="py-4 px-4 text-gray-400">13/07/2025</td>
                                <td class="py-4 px-4">
                                    <span class="bg-green-600 text-white px-2 py-1 rounded-full text-sm">Publié</span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <button class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($actualites as $actualite): ?>
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition-colors">
                                    <td class="py-4 px-4 text-white"><?php echo htmlspecialchars($actualite['title'] ?? $actualite['name'] ?? 'N/A'); ?></td>
                                    <td class="py-4 px-4 text-gray-400"><?php echo htmlspecialchars(substr($actualite['description'] ?? $actualite['content'] ?? '', 0, 50)) . '...'; ?></td>
                                    <td class="py-4 px-4 text-gray-400"><?php echo date('d/m/Y', strtotime($actualite['created_at'])); ?></td>
                                    <td class="py-4 px-4">
                                        <span class="bg-green-600 text-white px-2 py-1 rounded-full text-sm">
                                            <?php echo ucfirst($actualite['status'] ?? 'Actif'); ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-2">
                                            <button onclick="window.location.href='?table=actualites&action=edit&id=<?php echo $actualite['id']; ?>'" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="confirmDelete('actualites', <?php echo $actualite['id']; ?>)" 
                                                    class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition-colors">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>