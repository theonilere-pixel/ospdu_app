<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Galerie' : (get_current_language() == 'en' ? 'Gallery' : 'Picha');
$page_description = get_current_language() == 'fr' ? 'Découvrez notre galerie photos et vidéos' : (get_current_language() == 'en' ? 'Discover our photo and video gallery' : 'Gundua galeri yetu ya picha na video');

// Filtrage par catégorie
$category = isset($_GET['category']) ? sanitize_input($_GET['category']) : 'all';
$categories = ['all', 'photos', 'videos', 'documents'];

if (!in_array($category, $categories)) {
    $category = 'all';
}

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Construire la requête selon la catégorie
$where_clause = "WHERE status = 'active'";
$params = [];

if ($category !== 'all') {
    $where_clause .= " AND category = ?";
    $params[] = $category;
}

// Récupérer le nombre total d'éléments
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM gallery " . $where_clause);
    $stmt->execute($params);
    $total_items = $stmt->fetch()['total'];
    $total_pages = ceil($total_items / $per_page);
} catch(PDOException $e) {
    $total_items = 0;
    $total_pages = 0;
}

// Récupérer les éléments de la galerie
try {
    $stmt = $pdo->prepare("SELECT * FROM gallery " . $where_clause . " ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute(array_merge($params, [$per_page, $offset]));
    $gallery_items = $stmt->fetchAll();
} catch(PDOException $e) {
    $gallery_items = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Notre Galerie' : (get_current_language() == 'en' ? 'Our Gallery' : 'Galeri Yetu'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Découvrez nos activités à travers nos photos, vidéos et documents qui témoignent de notre engagement sur le terrain.";
            } elseif (get_current_language() == 'en') {
                echo "Discover our activities through our photos, videos and documents that testify to our commitment in the field.";
            } else {
                echo "Gundua shughuli zetu kupitia picha, video na hati zetu zinazoshuhudia dhamana yetu shambani.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Filtres -->
<section class="py-8 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <a href="?category=all" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $category === 'all' ? 'bg-primary-blue text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <?php echo get_current_language() == 'fr' ? 'Tout' : (get_current_language() == 'en' ? 'All' : 'Yote'); ?>
            </a>
            <a href="?category=photos" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $category === 'photos' ? 'bg-primary-blue text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-camera mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Photos' : (get_current_language() == 'en' ? 'Photos' : 'Picha'); ?>
            </a>
            <a href="?category=videos" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $category === 'videos' ? 'bg-primary-blue text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-video mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Vidéos' : (get_current_language() == 'en' ? 'Videos' : 'Video'); ?>
            </a>
            <a href="?category=documents" class="px-6 py-2 rounded-full font-medium transition-colors duration-300 <?php echo $category === 'documents' ? 'bg-primary-blue text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-primary-blue hover:text-white'; ?>">
                <i class="fas fa-file-alt mr-2"></i>
                <?php echo get_current_language() == 'fr' ? 'Documents' : (get_current_language() == 'en' ? 'Documents' : 'Hati'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Section Galerie -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($gallery_items)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($gallery_items as $item): ?>
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                        <?php if ($item['category'] === 'photos'): ?>
                            <div class="relative group cursor-pointer" onclick="openLightbox('<?php echo $item['image_path']; ?>', '<?php echo get_text($item['title_fr'], $item['title_en'], $item['title_sw']); ?>')">
                                <img src="<?php echo get_image($item['image_path'], 'assets/images/gallery-default.jpg'); ?>" 
                                     alt="<?php echo get_text($item['title_fr'], $item['title_en'], $item['title_sw']); ?>" 
                                     class="w-full h-48 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                </div>
                            </div>
                        <?php elseif ($item['category'] === 'videos'): ?>
                            <div class="relative group cursor-pointer" onclick="openVideoModal('<?php echo $item['image_path']; ?>', '<?php echo get_text($item['title_fr'], $item['title_en'], $item['title_sw']); ?>')">
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-play-circle text-primary-blue text-6xl"></i>
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-play text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="relative group cursor-pointer" onclick="downloadDocument('<?php echo $item['image_path']; ?>')">
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-red-500 text-6xl"></i>
                                </div>
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-download text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <?php echo get_text($item['title_fr'], $item['title_en'], $item['title_sw']); ?>
                            </h3>
                            <?php if (!empty(get_text($item['description_fr'], $item['description_en'], $item['description_sw']))): ?>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    <?php echo substr(get_text($item['description_fr'], $item['description_en'], $item['description_sw']), 0, 100) . '...'; ?>
                                </p>
                            <?php endif; ?>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $item['category'] === 'photos' ? 'bg-blue-100 text-blue-800' : ($item['category'] === 'videos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <i class="fas fa-<?php echo $item['category'] === 'photos' ? 'camera' : ($item['category'] === 'videos' ? 'video' : 'file-alt'); ?> mr-1"></i>
                                    <?php echo ucfirst($item['category']); ?>
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo format_date($item['created_at']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-12 flex justify-center animate-on-scroll">
                    <nav class="flex items-center space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?category=<?php echo $category; ?>&page=<?php echo $page - 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                            <a href="?category=<?php echo $category; ?>&page=<?php echo $i; ?>" class="px-3 py-2 <?php echo $i === $page ? 'bg-primary-blue text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'; ?> border border-gray-300 dark:border-gray-600 rounded-lg">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?category=<?php echo $category; ?>&page=<?php echo $page + 1; ?>" class="px-3 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-images text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    <?php echo get_current_language() == 'fr' ? 'Aucun élément disponible' : (get_current_language() == 'en' ? 'No items available' : 'Hakuna vipengee vilivopatikana'); ?>
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    <?php echo get_current_language() == 'fr' ? 'La galerie sera bientôt mise à jour.' : (get_current_language() == 'en' ? 'The gallery will be updated soon.' : 'Galeri itasasishwa hivi karibuni.'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal Lightbox pour les images -->
<div id="lightbox-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain">
        <div class="absolute bottom-4 left-4 right-4 text-white">
            <h3 id="lightbox-title" class="text-lg font-semibold"></h3>
        </div>
    </div>
</div>

<!-- Modal pour les vidéos -->
<div id="video-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeVideoModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <video id="video-player" controls class="max-w-full max-h-full">
            <source src="" type="video/mp4">
            Votre navigateur ne supporte pas la lecture vidéo.
        </video>
        <div class="absolute bottom-4 left-4 right-4 text-white">
            <h3 id="video-title" class="text-lg font-semibold"></h3>
        </div>
    </div>
</div>

<script>
// Fonctions pour le lightbox
function openLightbox(imageSrc, title) {
    document.getElementById('lightbox-image').src = imageSrc;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fonctions pour les vidéos
function openVideoModal(videoSrc, title) {
    document.getElementById('video-player').src = videoSrc;
    document.getElementById('video-title').textContent = title;
    document.getElementById('video-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const video = document.getElementById('video-player');
    video.pause();
    video.src = '';
    document.getElementById('video-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fonction pour télécharger les documents
function downloadDocument(docSrc) {
    window.open(docSrc, '_blank');
}

// Fermer les modals avec Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
        closeVideoModal();
    }
});

// Fermer les modals en cliquant à l'extérieur
document.getElementById('lightbox-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});

document.getElementById('video-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeVideoModal();
    }
});
</script>

<?php include 'includes/footer.php'; ?>