<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Contact' : (get_current_language() == 'en' ? 'Contact' : 'Mawasiliano');
$page_description = get_current_language() == 'fr' ? 'Contactez l\'OSPDU pour toute question ou collaboration' : (get_current_language() == 'en' ? 'Contact OSPDU for any questions or collaboration' : 'Wasiliana na OSPDU kwa maswali yoyote au ushirikiano');

$success_message = '';
$error_message = '';

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);
    $csrf_token = $_POST['csrf_token'];
    
    // Vérification du token CSRF
    if (!verify_csrf_token($csrf_token)) {
        $error_message = get_current_language() == 'fr' ? 'Erreur de sécurité. Veuillez réessayer.' : (get_current_language() == 'en' ? 'Security error. Please try again.' : 'Hitilafu ya usalama. Tafadhali jaribu tena.');
    } elseif (empty($name) || empty($email) || empty($message)) {
        $error_message = get_current_language() == 'fr' ? 'Veuillez remplir tous les champs obligatoires.' : (get_current_language() == 'en' ? 'Please fill in all required fields.' : 'Tafadhali jaza sehemu zote zinazohitajika.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = get_current_language() == 'fr' ? 'Adresse email invalide.' : (get_current_language() == 'en' ? 'Invalid email address.' : 'Anwani ya barua pepe si sahihi.');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $subject, $message])) {
                $success_message = get_current_language() == 'fr' ? 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.' : (get_current_language() == 'en' ? 'Your message has been sent successfully. We will respond to you as soon as possible.' : 'Ujumbe wako umetumwa kwa ufanisi. Tutakujibu haraka iwezekanavyo.');
                
                // Envoyer un email de notification (optionnel)
                $admin_email = get_site_setting('contact_email');
                $email_subject = "Nouveau message de contact - " . $subject;
                $email_body = "
                    <h3>Nouveau message de contact</h3>
                    <p><strong>Nom:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Sujet:</strong> $subject</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                ";
                send_email($admin_email, $email_subject, $email_body);
                
                // Réinitialiser les variables
                $name = $email = $subject = $message = '';
            } else {
                $error_message = get_current_language() == 'fr' ? 'Erreur lors de l\'envoi du message. Veuillez réessayer.' : (get_current_language() == 'en' ? 'Error sending message. Please try again.' : 'Hitilafu wakati wa kutuma ujumbe. Tafadhali jaribu tena.');
            }
        } catch(PDOException $e) {
            $error_message = get_current_language() == 'fr' ? 'Erreur technique. Veuillez réessayer plus tard.' : (get_current_language() == 'en' ? 'Technical error. Please try again later.' : 'Hitilafu ya kiufundi. Tafadhali jaribu baadaye.');
        }
    }
}

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Contactez-nous' : (get_current_language() == 'en' ? 'Contact Us' : 'Wasiliana Nasi'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Nous sommes là pour répondre à vos questions et discuter de vos projets de collaboration.";
            } elseif (get_current_language() == 'en') {
                echo "We are here to answer your questions and discuss your collaboration projects.";
            } else {
                echo "Tuko hapa kujibu maswali yako na kujadili miradi yako ya ushirikiano.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Contact -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Formulaire de contact -->
            <div class="animate-on-scroll">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php echo get_current_language() == 'fr' ? 'Envoyez-nous un message' : (get_current_language() == 'en' ? 'Send us a message' : 'Tutumie ujumbe'); ?>
                </h2>
                
                <?php if ($success_message): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-6" id="contact-form">
                    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Nom complet *' : (get_current_language() == 'en' ? 'Full name *' : 'Jina kamili *'); ?>
                            </label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent dark:bg-gray-800 dark:text-white">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Adresse email *' : (get_current_language() == 'en' ? 'Email address *' : 'Anwani ya barua pepe *'); ?>
                            </label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent dark:bg-gray-800 dark:text-white">
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo get_current_language() == 'fr' ? 'Sujet' : (get_current_language() == 'en' ? 'Subject' : 'Mada'); ?>
                        </label>
                        <input type="text" id="subject" name="subject" 
                               value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent dark:bg-gray-800 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo get_current_language() == 'fr' ? 'Message *' : (get_current_language() == 'en' ? 'Message *' : 'Ujumbe *'); ?>
                        </label>
                        <textarea id="message" name="message" rows="6" required 
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent dark:bg-gray-800 dark:text-white"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" name="submit_contact" class="btn-primary w-full">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <?php echo get_current_language() == 'fr' ? 'Envoyer le message' : (get_current_language() == 'en' ? 'Send message' : 'Tuma ujumbe'); ?>
                    </button>
                </form>
            </div>
            
            <!-- Informations de contact -->
            <div class="animate-on-scroll">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                    <?php echo get_current_language() == 'fr' ? 'Nos coordonnées' : (get_current_language() == 'en' ? 'Our contact information' : 'Maelezo yetu ya mawasiliano'); ?>
                </h2>
                
                <div class="space-y-6">
                    <!-- Adresse -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Adresse' : (get_current_language() == 'en' ? 'Address' : 'Anwani'); ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                <?php echo get_site_setting('contact_address'); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Téléphone -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Téléphone' : (get_current_language() == 'en' ? 'Phone' : 'Simu'); ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                <a href="tel:<?php echo str_replace(' ', '', get_site_setting('contact_phone')); ?>" class="hover:text-primary-blue">
                                    <?php echo get_site_setting('contact_phone'); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Email' : (get_current_language() == 'en' ? 'Email' : 'Barua pepe'); ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                <a href="mailto:<?php echo get_site_setting('contact_email'); ?>" class="hover:text-primary-blue">
                                    <?php echo get_site_setting('contact_email'); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Réseaux sociaux -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-blue rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                <?php echo get_current_language() == 'fr' ? 'Réseaux sociaux' : (get_current_language() == 'en' ? 'Social networks' : 'Mitandao ya kijamii'); ?>
                            </h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-blue">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-blue">
                                    <i class="fab fa-twitter text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-blue">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-primary-blue">
                                    <i class="fab fa-instagram text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Heures d'ouverture -->
                <div class="mt-8 p-6 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <?php echo get_current_language() == 'fr' ? 'Heures d\'ouverture' : (get_current_language() == 'en' ? 'Opening hours' : 'Masaa ya kufungua'); ?>
                    </h3>
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex justify-between">
                            <span><?php echo get_current_language() == 'fr' ? 'Lundi - Vendredi' : (get_current_language() == 'en' ? 'Monday - Friday' : 'Jumatatu - Ijumaa'); ?></span>
                            <span>08:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span><?php echo get_current_language() == 'fr' ? 'Samedi' : (get_current_language() == 'en' ? 'Saturday' : 'Jumamosi'); ?></span>
                            <span>09:00 - 13:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span><?php echo get_current_language() == 'fr' ? 'Dimanche' : (get_current_language() == 'en' ? 'Sunday' : 'Jumapili'); ?></span>
                            <span><?php echo get_current_language() == 'fr' ? 'Fermé' : (get_current_language() == 'en' ? 'Closed' : 'Imefungwa'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Carte -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Notre localisation' : (get_current_language() == 'en' ? 'Our location' : 'Mahali tulipo'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                <?php echo get_current_language() == 'fr' ? 'Trouvez-nous sur la carte' : (get_current_language() == 'en' ? 'Find us on the map' : 'Tuone kwenye ramani'); ?>
            </p>
        </div>
        
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden animate-on-scroll">
            <!-- Placeholder pour la carte Google Maps -->
            <div class="h-96 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php echo get_current_language() == 'fr' ? 'Carte interactive à intégrer' : (get_current_language() == 'en' ? 'Interactive map to integrate' : 'Ramani ya maingiliano ya kuunganisha'); ?>
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Kiwanja, Territoire de Rutshuru, Nord-Kivu, RDC
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Validation du formulaire côté client
document.getElementById('contact-form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (!name || !email || !message) {
        e.preventDefault();
        showNotification('<?php echo get_current_language() == "fr" ? "Veuillez remplir tous les champs obligatoires." : (get_current_language() == "en" ? "Please fill in all required fields." : "Tafadhali jaza sehemu zote zinazohitajika."); ?>', 'error');
        return;
    }
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        showNotification('<?php echo get_current_language() == "fr" ? "Adresse email invalide." : (get_current_language() == "en" ? "Invalid email address." : "Anwani ya barua pepe si sahihi."); ?>', 'error');
        return;
    }
});

// Animation des éléments au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});
</script>

<?php include 'includes/footer.php'; ?>