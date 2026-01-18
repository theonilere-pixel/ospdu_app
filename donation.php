<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$page_title = get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make a Donation' : 'Toa Mchango');
$page_description = get_current_language() == 'fr' ? 'Soutenez notre mission en faisant un don à l\'OSPDU' : (get_current_language() == 'en' ? 'Support our mission by making a donation to OSPDU' : 'Unga mkono dhamira yetu kwa kutoa mchango kwa OSPDU');

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-gradient py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 text-shadow">
            <?php echo get_current_language() == 'fr' ? 'Faire un don' : (get_current_language() == 'en' ? 'Make a Donation' : 'Toa Mchango'); ?>
        </h1>
        <p class="text-xl text-white max-w-3xl mx-auto text-shadow">
            <?php 
            if (get_current_language() == 'fr') {
                echo "Votre générosité nous permet de continuer notre mission et de transformer plus de vies dans les communautés vulnérables.";
            } elseif (get_current_language() == 'en') {
                echo "Your generosity allows us to continue our mission and transform more lives in vulnerable communities.";
            } else {
                echo "Ukarimu wako unaturuhusu kuendelea na dhamira yetu na kubadilisha maisha zaidi katika jamii zilizo hatarini.";
            }
            ?>
        </p>
    </div>
</section>

<!-- Section Impact des dons -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'L\'impact de votre don' : (get_current_language() == 'en' ? 'The impact of your donation' : 'Athari ya mchango wako'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Chaque don, petit ou grand, contribue directement à nos projets et fait une différence réelle dans la vie des personnes que nous servons.";
                } elseif (get_current_language() == 'en') {
                    echo "Every donation, small or large, contributes directly to our projects and makes a real difference in the lives of the people we serve.";
                } else {
                    echo "Kila mchango, mdogo au mkubwa, unachangia moja kwa moja miradi yetu na kuleta mabadiliko halisi katika maisha ya watu tunaowatumiikia.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 25$ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-primary-blue mb-2">25$</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Fournitures scolaires pour un enfant pendant un trimestre";
                    } elseif (get_current_language() == 'en') {
                        echo "School supplies for one child for a quarter";
                    } else {
                        echo "Vifaa vya shule kwa mtoto mmoja kwa robo mwaka";
                    }
                    ?>
                </p>
            </div>

            <!-- 50$ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-medkit text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-primary-blue mb-2">50$</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Soins de santé de base pour une famille pendant un mois";
                    } elseif (get_current_language() == 'en') {
                        echo "Basic healthcare for a family for one month";
                    } else {
                        echo "Huduma za afya za msingi kwa familia kwa mwezi mmoja";
                    }
                    ?>
                </p>
            </div>

            <!-- 100$ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-seedling text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-primary-blue mb-2">100$</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Kit de démarrage agricole pour une famille";
                    } elseif (get_current_language() == 'en') {
                        echo "Agricultural starter kit for a family";
                    } else {
                        echo "Kifurushi cha kuanza kilimo kwa familia";
                    }
                    ?>
                </p>
            </div>

            <!-- 250$ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center card-hover animate-on-scroll">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-purple-600 dark:text-purple-400 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-primary-blue mb-2">250$</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    <?php 
                    if (get_current_language() == 'fr') {
                        echo "Formation professionnelle pour une femme";
                    } elseif (get_current_language() == 'en') {
                        echo "Professional training for a woman";
                    } else {
                        echo "Mafunzo ya kitaaluma kwa mwanamke";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Section Méthodes de don -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Comment faire un don' : (get_current_language() == 'en' ? 'How to donate' : 'Jinsi ya kutoa mchango'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                <?php echo get_current_language() == 'fr' ? 'Choisissez la méthode qui vous convient le mieux' : (get_current_language() == 'en' ? 'Choose the method that suits you best' : 'Chagua njia inayokufaa zaidi'); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Don en ligne -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 animate-on-scroll">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                        <?php echo get_current_language() == 'fr' ? 'Don en ligne' : (get_current_language() == 'en' ? 'Online donation' : 'Mchango mtandaoni'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php echo get_current_language() == 'fr' ? 'Rapide, sécurisé et pratique' : (get_current_language() == 'en' ? 'Fast, secure and convenient' : 'Haraka, salama na rahisi'); ?>
                    </p>
                </div>

                <!-- Montants prédéfinis -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <button class="donation-amount border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-primary-blue hover:bg-primary-blue hover:text-white transition-all duration-300" data-amount="25">
                        25$
                    </button>
                    <button class="donation-amount border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-primary-blue hover:bg-primary-blue hover:text-white transition-all duration-300" data-amount="50">
                        50$
                    </button>
                    <button class="donation-amount border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-primary-blue hover:bg-primary-blue hover:text-white transition-all duration-300" data-amount="100">
                        100$
                    </button>
                    <button class="donation-amount border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center hover:border-primary-blue hover:bg-primary-blue hover:text-white transition-all duration-300" data-amount="250">
                        250$
                    </button>
                </div>

                <!-- Montant personnalisé -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <?php echo get_current_language() == 'fr' ? 'Ou entrez un montant personnalisé' : (get_current_language() == 'en' ? 'Or enter a custom amount' : 'Au ingiza kiasi cha kibinafsi'); ?>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="custom-amount" class="form-input pl-8" placeholder="0.00" min="1" step="0.01">
                    </div>
                </div>

                <button onclick="processDonation()" class="btn-primary w-full text-lg">
                    <i class="fas fa-heart mr-2"></i>
                    <?php echo get_current_language() == 'fr' ? 'Faire un don maintenant' : (get_current_language() == 'en' ? 'Donate now' : 'Changia sasa'); ?>
                </button>

                <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-4">
                    <?php echo get_current_language() == 'fr' ? 'Paiement sécurisé via PayPal ou carte bancaire' : (get_current_language() == 'en' ? 'Secure payment via PayPal or credit card' : 'Malipo salama kupitia PayPal au kadi ya benki'); ?>
                </p>
            </div>

            <!-- Don par virement -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8 animate-on-scroll">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-university text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                        <?php echo get_current_language() == 'fr' ? 'Virement bancaire' : (get_current_language() == 'en' ? 'Bank transfer' : 'Uhamisho wa benki'); ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php echo get_current_language() == 'fr' ? 'Pour les dons importants' : (get_current_language() == 'en' ? 'For large donations' : 'Kwa michango mikubwa'); ?>
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Nom du compte' : (get_current_language() == 'en' ? 'Account name' : 'Jina la akaunti'); ?>
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">OSPDU</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Numéro de compte' : (get_current_language() == 'en' ? 'Account number' : 'Nambari ya akaunti'); ?>
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">1234567890</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
                            <?php echo get_current_language() == 'fr' ? 'Banque' : (get_current_language() == 'en' ? 'Bank' : 'Benki'); ?>
                        </dt>
                        <dd class="text-sm text-gray-900 dark:text-white">Banque Commerciale du Congo</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">SWIFT</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">BCCOCDKI</dd>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <i class="fas fa-info-circle mr-2"></i>
                        <?php 
                        if (get_current_language() == 'fr') {
                            echo "Merci de nous envoyer un email avec la preuve de virement pour confirmation.";
                        } elseif (get_current_language() == 'en') {
                            echo "Please send us an email with proof of transfer for confirmation.";
                        } else {
                            echo "Tafadhali tutumie barua pepe na uthibitisho wa uhamisho kwa uthibitisho.";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Mobile Money -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Mobile Money' : (get_current_language() == 'en' ? 'Mobile Money' : 'Pesa za Simu'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                <?php echo get_current_language() == 'fr' ? 'Faites un don via votre téléphone mobile' : (get_current_language() == 'en' ? 'Make a donation via your mobile phone' : 'Toa mchango kupitia simu yako ya mkononi'); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- M-Pesa -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">M-Pesa</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">+243 XXX XXX XXX</p>
                <button class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Envoyer' : (get_current_language() == 'en' ? 'Send' : 'Tuma'); ?>
                </button>
            </div>

            <!-- Orange Money -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-orange-600 dark:text-orange-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Orange Money</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">+243 XXX XXX XXX</p>
                <button class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Envoyer' : (get_current_language() == 'en' ? 'Send' : 'Tuma'); ?>
                </button>
            </div>

            <!-- Airtel Money -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center animate-on-scroll">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Airtel Money</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">+243 XXX XXX XXX</p>
                <button class="btn-primary w-full">
                    <?php echo get_current_language() == 'fr' ? 'Envoyer' : (get_current_language() == 'en' ? 'Send' : 'Tuma'); ?>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Section Transparence -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?php echo get_current_language() == 'fr' ? 'Transparence et responsabilité' : (get_current_language() == 'en' ? 'Transparency and accountability' : 'Uwazi na uwajibikaji'); ?>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Nous nous engageons à utiliser vos dons de manière responsable et transparente.";
                } elseif (get_current_language() == 'en') {
                    echo "We are committed to using your donations responsibly and transparently.";
                } else {
                    echo "Tumejitolea kutumia michango yenu kwa uwajibikaji na uwazi.";
                }
                ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">85%</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Directement aux programmes' : (get_current_language() == 'en' ? 'Directly to programs' : 'Moja kwa moja kwa programu'); ?>
                </div>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">10%</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Frais administratifs' : (get_current_language() == 'en' ? 'Administrative costs' : 'Gharama za utawala'); ?>
                </div>
            </div>
            
            <div class="text-center animate-on-scroll">
                <div class="text-4xl font-bold text-primary-blue mb-2">5%</div>
                <div class="text-gray-600 dark:text-gray-300">
                    <?php echo get_current_language() == 'fr' ? 'Collecte de fonds' : (get_current_language() == 'en' ? 'Fundraising' : 'Ukusanyaji wa fedha'); ?>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center animate-on-scroll">
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                <?php 
                if (get_current_language() == 'fr') {
                    echo "Nous publions régulièrement nos rapports financiers pour assurer une transparence totale.";
                } elseif (get_current_language() == 'en') {
                    echo "We regularly publish our financial reports to ensure complete transparency.";
                } else {
                    echo "Tunachapisha ripoti zetu za kifedha mara kwa mara kuhakikisha uwazi kamili.";
                }
                ?>
            </p>
            <a href="#" class="text-primary-blue hover:text-primary-blue-dark font-semibold">
                <?php echo get_current_language() == 'fr' ? 'Voir nos rapports financiers' : (get_current_language() == 'en' ? 'View our financial reports' : 'Ona ripoti zetu za kifedha'); ?>
                <i class="fas fa-external-link-alt ml-1"></i>
            </a>
        </div>
    </div>
</section>

<script>
let selectedAmount = 0;

// Gestion des montants prédéfinis
document.querySelectorAll('.donation-amount').forEach(button => {
    button.addEventListener('click', function() {
        // Retirer la sélection précédente
        document.querySelectorAll('.donation-amount').forEach(btn => {
            btn.classList.remove('border-primary-blue', 'bg-primary-blue', 'text-white');
            btn.classList.add('border-gray-300', 'dark:border-gray-600');
        });
        
        // Sélectionner le nouveau montant
        this.classList.remove('border-gray-300', 'dark:border-gray-600');
        this.classList.add('border-primary-blue', 'bg-primary-blue', 'text-white');
        
        selectedAmount = parseInt(this.dataset.amount);
        document.getElementById('custom-amount').value = '';
    });
});

// Gestion du montant personnalisé
document.getElementById('custom-amount').addEventListener('input', function() {
    if (this.value) {
        // Désélectionner les montants prédéfinis
        document.querySelectorAll('.donation-amount').forEach(btn => {
            btn.classList.remove('border-primary-blue', 'bg-primary-blue', 'text-white');
            btn.classList.add('border-gray-300', 'dark:border-gray-600');
        });
        
        selectedAmount = parseFloat(this.value);
    }
});

function processDonation() {
    const customAmount = document.getElementById('custom-amount').value;
    const finalAmount = customAmount ? parseFloat(customAmount) : selectedAmount;
    
    if (!finalAmount || finalAmount <= 0) {
        showNotification('<?php echo get_current_language() == "fr" ? "Veuillez sélectionner ou saisir un montant." : (get_current_language() == "en" ? "Please select or enter an amount." : "Tafadhali chagua au ingiza kiasi."); ?>', 'error');
        return;
    }
    
    // Ici, vous intégreriez votre système de paiement (PayPal, Stripe, etc.)
    showNotification('<?php echo get_current_language() == "fr" ? "Redirection vers le système de paiement..." : (get_current_language() == "en" ? "Redirecting to payment system..." : "Inaelekeza kwenye mfumo wa malipo..."); ?>', 'info');
    
    // Simulation de redirection vers PayPal
    setTimeout(() => {
        // window.location.href = `https://www.paypal.com/donate?amount=${finalAmount}&currency=USD&business=donations@ospdu.org`;
        showNotification('<?php echo get_current_language() == "fr" ? "Fonctionnalité de paiement à intégrer" : (get_current_language() == "en" ? "Payment functionality to be integrated" : "Utendaji wa malipo utaunganishwa"); ?>', 'info');
    }, 2000);
}
</script>

<?php include 'includes/footer.php'; ?>