<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Actualités' : (get_current_language() == 'en' ? 'News' : 'Habari');
$page_description = get_current_language() == 'fr' ? 'Découvrez les dernières actualités de l\'OSPDU' : (get_current_language() == 'en' ? 'Discover the latest news from OSPDU' : 'Gundua habari za hivi karibuni kutoka OSPDU');

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Récupérer le nombre total d'actualités
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM news WHERE status = 'published'");
    $total_news = $stmt->fetch()['total'];
    $total_pages = ceil($total_news / $per_page);
} catch(PDOException $e) {
    $total_news = 0;
    $total_pages = 0;
}

// Récupérer les actualités avec pagination
try {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$per_page, $offset]);
    $news = $stmt->fetchAll();
} catch(PDOException $e) {
    $news = [];
}

// Récupérer les actualités à la une (3 dernières)
try {
    $stmt = $pdo->query("SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC LIMIT 3");
    $featured_news = $stmt->fetchAll();
} catch(PDOException $e) {
    $featured_news = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Actualités' : (get_current_language() == 'en' ? 'News' : 'Habari'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Restez informé de nos dernières activités, réalisations et événements à travers nos actualités.";
            } elseif (get_current_language() == 'en') {
                echo "Stay informed about our latest activities, achievements and events through our news.";
            } else {
                echo "Baki ukijua kuhusu shughuli zetu za hivi karibuni, mafanikio na matukio kupitia habari zetu.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Actualités à la une -->
<?php if (!empty($featured_news)): ?>
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'À la une' : (get_current_language() == 'en' ? 'Featured News' : 'Habari Kuu'); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Article principal -->
            <?php if (isset($featured_news[0])): ?>
            <div class="lg:col-span-2 animate-on-scroll">
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <img src="<?php echo get_image($featured_news[0]['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                         alt="<?php echo get_text($featured_news[0]['title_fr'], $featured_news[0]['title_en'], $featured_news[0]['title_sw']); ?>" 
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-primary-blue mb-2">
                            <?php echo format_date($featured_news[0]['created_at']); ?>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            <a href="actualites-details.php?slug=<?php echo $featured_news[0]['slug']; ?>" class="hover:text-primary-blue">
                                <?php echo get_text($featured_news[0]['title_fr'], $featured_news[0]['title_en'], $featured_news[0]['title_sw']); ?>
                            </a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php echo substr(get_text($featured_news[0]['excerpt_fr'], $featured_news[0]['excerpt_en'], $featured_news[0]['excerpt_sw']), 0, 200) . '...'; ?>
                        </p>
                        <a href="actualites-details.php?slug=<?php echo $featured_news[0]['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                            <?php echo get_current_language() == 'fr' ? 'Lire la suite' : (get_current_language() == 'en' ? 'Read more' : 'Soma zaidi'); ?>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
            </div>
            <?php endif; ?>

            <!-- Articles secondaires -->
            <div class="space-y-6">
                <?php for ($i = 1; $i < count($featured_news) && $i < 3; $i++): ?>
                <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden animate-on-scroll">
                    <div class="flex">
                        <img src="<?php echo get_image($featured_news[$i]['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                             alt="<?php echo get_text($featured_news[$i]['title_fr'], $featured_news[$i]['title_en'], $featured_news[$i]['title_sw']); ?>" 
                             class="w-24 h-24 object-cover">
                        <div class="p-4 flex-1">
                            <div class="text-xs text-primary-blue mb-1">
                                <?php echo format_date($featured_news[$i]['created_at']); ?>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                <a href="actualites-details.php?slug=<?php echo $featured_news[$i]['slug']; ?>" class="hover:text-primary-blue">
                                    <?php echo substr(get_text($featured_news[$i]['title_fr'], $featured_news[$i]['title_en'], $featured_news[$i]['title_sw']), 0, 80) . '...'; ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                </article>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section Toutes les actualités -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Toutes nos actualités' : (get_current_language() == 'en' ? 'All our news' : 'Habari zetu zote'); ?>
            </h2>
        </div>

        <?php if (!empty($news)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($news as $article): ?>
                    <article class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                        <img src="<?php echo get_image($article['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                             alt="<?php echo get_text($article['title_fr'], $article['title_en'], $article['title_sw']); ?>" 
                             class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="text-sm text-primary-blue mb-2">
                                <?php echo format_date($article['created_at']); ?>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                <a href="actualites-details.php?slug=<?php echo $article['slug']; ?>" class="hover:text-primary-blue">
                                    <?php echo get_text($article['title_fr'], $article['title_en'], $article['title_sw']); ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                <?php echo substr(get_text($article['excerpt_fr'], $article['excerpt_en'], $article['excerpt_sw']), 0, 120) . '...'; ?>
                            </p>
                            <a href="actualites-details.php?slug=<?php echo $article['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                                <?php echo get_current_language() == 'fr' ? 'Lire l\'article' : (get_current_language() == 'en' ? 'Read article' : 'Soma makala'); ?>
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-12 flex justify-center animate-on-scroll">
                    <nav class="flex items-center space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="px-3 py-2 <?php echo $i === $page ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'; ?> border border-gray-300 dark:border-gray-600 rounded-lg">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-newspaper text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    <?php echo get_current_language() == 'fr' ? 'Aucune actualité disponible' : (get_current_language() == 'en' ? 'No news available' : 'Hakuna habari zilizopatikana'); ?>
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    <?php echo get_current_language() == 'fr' ? 'Les actualités seront bientôt disponibles.' : (get_current_language() == 'en' ? 'News will be available soon.' : 'Habari zitapatikana hivi karibuni.'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>