<!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- À propos -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="<?php echo get_image(get_site_setting('site_logo'), 'assets/images/logo.png'); ?>" 
                             alt="OSPDU Logo" class="h-8 w-auto">
                        <h3 class="text-xl font-bold">OSPDU</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        <?php 
                        if (get_current_language() == 'fr') {
                            echo "Organe Solidaire pour la Protection Sociale et le Développement Durable. Engagé pour un monde équitable.";
                        } elseif (get_current_language() == 'en') {
                            echo "Solidarity Organization for Social Protection and Sustainable Development. Committed to an equitable world.";
                        } else {
                            echo "Shirika la Umoja kwa Ulinzi wa Kijamii na Maendeleo Endelevu. Tumejitolea kwa ulimwengu wa haki.";
                        }
                        ?>
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Liens rapides -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">
                        <?php echo get_current_language() == 'fr' ? 'Liens rapides' : (get_current_language() == 'en' ? 'Quick Links' : 'Viungo vya Haraka'); ?>
                    </h3>
                    <ul class="space-y-2">
                        <li><a href="qui-sommes-nous.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Qui sommes-nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi'); ?>
                        </a></li>
                        <li><a href="domaines-intervention.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Nos domaines' : (get_current_language() == 'en' ? 'Our Domains' : 'Maeneo Yetu'); ?>
                        </a></li>
                        <li><a href="projets.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Nos projets' : (get_current_language() == 'en' ? 'Our Projects' : 'Miradi Yetu'); ?>
                        </a></li>
                        <li><a href="actualites.php" class="text-gray-300 hover:text-white transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Actualités' : (get_current_language() == 'en' ? 'News' : 'Habari'); ?>
                        </a></li>
                    </ul>
                </div>

                <!-- Domaines d'intervention -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">
                        <?php echo get_current_language() == 'fr' ? 'Nos domaines' : (get_current_language() == 'en' ? 'Our Domains' : 'Maeneo Yetu'); ?>
                    </h3>
                    <ul class="space-y-2 text-sm">
                        <li class="text-gray-300">
                            <?php echo get_current_language() == 'fr' ? 'Éducation & Formation' : (get_current_language() == 'en' ? 'Education & Training' : 'Elimu na Mafunzo'); ?>
                        </li>
                        <li class="text-gray-300">
                            <?php echo get_current_language() == 'fr' ? 'Santé' : (get_current_language() == 'en' ? 'Health' : 'Afya'); ?>
                        </li>
                        <li class="text-gray-300">
                            <?php echo get_current_language() == 'fr' ? 'Protection de l\'enfant' : (get_current_language() == 'en' ? 'Child Protection' : 'Ulinzi wa Watoto'); ?>
                        </li>
                        <li class="text-gray-300">
                            <?php echo get_current_language() == 'fr' ? 'Environnement' : (get_current_language() == 'en' ? 'Environment' : 'Mazingira'); ?>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">
                        <?php echo get_current_language() == 'fr' ? 'Contact' : (get_current_language() == 'en' ? 'Contact' : 'Mawasiliano'); ?>
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-primary-blue mt-1"></i>
                            <span class="text-gray-300"><?php echo get_site_setting('contact_address'); ?></span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone text-primary-blue"></i>
                            <span class="text-gray-300"><?php echo get_site_setting('contact_phone'); ?></span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-primary-blue"></i>
                            <span class="text-gray-300"><?php echo get_site_setting('contact_email'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ligne de séparation -->
            <div class="border-t border-gray-700 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-300 text-sm">
                        &copy; <?php echo date('Y'); ?> OSPDU. 
                        <?php echo get_current_language() == 'fr' ? 'Tous droits réservés.' : (get_current_language() == 'en' ? 'All rights reserved.' : 'Haki zote zimehifadhiwa.'); ?>
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Politique de confidentialité' : (get_current_language() == 'en' ? 'Privacy Policy' : 'Sera ya Faragha'); ?>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white text-sm transition-colors duration-300">
                            <?php echo get_current_language() == 'fr' ? 'Conditions d\'utilisation' : (get_current_language() == 'en' ? 'Terms of Use' : 'Masharti ya Matumizi'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        // Configuration d'Alertify
        alertify.set('notifier','position', 'top-right');
        alertify.set('notifier','delay', 5);

        // Gestion du thème sombre/clair
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        // Vérifier le thème sauvegardé
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            html.classList.toggle('dark', savedTheme === 'dark');
            updateThemeIcon(savedTheme === 'dark');
        }

        themeToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon(isDark);
            
            // Sauvegarder en base de données
            fetch('includes/save-theme.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme: isDark ? 'dark' : 'light' })
            });
        });

        function updateThemeIcon(isDark) {
            themeIcon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        }

        // Gestion du menu mobile
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Gestion du changement de langue
        const languageSelector = document.getElementById('language-selector');
        languageSelector.addEventListener('change', (e) => {
            const selectedLang = e.target.value;
            
            // Envoyer la requête pour changer la langue
            fetch('includes/change-language.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ language: selectedLang })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        });

        // Navigation sticky
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 100) {
                nav.classList.add('sticky-nav');
            } else {
                nav.classList.remove('sticky-nav');
            }
        });

        // Animations au scroll
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

        // Observer tous les éléments avec la classe 'animate-on-scroll'
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Lazy loading des images
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });

        // Fonction utilitaire pour les requêtes AJAX
        function makeRequest(url, method = 'GET', data = null) {
            return fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: data ? JSON.stringify(data) : null
            })
            .then(response => response.json())
            .catch(error => {
                console.error('Erreur:', error);
                alertify.error('Une erreur est survenue');
            });
        }

        // Fonction pour afficher les notifications
        function showNotification(message, type = 'success') {
            switch(type) {
                case 'success':
                    alertify.success(message);
                    break;
                case 'error':
                    alertify.error(message);
                    break;
                case 'warning':
                    alertify.warning(message);
                    break;
                default:
                    alertify.message(message);
            }
        }

        // Fonction pour confirmer une action
        function confirmAction(message, callback) {
            alertify.confirm(message, callback, function() {
                // Annulation
            });
        }

        // Gestion des formulaires avec validation
        function validateForm(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            return isValid;
        }

        // Fonction pour prévisualiser les images
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Initialisation des DataTables
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.data-table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/<?php echo get_current_language() == "fr" ? "fr-FR" : (get_current_language() == "en" ? "en-GB" : "sw"); ?>.json'
                    },
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'desc']]
                });
            }
        });
    </script>
</body>
</html>