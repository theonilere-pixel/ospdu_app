<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Nos Projets' : (get_current_language() == 'en' ? 'Our Projects' : 'Miradi Yetu');
$page_description = get_current_language() == 'fr' ? 'Découvrez nos projets en cours et réalisés' : (get_current_language() == 'en' ? 'Discover our ongoing and completed projects' : 'Gundua miradi yetu inayoendelea na iliyokamilika');

// Filtrage par statut
$status = isset($_GET['status']) ? sanitize_input($_GET['status']) : 'all';
$statuses = ['all', 'active', 'completed', 'planned'];

if (!in_array($status, $statuses)) {
    $status = 'all';
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Construire la requête selon le statut
$where_clause = "WHERE 1=1";
$params = [];

if ($status !== 'all') {
    $where_clause .= " AND status = ?";
    $params[] = $status;
}

// Récupérer le nombre total de projets
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM projects " . $where_clause);
    $stmt->execute($params);
    $total_projects = $stmt->fetch()['total'];
    $total_pages = ceil($total_projects / $per_page);
} catch(PDOException $e) {
    $total_projects = 0;
    $total_pages = 0;
}

// Récupérer les projets
try {
    $stmt = $pdo->prepare("SELECT * FROM projects " . $where_clause . " ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute(array_merge($params, [$per_page, $offset]));
    $projects = $stmt->fetchAll();
} catch(PDOException $e) {
    $projects = [];
}

// Récupérer les statistiques
try {
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM projects GROUP BY status");
    $stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch(PDOException $e) {
    $stats = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Nos Projets' : (get_current_language() == 'en' ? 'Our Projects' : 'Miradi Yetu'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Découvrez nos projets qui transforment des vies et construisent un avenir meilleur pour les communautés vulnérables.";
            } elseif (get_current_language() == 'en') {
                echo "Discover our projects that transform lives and build a better future for vulnerable communities.";
            } else {
                echo "Gundua miradi yetu inayobadilisha maisha na kujenga mustakabali mzuri kwa jamii zilizo hatarini.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Statistiques -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">
                    <?php echo isset($stats['active']) ? $stats['active'] : 0; ?>
                </div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Projets actifs' : (get_current_language() == 'en' ? 'Active projects' : 'Miradi inayofanya kazi'); ?>
                </div>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-green-600 mb-2">
                    <?php echo isset($stats['completed']) ? $stats['completed'] : 0; ?>
                </div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Projets terminés' : (get_current_language() == 'en' ? 'Completed projects' : 'Miradi iliyokamilika'); ?>
                </div>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-yellow-600 mb-2">
                    <?php echo isset($stats['planned']) ? $stats['planned'] : 0; ?>
                </div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Projets planifiés' : (get_current_language() == 'en' ? 'Planned projects' : 'Miradi iliyopangwa'); ?>
                </div>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-purple-600 mb-2">
                    <?php echo array_sum($stats); ?>
                </div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Total projets' : (get_current_language() == 'en' ? 'Total projects' : 'Jumla ya miradi'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Filtres -->
<section class="py-8 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <a href="?status=all" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $status === 'all' ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <?php echo get_current_language() == 'fr' ? 'Tous' : (get_current_language() == 'en' ? 'All' : 'Yote'); ?>
            </a>
            <a href="?status=active" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $status === 'active' ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-play-circle mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Actifs' : (get_current_language() == 'en' ? 'Active' : 'Inayofanya kazi'); ?>
            </a>
            <a href="?status=completed" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $status === 'completed' ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-check-circle mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Terminés' : (get_current_language() == 'en' ? 'Completed' : 'Zilizokamilika'); ?>
            </a>
            <a href="?status=planned" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $status === 'planned' ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-clock mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Planifiés' : (get_current_language() == 'en' ? 'Planned' : 'Zilizopangwa'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Section Projets -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($projects)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                        <img src="<?php echo get_image($project['featured_image'], 'assets/images/project-default.jpg'); ?>" 
                             alt="<?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>" 
                             class="w-full h-48 object-cover">
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php 
                                    echo $project['status'] === 'active' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                        ($project['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'); ?>">
                                    <i class="fas fa-<?php echo $project['status'] === 'active' ? 'play-circle' : ($project['status'] === 'completed' ? 'check-circle' : 'clock'); ?> mr-1"></i>
                                    <?php 
                                    if (get_current_language() == 'fr') {
                                        echo $project['status'] === 'active' ? 'Actif' : ($project['status'] === 'completed' ? 'Terminé' : 'Planifié');
                                    } elseif (get_current_language() == 'en') {
                                        echo ucfirst($project['status']);
                                    } else {
                                        echo $project['status'] === 'active' ? 'Inafanya kazi' : ($project['status'] === 'completed' ? 'Imekamilika' : 'Imepangwa');
                                    }
                                    ?>
                                </span>
                                
                                <?php if ($project['start_date']): ?>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php echo format_date($project['start_date']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                <?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>
                            </h3>
                            
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                <?php echo substr(get_text($project['description_fr'], $project['description_en'], $project['description_sw']), 0, 150) . '...'; ?>
                            </p>
                            
                            <?php if ($project['start_date'] && $project['end_date']): ?>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?php echo format_date($project['start_date']); ?> - <?php echo format_date($project['end_date']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <a href="projets-details.php?slug=<?php echo $project['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                                <?php echo get_current_language() == 'fr' ? 'En savoir plus' : (get_current_language() == 'en' ? 'Learn more' : 'Jifunze zaidi'); ?>
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-12 flex justify-center animate-on-scroll">
                    <nav class="flex items-center space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?status=<?php echo $status; ?>&page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?status=<?php echo $status; ?>&page=<?php echo $i; ?>" class="px-3 py-2 <?php echo $i === $page ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'; ?> border border-gray-300 dark:border-gray-600 rounded-lg">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?status=<?php echo $status; ?>&page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-project-diagram text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    <?php echo get_current_language() == 'fr' ? 'Aucun projet disponible' : (get_current_language() == 'en' ? 'No projects available' : 'Hakuna miradi iliyopatikana'); ?>
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    <?php echo get_current_language() == 'fr' ? 'Les projets seront bientôt disponibles.' : (get_current_language() == 'en' ? 'Projects will be available soon.' : 'Miradi itapatikana hivi karibuni.'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Section Appel à l'action -->
<section class="py-16 hero-gradient">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                <?php echo get_current_language() == 'fr' ? 'Soutenez nos projets' : (get_current_language() == 'en' ? 'Support our projects' : 'Unga mkono miradi yetu'); ?>
            </h2>
            <p class="text-xl text-white mb-8">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Votre soutien nous permet de réaliser des projets qui transforment des vies et construisent un avenir meilleur.";
                } elseif (get_current_language() == 'en') {
                    echo "Your support enables us to carry out projects that transform lives and build a better future.";
                } else {
                    echo "Msaada wako unatuwezesha kutekeleza miradi inayobadilisha maisha na kujenga mustakabali mzuri.";
                }
                ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="donation.php" class="bg-white text-primary-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                    <?php echo get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make a donation' : 'Toa mchango'); ?>
                </a>
                <a href="s-impliquer.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-blue transition-all duration-300">
                    <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get involved' : 'Jiunge nasi'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>