<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Accueil' : (get_current_language() == 'en' ? 'Home' : 'Nyumbani');
$page_description = get_site_setting('site_description');

// Récupérer les sliders
try {
    $stmt = $pdo->query("SELECT * FROM sliders WHERE status = 'active' ORDER BY order_position ASC");
    $sliders = $stmt->fetchAll();
} catch(PDOException $e) {
    $sliders = [];
}

// Récupérer les dernières actualités
try {
    $stmt = $pdo->query("SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC LIMIT 3");
    $latest_news = $stmt->fetchAll();
} catch(PDOException $e) {
    $latest_news = [];
}

// Récupérer les domaines d'intervention
try {
    $stmt = $pdo->query("SELECT * FROM intervention_domains WHERE status = 'active' ORDER BY id ASC LIMIT 8");
    $domains = $stmt->fetchAll();
} catch(PDOException $e) {
    $domains = [];
}

// Récupérer les projets récents
try {
    $stmt = $pdo->query("SELECT * FROM projects WHERE status = 'active' ORDER BY created_at DESC LIMIT 3");
    $recent_projects = $stmt->fetchAll();
} catch(PDOException $e) {
    $recent_projects = [];
}

include 'includes/header.php';
?>

<!-- Hero Section avec Slider -->
<section class="relative h-screen overflow-hidden">
    <?php if (!empty($sliders)): ?>
        <div id="hero-slider" class="relative h-full">
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="slide <?php echo $index === 0 ? 'active' : ''; ?> absolute inset-0 transition-opacity duration-1000 <?php echo $index === 0 ? 'opacity-100' : 'opacity-0'; ?>">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <img src="<?php echo get_image($slider['image_path'], 'assets/images/hero-bg.jpg'); ?>" 
                         alt="<?php echo get_text($slider['title_fr'], $slider['title_en'], $slider['title_sw']); ?>" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white max-w-4xl mx-auto px-4">
                            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-shadow animate-on-scroll">
                                <?php echo get_text($slider['title_fr'], $slider['title_en'], $slider['title_sw']); ?>
                            </h1>
                            <p class="text-xl md:text-2xl mb-8 text-shadow animate-on-scroll">
                                <?php echo get_text($slider['subtitle_fr'], $slider['subtitle_en'], $slider['subtitle_sw']); ?>
                            </p>
                            <?php if (!empty($slider['link_url'])): ?>
                                <a href="<?php echo $slider['link_url']; ?>" class="btn-primary text-lg animate-on-scroll">
                                    <?php echo get_text($slider['button_text_fr'], $slider['button_text_en'], $slider['button_text_sw']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Navigation du slider -->
            <?php if (count($sliders) > 1): ?>
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <?php foreach ($sliders as $index => $slider): ?>
                        <button class="slider-dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300 <?php echo $index === 0 ? 'bg-opacity-100' : ''; ?>" 
                                data-slide="<?php echo $index; ?>"></button>
                    <?php endforeach; ?>
                </div>
                
                <!-- Flèches de navigation -->
                <button id="prev-slide" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-primary-blue transition-colors duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="next-slide" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl hover:text-primary-blue transition-colors duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <!-- Hero par défaut si pas de sliders -->
        <div class="hero-gradient h-full flex items-center justify-center">
            <div class="text-center text-white max-w-4xl mx-auto px-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-shadow">
                    <?php echo get_site_setting('site_title'); ?>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-shadow">
                    <?php echo get_site_setting('site_slogan'); ?>
                </p>
                <a href="qui-sommes-nous.php" class="btn-primary text-lg">
                    <?php echo get_current_language() == 'fr' ? 'Découvrir notre mission' : (get_current_language() == 'en' ? 'Discover our mission' : 'Gundua dhamira yetu'); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Section À propos -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="animate-on-scroll">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php echo get_current_language() == 'fr' ? 'Qui sommes-nous ?' : (get_current_language() == 'en' ? 'Who are we?' : 'Sisi ni nani?'); ?>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "L'OSPDU (Organe Solidaire pour la Protection Sociale et le Développement Durable) est une organisation humanitaire née d'un engagement profond pour l'égalité des genres et la justice sociale.";
                    } elseif (get_current_language() == 'en') {
                        echo "OSPDU (Solidarity Organization for Social Protection and Sustainable Development) is a humanitarian organization born from a deep commitment to gender equality and social justice.";
                    } else {
                        echo "OSPDU (Shirika la Umoja kwa Ulinzi wa Kijamii na Maendeleo Endelevu) ni shirika la kibinadamu lililoongozwa na dhamira ya usawa wa kijinsia na haki za kijamii.";
                    }
                    ?>
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-8">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Depuis 2016, nous œuvrons pour l'autonomisation des femmes et des filles, la protection des enfants, et le développement durable des communautés vulnérables.";
                    } elseif (get_current_language() == 'en') {
                        echo "Since 2016, we have been working for the empowerment of women and girls, child protection, and sustainable development of vulnerable communities.";
                    } else {
                        echo "Tangu 2016, tumekuwa tukifanya kazi kwa ajili ya uwezeshaji wa wanawake na wasichana, ulinzi wa watoto, na maendeleo endelevu ya jamii zilizo hatarini.";
                    }
                    ?>
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="qui-sommes-nous.php" class="btn-primary">
                        <?php echo get_current_language() == 'fr' ? 'En savoir plus' : (get_current_language() == 'en' ? 'Learn more' : 'Jifunze zaidi'); ?>
                    </a>
                    <a href="s-impliquer.php" class="btn-secondary">
                        <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get involved' : 'Jiunge nasi'); ?>
                    </a>
                </div>
            </div>
            <div class="animate-on-scroll">
                <img src="assets/images/logo.png" alt="À propos de nous" class="rounded-lg shadow-lg w-full h-96 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- Section Domaines d'intervention -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Nos domaines d\'intervention' : (get_current_language() == 'en' ? 'Our intervention areas' : 'Maeneo yetu ya uingiliaji'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Nous intervenons dans plusieurs domaines clés pour répondre aux besoins des populations vulnérables et promouvoir un développement durable.";
                } elseif (get_current_language() == 'en') {
                    echo "We operate in several key areas to meet the needs of vulnerable populations and promote sustainable development.";
                } else {
                    echo "Tunafanya kazi katika maeneo kadhaa muhimu ili kukidhi mahitaji ya watu walio hatarini na kukuza maendeleo endelevu.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($domains as $domain): ?>
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-<?php echo $domain['icon']; ?> text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        <?php echo get_text($domain['name_fr'], $domain['name_en'], $domain['name_sw']); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        <?php echo get_text($domain['description_fr'], $domain['description_en'], $domain['description_sw']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="domaines-intervention.php" class="btn-primary">
                <?php echo get_current_language() == 'fr' ? 'Voir tous nos domaines' : (get_current_language() == 'en' ? 'See all our domains' : 'Ona maeneo yetu yote'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Section Statistiques -->
<section class="py-16 hero-gradient">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center text-white">
            <div class="animate-on-scroll">
                <div class="text-4xl font-bold mb-2">8+</div>
                <div class="text-lg">
                    <?php echo get_current_language() == 'fr' ? 'Années d\'expérience' : (get_current_language() == 'en' ? 'Years of experience' : 'Miaka ya uzoefu'); ?>
                </div>
            </div>
            <div class="animate-on-scroll">
                <div class="text-4xl font-bold mb-2">1000+</div>
                <div class="text-lg">
                    <?php echo get_current_language() == 'fr' ? 'Bénéficiaires' : (get_current_language() == 'en' ? 'Beneficiaries' : 'Wanufaika'); ?>
                </div>
            </div>
            <div class="animate-on-scroll">
                <div class="text-4xl font-bold mb-2">50+</div>
                <div class="text-lg">
                    <?php echo get_current_language() == 'fr' ? 'Projets réalisés' : (get_current_language() == 'en' ? 'Completed projects' : 'Miradi iliyokamilika'); ?>
                </div>
            </div>
            <div class="animate-on-scroll">
                <div class="text-4xl font-bold mb-2">8</div>
                <div class="text-lg">
                    <?php echo get_current_language() == 'fr' ? 'Domaines d\'intervention' : (get_current_language() == 'en' ? 'Intervention areas' : 'Maeneo ya uingiliaji'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Projets récents -->
<?php if (!empty($recent_projects)): ?>
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Nos projets récents' : (get_current_language() == 'en' ? 'Our recent projects' : 'Miradi yetu ya hivi karibuni'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Découvrez nos derniers projets et initiatives pour améliorer la vie des communautés que nous servons.";
                } elseif (get_current_language() == 'en') {
                    echo "Discover our latest projects and initiatives to improve the lives of the communities we serve.";
                } else {
                    echo "Gundua miradi yetu ya hivi karibuni na mipango ya kuboresha maisha ya jamii tunazozitumikia.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($recent_projects as $project): ?>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                    <img src="<?php echo get_image($project['featured_image'], 'assets/images/project-default.jpg'); ?>" 
                         alt="<?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <?php echo get_text($project['title_fr'], $project['title_en'], $project['title_sw']); ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php echo substr(get_text($project['description_fr'], $project['description_en'], $project['description_sw']), 0, 150) . '...'; ?>
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-primary-blue font-semibold">
                                <?php echo ucfirst($project['status']); ?>
                            </span>
                            <a href="projets-details.php?slug=<?php echo $project['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark">
                                <?php echo get_current_language() == 'fr' ? 'Lire plus' : (get_current_language() == 'en' ? 'Read more' : 'Soma zaidi'); ?>
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="projets.php" class="btn-primary">
                <?php echo get_current_language() == 'fr' ? 'Voir tous nos projets' : (get_current_language() == 'en' ? 'See all our projects' : 'Ona miradi yetu yote'); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section Actualités -->
<?php if (!empty($latest_news)): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Dernières actualités' : (get_current_language() == 'en' ? 'Latest news' : 'Habari za hivi karibuni'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Restez informé de nos dernières activités, événements et réalisations.";
                } elseif (get_current_language() == 'en') {
                    echo "Stay informed about our latest activities, events and achievements.";
                } else {
                    echo "Baki ukijua kuhusu shughuli zetu za hivi karibuni, matukio na mafanikio.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($latest_news as $news): ?>
                <article class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden card-hover animate-on-scroll">
                    <img src="<?php echo get_image($news['featured_image'], 'assets/images/news-default.jpg'); ?>" 
                         alt="<?php echo get_text($news['title_fr'], $news['title_en'], $news['title_sw']); ?>" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-primary-blue mb-2">
                            <?php echo format_date($news['created_at']); ?>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                            <?php echo get_text($news['title_fr'], $news['title_en'], $news['title_sw']); ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?php echo substr(get_text($news['excerpt_fr'], $news['excerpt_en'], $news['excerpt_sw']), 0, 120) . '...'; ?>
                        </p>
                        <a href="actualites-details.php?slug=<?php echo $news['slug']; ?>" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                            <?php echo get_current_language() == 'fr' ? 'Lire l\'article' : (get_current_language() == 'en' ? 'Read article' : 'Soma makala'); ?>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-12 animate-on-scroll">
            <a href="actualites.php" class="btn-primary">
                <?php echo get_current_language() == 'fr' ? 'Toutes les actualités' : (get_current_language() == 'en' ? 'All news' : 'Habari zote'); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Section Appel à l'action -->
<section class="py-16 hero-gradient">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                <?php echo get_current_language() == 'fr' ? 'Rejoignez notre mission' : (get_current_language() == 'en' ? 'Join our mission' : 'Jiunge na dhamira yetu'); ?>
            </h2>
            <p class="text-xl text-white mb-8">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Ensemble, nous pouvons créer un monde plus équitable et durable pour tous.";
                } elseif (get_current_language() == 'en') {
                    echo "Together, we can create a more equitable and sustainable world for all.";
                } else {
                    echo "Pamoja, tunaweza kuunda ulimwengu wa haki na endelevu kwa wote.";
                }
                ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="s-impliquer.php" class="bg-white text-primary-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                    <?php echo get_current_language() == 'fr' ? 'Devenir bénévole' : (get_current_language() == 'en' ? 'Become volunteer' : 'Kuwa mtoaji huduma'); ?>
                </a>
                <a href="donation.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-blue transition-all duration-300">
                    <?php echo get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make donation' : 'Toa mchango'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Gestion du slider
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
        });
        
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-opacity-100', i === index);
            dot.classList.toggle('bg-opacity-50', i !== index);
        });
        
        currentSlide = index;
    }

    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }

    // Auto-play
    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', () => {
        nextSlide();
        stopSlideshow();
        startSlideshow();
    });

    if (prevBtn) prevBtn.addEventListener('click', () => {
        prevSlide();
        stopSlideshow();
        startSlideshow();
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            stopSlideshow();
            startSlideshow();
        });
    });

    // Pause on hover
    const slider = document.getElementById('hero-slider');
    if (slider) {
        slider.addEventListener('mouseenter', stopSlideshow);
        slider.addEventListener('mouseleave', startSlideshow);
    }

    // Start slideshow
    if (slides.length > 1) {
        startSlideshow();
    }
});
</script>

<?php include 'includes/footer.php'; ?>