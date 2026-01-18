<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Domaines d\'intervention' : (get_current_language() == 'en' ? 'Intervention Areas' : 'Maeneo ya Uingiliaji');
$page_description = get_current_language() == 'fr' ? 'Découvrez les domaines d\'intervention de l\'OSPDU' : (get_current_language() == 'en' ? 'Discover OSPDU\'s intervention areas' : 'Gundua maeneo ya uingiliaji ya OSPDU');

// Récupérer tous les domaines d'intervention
try {
    $stmt = $pdo->query("SELECT * FROM intervention_domains WHERE status = 'active' ORDER BY id ASC");
    $domains = $stmt->fetchAll();
} catch(PDOException $e) {
    $domains = [];
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Nos domaines d\'intervention' : (get_current_language() == 'en' ? 'Our Intervention Areas' : 'Maeneo Yetu ya Uingiliaji'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "L'OSPDU intervient dans huit domaines clés pour répondre aux besoins des populations vulnérables et promouvoir un développement durable et équitable.";
            } elseif (get_current_language() == 'en') {
                echo "OSPDU operates in eight key areas to meet the needs of vulnerable populations and promote sustainable and equitable development.";
            } else {
                echo "OSPDU inafanya kazi katika maeneo nane muhimu ya kukidhi mahitaji ya watu walio hatarini na kukuza maendeleo endelevu na ya haki.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Domaines -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($domains)): ?>
            <div class="space-y-16">
                <?php foreach ($domains as $index => $domain): ?>
                    <div class="<?php echo $index % 2 === 0 ? '' : 'lg:flex-row-reverse'; ?> flex flex-col lg:flex-row items-center gap-12 animate-on-scroll">
                        <div class="lg:w-1/2">
                            <div class="flex items-center mb-6">
                                <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-<?php echo $domain['icon']; ?> text-white text-2xl"></i>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                                    <?php echo get_text($domain['name_fr'], $domain['name_en'], $domain['name_sw']); ?>
                                </h2>
                            </div>
                            <div class="prose prose-lg dark:prose-invert">
                                <?php echo nl2br(get_text($domain['description_fr'], $domain['description_en'], $domain['description_sw'])); ?>
                            </div>
                        </div>
                        <div class="lg:w-1/2">
                            <img src="<?php echo get_image($domain['featured_image'], 'assets/images/domain-' . $domain['id'] . '.jpg'); ?>" 
                                 alt="<?php echo get_text($domain['name_fr'], $domain['name_en'], $domain['name_sw']); ?>" 
                                 class="rounded-lg shadow-lg w-full h-80 object-cover">
                        </div>
                    </div>
                    
                    <?php if ($index < count($domains) - 1): ?>
                        <hr class="border-gray-200 dark:border-gray-700">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-info-circle text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">
                    <?php echo get_current_language() == 'fr' ? 'Aucun domaine disponible' : (get_current_language() == 'en' ? 'No domains available' : 'Hakuna maeneo yaliyopatikana'); ?>
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    <?php echo get_current_language() == 'fr' ? 'Les domaines d\'intervention seront bientôt disponibles.' : (get_current_language() == 'en' ? 'Intervention areas will be available soon.' : 'Maeneo ya uingiliaji yatapatikana hivi karibuni.'); ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Section Statistiques -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Notre impact' : (get_current_language() == 'en' ? 'Our Impact' : 'Athari Yetu'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Depuis notre création, nous avons touché des milliers de vies à travers nos différents domaines d'intervention.";
                } elseif (get_current_language() == 'en') {
                    echo "Since our creation, we have touched thousands of lives through our different areas of intervention.";
                } else {
                    echo "Tangu tuanzishwe, tumegusa maisha ya maelfu kupitia maeneo yetu mbalimbali ya uingiliaji.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">1000+</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Bénéficiaires directs' : (get_current_language() == 'en' ? 'Direct beneficiaries' : 'Wanufaika wa moja kwa moja'); ?>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">50+</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Projets réalisés' : (get_current_language() == 'en' ? 'Completed projects' : 'Miradi iliyokamilika'); ?>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">15+</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Communautés touchées' : (get_current_language() == 'en' ? 'Communities reached' : 'Jamii zilizofikwa'); ?>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">8</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Domaines d\'intervention' : (get_current_language() == 'en' ? 'Intervention areas' : 'Maeneo ya uingiliaji'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    echo "Ensemble, nous pouvons créer un impact positif et durable dans tous ces domaines d'intervention.";
                } elseif (get_current_language() == 'en') {
                    echo "Together, we can create a positive and lasting impact in all these areas of intervention.";
                } else {
                    echo "Pamoja, tunaweza kuunda athari chanya na ya kudumu katika maeneo haya yote ya uingiliaji.";
                }
                ?>
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="s-impliquer.php" class="bg-white text-primary-blue px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-300">
                    <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get Involved' : 'Jiunge Nasi'); ?>
                </a>
                <a href="contact.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-blue transition-all duration-300">
                    <?php echo get_current_language() == 'fr' ? 'Nous contacter' : (get_current_language() == 'en' ? 'Contact Us' : 'Wasiliana Nasi'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>