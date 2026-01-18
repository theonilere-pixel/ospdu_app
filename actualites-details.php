<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Récupérer l'article par slug
$slug = isset($_GET['slug']) ? sanitize_input($_GET['slug']) : '';

if (empty($slug)) {
    redirect('actualites.php');
}

try {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $article = $stmt->fetch();
    
    if (!$article) {
        redirect('actualites.php');
    }
} catch(PDOException $e) {
    redirect('actualites.php');
}

$page_title = get_text($article['title_fr'], $article['title_en'], $article['title_sw']);
$page_description = get_text($article['excerpt_fr'], $article['excerpt_en'], $article['excerpt_sw']);

// Récupérer les articles similaires
try {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id != ? AND status = 'published' ORDER BY created_at DESC LIMIT 3");
    $stmt->execute([$article['id']]);
    $related_articles = $stmt->fetchAll();
} catch(PDOException $e) {
    $related_articles = [];
}

include 'includes/header.php';
?>

<!-- Article principal -->
<article class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de l'article -->
        <header class="mb-8 animate-on-scroll">
            <div class="text-sm text-primary-blue mb-4">
                <a href="actualites.php" class="hover:text-primary-blue-dark">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <?php echo get_current_language() == 'fr' ? 'Retour aux actualités' : (get_current_language() == 'en' ? 'Back to news' : 'Rudi kwenye habari'); ?>
                </a>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_text($article['title_fr'], $article['title_en'], $article['title_sw']); ?>
            </h1>
            
            <div class="flex items-center text-gray-600 dark:text-gray-300 text-sm mb-6">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span><?php echo format_date($article['created_at'], 'd F Y'); ?></span>
                <span class="mx-3">•</span>
                <i class="fas fa-clock mr-2"></i>
                <span><?php echo get_current_language() == 'fr' ? '5 min de lecture' : (get_current_language() == 'en' ? '5 min read' : 'Dakika 5 za kusoma'); ?></span>
            </div>
        </header>

        <!-- Image à la une -->
        <?php if ($article['featured_image']): ?>
            <div class="mb-8 animate-on-scroll">
                <img src="<?php echo get_image($article['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                     alt="<?php echo get_text($article['title_fr'], $article['title_en'], $article['title_sw']); ?>" 
                     class="w-full h-96 object-cover rounded-lg shadow-lg">
            </div>
        <?php endif; ?>

        <!-- Contenu de l'article -->
        <div class="prose prose-lg dark:prose-invert max-w-none animate-on-scroll">
            <?php echo nl2br(get_text($article['content_fr'], $article['content_en'], $article['content_sw'])); ?>
        </div>

        <!-- Partage social -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 animate-on-scroll">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Partager cet article' : (get_current_language() == 'en' ? 'Share this article' : 'Shiriki makala hii'); ?>
            </h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/actualites-details.php?slug=' . $article['slug']); ?>" 
                   target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/actualites-details.php?slug=' . $article['slug']); ?>&text=<?php echo urlencode($page_title); ?>" 
                   target="_blank" class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition-colors duration-300">
                    <i class="fab fa-twitter mr-2"></i>Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(SITE_URL . '/actualites-details.php?slug=' . $article['slug']); ?>" 
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

<!-- Articles similaires -->
<?php if (!empty($related_articles)): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Articles similaires' : (get_current_language() == 'en' ? 'Related articles' : 'Makala zinazofanana'); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($related_articles as $related): ?>
                <article class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                    <img src="<?php echo get_image($related['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                         alt="<?php echo get_text($related['title_fr'], $related['title_en'], $related['title_sw']); ?>" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-primary-blue mb-2">
                            <?php echo format_date($related['created_at']); ?>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                            <a href="actualites-details.php?slug=<?php echo $related['slug']; ?>" class="hover:text-primary-blue">
                                <?php echo get_text($related['title_fr'], $related['title_en'], $related['title_sw']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php echo substr(get_text($related['excerpt_fr'], $related['excerpt_en'], $related['excerpt_sw']), 0, 100) . '...'; ?>
                        </p>
                        <a href="actualites-details.php?slug=<?php echo $related['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                            <?php echo get_current_language() == 'fr' ? 'Lire l\'article' : (get_current_language() == 'en' ? 'Read article' : 'Soma makala'); ?>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
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