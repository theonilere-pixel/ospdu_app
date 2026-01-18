<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Récupérer le projet par slug
$slug = isset($_GET['slug']) ? sanitize_input($_GET['slug']) : '';

if (empty($slug)) {
    redirect('projets.php');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE slug = ?");
    $stmt->execute([$slug]);
    $project = $stmt->fetch();
    
    if (!$project) {
        redirect('projets.php');
    }
} catch(PDOException $e) {
    redirect('projets.php');
}

$page_title = get_text($project['title_fr'], $project['title_en'], $project['title_sw']);
$page_description = get_text($project['description_fr'], $project['description_en'], $project['description_sw']);

// Récupérer les projets similaires
try {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id != ? ORDER BY created_at DESC LIMIT 3");
    $stmt->execute([$project['id']]);
    $related_projects = $stmt->fetchAll();
} catch(PDOException $e) {
    $related_projects = [];
}

include 'includes/header.php';
?>

<!-- Projet principal -->
<article class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête du projet -->
        <header class="mb-8 animate-on-scroll">
            <div class="text-sm text-primary-blue mb-4">
                <a href="projets.php" class="hover:text-primary-blue-dark">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <?php echo get_current_language() == 'fr' ? 'Retour aux projets' : (get_current_language() == 'en' ? 'Back to projects' : 'Rudi kwenye miradi'); ?>
                </a>
            </div>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                <div class="flex-1">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                        <span class="inline-flex items-center px-3 py-1 rounded-full font-medium <?php 
                            echo $project['status'] === 'active' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                ($project['status'] === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'); ?>">
                            <i class="fas fa-<?php echo $project['status'] === 'active' ? 'play-circle' : ($project['status'] === 'completed' ? 'check-circle' : 'clock'); ?> mr-2"></i>
                            <?php 
                            if (get_current_language() == 'fr') {
                                echo $project['status'] === 'active' ? 'Projet actif' : ($project['status'] === 'completed' ? 'Projet terminé' : 'Projet planifié');
                            } elseif (get_current_language() == 'en') {
                                echo ucfirst($project['status']) . ' project';
                            } else {
                                echo $project['status'] === 'active' ? 'Mradi unaofanya kazi' : ($project['status'] === 'completed' ? 'Mradi uliokamilika' : 'Mradi uliopangwa');
                            }
                            ?>
                        </span>
                        
                        <?php if ($project['start_date']): ?>
                            <span class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <?php echo get_current_language() == 'fr' ? 'Début:' : (get_current_language() == 'en' ? 'Start:' : 'Mwanzo:'); ?>
                                <?php echo format_date($project['start_date']); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($project['end_date']): ?>
                            <span class="flex items-center">
                                <i class="fas fa-flag-checkered mr-2"></i>
                                <?php echo get_current_language() == 'fr' ? 'Fin:' : (get_current_language() == 'en' ? 'End:' : 'Mwisho:'); ?>
                                <?php echo format_date($project['end_date']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Image du projet -->
        <?php if ($project['featured_image']): ?>
            <div class="mb-8 animate-on-scroll">
                <img src="<?php echo get_image($project['featured_image'], 'assets/images/project-default.jpg'); ?>" 
                     alt="<?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>" 
                     class="w-full h-96 object-cover rounded-lg shadow-lg">
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <div class="prose prose-lg dark:prose-invert max-w-none animate-on-scroll">
                    <h2><?php echo get_current_language() == 'fr' ? 'Description du projet' : (get_current_language() == 'en' ? 'Project description' : 'Maelezo ya mradi'); ?></h2>
                    <?php echo nl2br(get_text($project['description_fr'], $project['description_en'], $project['description_sw'])); ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 animate-on-scroll">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <?php echo get_current_language() == 'fr' ? 'Informations du projet' : (get_current_language() == 'en' ? 'Project information' : 'Taarifa za mradi'); ?>
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                <?php echo get_current_language() == 'fr' ? 'Statut' : (get_current_language() == 'en' ? 'Status' : 'Hali'); ?>
                            </dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                <?php 
                                if (get_current_language() == 'fr') {
                                    echo $project['status'] === 'active' ? 'Actif' : ($project['status'] === 'completed' ? 'Terminé' : 'Planifié');
                                } elseif (get_current_language() == 'en') {
                                    echo ucfirst($project['status']);
                                } else {
                                    echo $project['status'] === 'active' ? 'Inafanya kazi' : ($project['status'] === 'completed' ? 'Imekamilika' : 'Imepangwa');
                                }
                                ?>
                            </dd>
                        </div>
                        
                        <?php if ($project['start_date']): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    <?php echo get_current_language() == 'fr' ? 'Date de début' : (get_current_language() == 'en' ? 'Start date' : 'Tarehe ya kuanza'); ?>
                                </dt>
                                <dd class="text-sm text-gray-900 dark:text-white">
                                    <?php echo format_date($project['start_date'], 'd F Y'); ?>
                                </dd>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($project['end_date']): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    <?php echo get_current_language() == 'fr' ? 'Date de fin' : (get_current_language() == 'en' ? 'End date' : 'Tarehe ya mwisho'); ?>
                                </dt>
                                <dd class="text-sm text-gray-900 dark:text-white">
                                    <?php echo format_date($project['end_date'], 'd F Y'); ?>
                                </dd>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                <?php echo get_current_language() == 'fr' ? 'Créé le' : (get_current_language() == 'en' ? 'Created on' : 'Imeundwa mnamo'); ?>
                            </dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                <?php echo format_date($project['created_at'], 'd F Y'); ?>
                            </dd>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">
                            <?php echo get_current_language() == 'fr' ? 'Soutenir ce projet' : (get_current_language() == 'en' ? 'Support this project' : 'Unga mkono mradi huu'); ?>
                        </h4>
                        <div class="space-y-2">
                            <a href="donation.php" class="w-full btn-primary text-center">
                                <i class="fas fa-heart mr-2"></i>
                                <?php echo get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make a donation' : 'Toa mchango'); ?>
                            </a>
                            <a href="s-impliquer.php" class="w-full btn-secondary text-center">
                                <i class="fas fa-hands-helping mr-2"></i>
                                <?php echo get_current_language() == 'fr' ? 'Devenir bénévole' : (get_current_language() == 'en' ? 'Become volunteer' : 'Kuwa mtoaji huduma'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partage social -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 animate-on-scroll">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Partager ce projet' : (get_current_language() == 'en' ? 'Share this project' : 'Shiriki mradi huu'); ?>
            </h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/projets-details.php?slug=' . $project['slug']); ?>" 
                   target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/projets-details.php?slug=' . $project['slug']); ?>&text=<?php echo urlencode($page_title); ?>" 
                   target="_blank" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition-colors duration-300">
                    <i class="fab fa-twitter mr-2"></i>Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(SITE_URL . '/projets-details.php?slug=' . $project['slug']); ?>" 
                   target="_blank" class="bg-blue-800 text-white px-4 py-2 rounded-lg hover:bg-blue-900 transition-colors duration-300">
                    <i class="fab fa-linkedin-in mr-2"></i>LinkedIn
                </a>
                <button onclick="copyToClipboard()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-300">
                    <i class="fas fa-link mr-2"></i>
                    <?php echo get_current_language() == 'fr' ? 'Copier le lien' : (get_current_language() == 'en' ? 'Copy link' : 'Nakili kiungo'); ?>
                </button>
            </div>
        </div>
    </div>
</article>

<!-- Projets similaires -->
<?php if (!empty($related_projects)): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Autres projets' : (get_current_language() == 'en' ? 'Other projects' : 'Miradi mingine'); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($related_projects as $related): ?>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                    <img src="<?php echo get_image($related['featured_image'], 'assets/images/project-default.jpg'); ?>" 
                         alt="<?php echo get_text($related['title_fr'], $related['title_en'], $related['title_sw']); ?>" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mb-3 <?php 
                            echo $related['status'] === 'active' ? 'bg-blue-100 text-blue-800' : 
                                ($related['status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                                'bg-yellow-100 text-yellow-800'); ?>">
                            <?php echo ucfirst($related['status']); ?>
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <a href="projets-details.php?slug=<?php echo $related['slug']; ?>" class="hover:text-primary-blue">
                                <?php echo get_text($related['title_fr'], $related['title_en'], $related['title_sw']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php echo substr(get_text($related['description_fr'], $related['description_en'], $related['description_sw']), 0, 100) . '...'; ?>
                        </p>
                        <a href="projets-details.php?slug=<?php echo $related['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                            <?php echo get_current_language() == 'fr' ? 'En savoir plus' : (get_current_language() == 'en' ? 'Learn more' : 'Jifunze zaidi'); ?>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        showNotification('<?php echo get_current_language() == "fr" ? "Lien copié dans le presse-papiers" : (get_current_language() == "en" ? "Link copied to clipboard" : "Kiungo kimenakiliwa kwenye clipboard"); ?>', 'success');
    }, function(err) {
        console.error('Erreur lors de la copie: ', err);
        showNotification('<?php echo get_current_language() == "fr" ? "Erreur lors de la copie" : (get_current_language() == "en" ? "Error copying link" : "Hitilafu wakati wa kunakili"); ?>', 'error');
    });
}
</script>

<?php include 'includes/footer.php'; ?>