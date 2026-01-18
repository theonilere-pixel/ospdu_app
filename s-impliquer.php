<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get Involved' : 'Jiunge Nasi');
$page_description = get_current_language() == 'fr' ? 'Rejoignez notre mission et contribuez à un monde plus équitable' : (get_current_language() == 'en' ? 'Join our mission and contribute to a more equitable world' : 'Jiunge na dhamira yetu na uchangie ulimwengu wa haki zaidi');

$success_message = '';
$error_message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'];
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
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
            $subject = '';
            switch($form_type) {
                case 'volunteer':
                    $subject = get_current_language() == 'fr' ? 'Demande de bénévolat' : (get_current_language() == 'en' ? 'Volunteer application' : 'Ombi la kuwa mtoaji huduma');
                    break;
                case 'partner':
                    $subject = get_current_language() == 'fr' ? 'Demande de partenariat' : (get_current_language() == 'en' ? 'Partnership request' : 'Ombi la ushirikiano');
                    break;
                case 'team':
                    $subject = get_current_language() == 'fr' ? 'Demande de rejoindre l\'équipe' : (get_current_language() == 'en' ? 'Request to join the team' : 'Ombi la kujiunga na timu');
                    break;
                default:
                    $subject = get_current_language() == 'fr' ? 'Demande d\'implication' : (get_current_language() == 'en' ? 'Involvement request' : 'Ombi la kujihusisha');
            }
            
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $subject, $message . "\n\nTéléphone: " . $phone])) {
                $success_message = get_current_language() == 'fr' ? 'Votre demande a été envoyée avec succès. Nous vous contacterons bientôt.' : (get_current_language() == 'en' ? 'Your request has been sent successfully. We will contact you soon.' : 'Ombi lako limetumwa kwa ufanisi. Tutawasiliana nawe hivi karibuni.');
                
                // Envoyer un email de notification
                $admin_email = get_site_setting('contact_email');
                $email_subject = "Nouvelle demande d'implication - " . $subject;
                $email_body = "
                    <h3>Nouvelle demande d'implication</h3>
                    <p><strong>Type:</strong> $subject</p>
                    <p><strong>Nom:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Téléphone:</strong> $phone</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                ";
                send_email($admin_email, $email_subject, $email_body);
                
                // Réinitialiser les variables
                $name = $email = $phone = $message = '';
            } else {
                $error_message = get_current_language() == 'fr' ? 'Erreur lors de l\'envoi de la demande. Veuillez réessayer.' : (get_current_language() == 'en' ? 'Error sending request. Please try again.' : 'Hitilafu wakati wa kutuma ombi. Tafadhali jaribu tena.');
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
            <?php echo get_current_language() == 'fr' ? 'S\'impliquer avec l\'OSPDU' : (get_current_language() == 'en' ? 'Get Involved with OSPDU' : 'Jiunge na OSPDU'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Rejoignez notre mission pour créer un monde plus équitable. Ensemble, nous pouvons faire la différence.";
            } elseif (get_current_language() == 'en') {
                echo "Join our mission to create a more equitable world. Together, we can make a difference.";
            } else {
                echo "Jiunge na dhamira yetu ya kuunda ulimwengu wa haki zaidi. Pamoja, tunaweza kuleta mabadiliko.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Façons de s'impliquer -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Comment vous impliquer' : (get_current_language() == 'en' ? 'How to get involved' : 'Jinsi ya kujihusisha'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Il existe plusieurs façons de contribuer à notre mission et de faire partie du changement positif.";
                } elseif (get_current_language() == 'en') {
                    echo "There are several ways to contribute to our mission and be part of positive change.";
                } else {
                    echo "Kuna njia kadhaa za kuchangia dhamira yetu na kuwa sehemu ya mabadiliko mazuri.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Devenir bénévole -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hands-helping text-blue-600 dark:text-blue-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Devenir bénévole' : (get_current_language() == 'en' ? 'Become a volunteer' : 'Kuwa mtoaji huduma'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Offrez votre temps et vos compétences pour soutenir nos projets sur le terrain.";
                    } elseif (get_current_language() == 'en') {
                        echo "Offer your time and skills to support our projects in the field.";
                    } else {
                        echo "Toa muda na ujuzi wako kusaidia miradi yetu shambani.";
                    }
                    ?>
                </p>
                <button onclick="showForm('volunteer')" class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Postuler' : (get_current_language() == 'en' ? 'Apply' : 'Omba'); ?>
                </button>
            </div>

            <!-- Devenir partenaire -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Devenir partenaire' : (get_current_language() == 'en' ? 'Become a partner' : 'Kuwa mshirika'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Collaborez avec nous pour amplifier notre impact et atteindre plus de communautés.";
                    } elseif (get_current_language() == 'en') {
                        echo "Collaborate with us to amplify our impact and reach more communities.";
                    } else {
                        echo "Shirikiana nasi kuongeza athari yetu na kufikia jamii zaidi.";
                    }
                    ?>
                </p>
                <button onclick="showForm('partner')" class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Nous contacter' : (get_current_language() == 'en' ? 'Contact us' : 'Wasiliana nasi'); ?>
                </button>
            </div>

            <!-- Rejoindre l'équipe -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-purple-600 dark:text-purple-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Rejoindre l\'équipe' : (get_current_language() == 'en' ? 'Join the team' : 'Jiunge na timu'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Intégrez notre équipe permanente et participez activement à notre mission.";
                    } elseif (get_current_language() == 'en') {
                        echo "Join our permanent team and actively participate in our mission.";
                    } else {
                        echo "Jiunge na timu yetu ya kudumu na ushiriki kikamilifu katika dhamira yetu.";
                    }
                    ?>
                </p>
                <button onclick="showForm('team')" class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Candidater' : (get_current_language() == 'en' ? 'Apply' : 'Omba'); ?>
                </button>
            </div>

            <!-- Faire un don -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make a donation' : 'Toa mchango'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Soutenez financièrement nos projets et aidez-nous à transformer plus de vies.";
                    } elseif (get_current_language() == 'en') {
                        echo "Financially support our projects and help us transform more lives.";
                    } else {
                        echo "Tusaidie kifedha miradi yetu na utusaidie kubadilisha maisha zaidi.";
                    }
                    ?>
                </p>
                <a href="donation.php" class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Donner' : (get_current_language() == 'en' ? 'Donate' : 'Changia'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section Pourquoi nous rejoindre -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Pourquoi nous rejoindre ?' : (get_current_language() == 'en' ? 'Why join us?' : 'Kwa nini ujiunge nasi?'); ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-globe text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Impact réel' : (get_current_language() == 'en' ? 'Real impact' : 'Athari halisi'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Participez à des projets qui transforment concrètement la vie des communautés vulnérables.";
                    } elseif (get_current_language() == 'en') {
                        echo "Participate in projects that concretely transform the lives of vulnerable communities.";
                    } else {
                        echo "Shiriki katika miradi inayobadilisha kwa ukweli maisha ya jamii zilizo hatarini.";
                    }
                    ?>
                </p>
            </div>

            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Développement personnel' : (get_current_language() == 'en' ? 'Personal development' : 'Maendeleo ya kibinafsi'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Développez vos compétences et acquérez une expérience enrichissante dans le domaine humanitaire.";
                    } elseif (get_current_language() == 'en') {
                        echo "Develop your skills and gain enriching experience in the humanitarian field.";
                    } else {
                        echo "Endeleza ujuzi wako na upate uzoefu wa kutajirisha katika uwanda wa kibinadamu.";
                    }
                    ?>
                </p>
            </div>

            <div class="text-center animate-on-scroll">
                <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                    <?php echo get_current_language() == 'fr' ? 'Communauté engagée' : (get_current_language() == 'en' ? 'Committed community' : 'Jamii iliyojitolea'); ?>
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Rejoignez une équipe passionnée et engagée pour la justice sociale et l'égalité.";
                    } elseif (get_current_language() == 'en') {
                        echo "Join a passionate team committed to social justice and equality.";
                    } else {
                        echo "Jiunge na timu yenye shauku na iliyojitolea kwa haki za kijamii na usawa.";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section Formulaire -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div id="form-section" class="hidden">
            <div class="text-center mb-8">
                <h2 id="form-title" class="text-3xl font-bold text-gray-900 dark:text-white mb-4"></h2>
                <p id="form-description" class="text-lg text-gray-600 dark:text-gray-300"></p>
            </div>

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

            <form method="POST" class="space-y-6" id="involvement-form">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="form_type" id="form_type" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo get_current_language() == 'fr' ? 'Nom complet *' : (get_current_language() == 'en' ? 'Full name *' : 'Jina kamili *'); ?>
                        </label>
                        <input type="text" id="name" name="name" required 
                               value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                               class="form-input">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <?php echo get_current_language() == 'fr' ? 'Adresse email *' : (get_current_language() == 'en' ? 'Email address *' : 'Anwani ya barua pepe *'); ?>
                        </label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                               class="form-input">
                    </div>
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo get_current_language() == 'fr' ? 'Numéro de téléphone' : (get_current_language() == 'en' ? 'Phone number' : 'Nambari ya simu'); ?>
                    </label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"
                           class="form-input">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo get_current_language() == 'fr' ? 'Message / Motivation *' : (get_current_language() == 'en' ? 'Message / Motivation *' : 'Ujumbe / Motisha *'); ?>
                    </label>
                    <textarea id="message" name="message" rows="6" required 
                              class="form-textarea"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                </div>
                
                <div class="flex justify-between">
                    <button type="button" onclick="hideForm()" class="btn-secondary">
                        <?php echo get_current_language() == 'fr' ? 'Annuler' : (get_current_language() == 'en' ? 'Cancel' : 'Ghairi'); ?>
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <?php echo get_current_language() == 'fr' ? 'Envoyer la demande' : (get_current_language() == 'en' ? 'Send request' : 'Tuma ombi'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Section Témoignages -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Témoignages' : (get_current_language() == 'en' ? 'Testimonials' : 'Ushahidi'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                <?php echo get_current_language() == 'fr' ? 'Ce que disent nos bénévoles et partenaires' : (get_current_language() == 'en' ? 'What our volunteers and partners say' : 'Kinachosemwa na wafanyakazi wetu wa hiari na washirika'); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 animate-on-scroll">
                <div class="flex items-center mb-4">
                    <img src="assets/images/testimonial-1.jpg" alt="Marie Uwimana" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Marie Uwimana</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Bénévole' : (get_current_language() == 'en' ? 'Volunteer' : 'Mtoaji huduma'); ?>
                        </p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 italic">
                    "<?php 
                    if (get_current_language() == 'fr') {
                        echo "Travailler avec l'OSPDU m'a permis de contribuer concrètement au changement dans ma communauté. C'est une expérience enrichissante.";
                    } elseif (get_current_language() == 'en') {
                        echo "Working with OSPDU has allowed me to contribute concretely to change in my community. It's an enriching experience.";
                    } else {
                        echo "Kufanya kazi na OSPDU kumeruhusu nichangie kwa ukweli mabadiliko katika jamii yangu. Ni uzoefu wa kutajirisha.";
                    }
                    ?>"
                </p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 animate-on-scroll">
                <div class="flex items-center mb-4">
                    <img src="assets/images/testimonial-2.jpg" alt="Jean Baptiste" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Jean Baptiste</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Partenaire' : (get_current_language() == 'en' ? 'Partner' : 'Mshirika'); ?>
                        </p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 italic">
                    "<?php 
                    if (get_current_language() == 'fr') {
                        echo "L'OSPDU est un partenaire fiable avec une vision claire. Ensemble, nous avons pu toucher plus de familles vulnérables.";
                    } elseif (get_current_language() == 'en') {
                        echo "OSPDU is a reliable partner with a clear vision. Together, we have been able to reach more vulnerable families.";
                    } else {
                        echo "OSPDU ni mshirika wa kuaminika mwenye maono wazi. Pamoja, tumeweza kufikia familia zaidi zilizo hatarini.";
                    }
                    ?>"
                </p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 animate-on-scroll">
                <div class="flex items-center mb-4">
                    <img src="assets/images/testimonial-3.jpg" alt="Sarah Mukamana" class="w-12 h-12 rounded-full object-cover mr-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Mukamana</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Membre de l\'équipe' : (get_current_language() == 'en' ? 'Team member' : 'Mwanachama wa timu'); ?>
                        </p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 italic">
                    "<?php 
                    if (get_current_language() == 'fr') {
                        echo "Faire partie de l'équipe OSPDU, c'est participer à une mission qui a du sens. Chaque jour, nous œuvrons pour un monde meilleur.";
                    } elseif (get_current_language() == 'en') {
                        echo "Being part of the OSPDU team means participating in a meaningful mission. Every day, we work for a better world.";
                    } else {
                        echo "Kuwa sehemu ya timu ya OSPDU ni kushiriki katika dhamira yenye maana. Kila siku, tunafanya kazi kwa ajili ya ulimwengu mzuri.";
                    }
                    ?>"
                </p>
            </div>
        </div>
    </div>
</section>

<script>
const formTitles = {
    'volunteer': {
        'fr': 'Devenir bénévole',
        'en': 'Become a volunteer',
        'sw': 'Kuwa mtoaji huduma'
    },
    'partner': {
        'fr': 'Devenir partenaire',
        'en': 'Become a partner',
        'sw': 'Kuwa mshirika'
    },
    'team': {
        'fr': 'Rejoindre l\'équipe',
        'en': 'Join the team',
        'sw': 'Jiunge na timu'
    }
};

const formDescriptions = {
    'volunteer': {
        'fr': 'Remplissez ce formulaire pour nous faire part de votre intérêt à devenir bénévole.',
        'en': 'Fill out this form to let us know about your interest in becoming a volunteer.',
        'sw': 'Jaza fomu hii kutujulisha kuhusu nia yako ya kuwa mtoaji huduma.'
    },
    'partner': {
        'fr': 'Contactez-nous pour explorer les opportunités de partenariat.',
        'en': 'Contact us to explore partnership opportunities.',
        'sw': 'Wasiliana nasi kuchunguza fursa za ushirikiano.'
    },
    'team': {
        'fr': 'Postulez pour rejoindre notre équipe permanente.',
        'en': 'Apply to join our permanent team.',
        'sw': 'Omba kujiunga na timu yetu ya kudumu.'
    }
};

function showForm(type) {
    const lang = '<?php echo get_current_language(); ?>';
    document.getElementById('form_type').value = type;
    document.getElementById('form-title').textContent = formTitles[type][lang];
    document.getElementById('form-description').textContent = formDescriptions[type][lang];
    document.getElementById('form-section').classList.remove('hidden');
    document.getElementById('form-section').scrollIntoView({ behavior: 'smooth' });
}

function hideForm() {
    document.getElementById('form-section').classList.add('hidden');
}

// Validation du formulaire
document.getElementById('involvement-form').addEventListener('submit', function(e) {
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
</script>

<?php include 'includes/footer.php'; ?>