<!DOCTYPE html>
<html lang="<?php echo get_current_language(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo get_site_setting('site_title'); ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : get_site_setting('site_description'); ?>">
    <meta name="keywords" content="OSPDU, humanitaire, développement durable, protection sociale, RDC, Nord-Kivu">
    <meta name="author" content="OSPDU">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:title" content="<?php echo get_site_setting('site_title'); ?>">
    <meta property="og:description" content="<?php echo get_site_setting('site_description'); ?>">
    <meta property="og:image" content="<?php echo SITE_URL . '/' . get_site_setting('site_logo'); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo SITE_URL; ?>">
    <meta property="twitter:title" content="<?php echo get_site_setting('site_title'); ?>">
    <meta property="twitter:description" content="<?php echo get_site_setting('site_description'); ?>">
    <meta property="twitter:image" content="<?php echo SITE_URL . '/' . get_site_setting('site_logo'); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo get_image(get_site_setting('site_favicon'), 'assets/images/favicon.ico'); ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AlertNotifyJS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-blue-dark: #1e3a8a;
            --secondary-blue: #3b82f6;
            --light-blue: #dbeafe;
            --dark-bg: #0f172a;
            --dark-card: #1e293b;
            --dark-text: #f1f5f9;
        }

        .dark {
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }

        .dark .bg-white {
            background-color: var(--dark-card) !important;
        }

        .dark .text-gray-900 {
            color: var(--dark-text) !important;
        }

        .dark .text-gray-600 {
            color: #cbd5e1 !important;
        }

        .dark .border-gray-200 {
            border-color: #374151 !important;
        }

        .primary-blue {
            background-color: var(--primary-blue);
        }

        .primary-blue-dark {
            background-color: var(--primary-blue-dark);
        }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sticky-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .dark .sticky-nav {
            background-color: rgba(15, 23, 42, 0.95);
        }

        .hero-gradient {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: var(--primary-blue-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: var(--primary-blue);
            color: white;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#1e40af',
                        'primary-blue-dark': '#1e3a8a',
                        'secondary-blue': '#3b82f6',
                        'light-blue': '#dbeafe'
                    },
                    fontFamily: {
                        'sans': ['Arial', 'sans-serif'],
                        'serif': ['Times New Roman', 'serif'],
                        'bold': ['Arial Black', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans transition-colors duration-300">
    <!-- Theme Toggle Button -->
    <button id="theme-toggle" class="fixed top-4 right-4 z-50 p-3 bg-primary-blue text-white rounded-full shadow-lg hover:bg-primary-blue-dark transition-all duration-300">
        <i class="fas fa-moon" id="theme-icon"></i>
    </button>

    <!-- Language Selector -->
    <div class="fixed top-4 right-20 z-50">
        <select id="language-selector" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm">
            <option value="fr" <?php echo get_current_language() == 'fr' ? 'selected' : ''; ?>>Français</option>
            <option value="en" <?php echo get_current_language() == 'en' ? 'selected' : ''; ?>>English</option>
            <option value="sw" <?php echo get_current_language() == 'sw' ? 'selected' : ''; ?>>Kiswahili</option>
        </select>
    </div>

    <!-- Navigation -->
    <nav id="main-nav" class="bg-white dark:bg-gray-900 shadow-lg sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center space-x-3">
                        <img src="<?php echo get_image(get_site_setting('site_logo'), 'assets/images/logo.png'); ?>" 
                             alt="OSPDU Logo" class="h-10 w-auto">
                        <div class="hidden md:block">
                            <h1 class="text-xl font-bold text-primary-blue">OSPDU</h1>
                            <p class="text-xs text-gray-600 dark:text-gray-300"><?php echo get_site_setting('site_slogan'); ?></p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300">
                        <?php echo get_current_language() == 'fr' ? 'Accueil' : (get_current_language() == 'en' ? 'Home' : 'Nyumbani'); ?>
                    </a>
                    <a href="qui-sommes-nous.php" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300">
                        <?php echo get_current_language() == 'fr' ? 'Qui sommes-nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi'); ?>
                    </a>
                    <a href="domaines-intervention.php" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300">
                        <?php echo get_current_language() == 'fr' ? 'Domaines' : (get_current_language() == 'en' ? 'Domains' : 'Maeneo'); ?>
                    </a>
                    <div class="relative group">
                        <button class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300 flex items-center">
                            <?php echo get_current_language() == 'fr' ? 'Nos activités' : (get_current_language() == 'en' ? 'Our Activities' : 'Shughuli Zetu'); ?>
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <a href="galerie.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <?php echo get_current_language() == 'fr' ? 'Galerie' : (get_current_language() == 'en' ? 'Gallery' : 'Picha'); ?>
                            </a>
                            <a href="realisations.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <?php echo get_current_language() == 'fr' ? 'Réalisations' : (get_current_language() == 'en' ? 'Achievements' : 'Mafanikio'); ?>
                            </a>
                            <a href="projets.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <?php echo get_current_language() == 'fr' ? 'Projets' : (get_current_language() == 'en' ? 'Projects' : 'Miradi'); ?>
                            </a>
                        </div>
                    </div>
                    <a href="actualites.php" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300">
                        <?php echo get_current_language() == 'fr' ? 'Actualités' : (get_current_language() == 'en' ? 'News' : 'Habari'); ?>
                    </a>
                    <a href="contact.php" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue transition-colors duration-300">
                        <?php echo get_current_language() == 'fr' ? 'Contact' : (get_current_language() == 'en' ? 'Contact' : 'Mawasiliano'); ?>
                    </a>
                    <a href="s-impliquer.php" class="btn-primary">
                        <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get Involved' : 'Jiunge Nasi'); ?>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Accueil' : (get_current_language() == 'en' ? 'Home' : 'Nyumbani'); ?>
                </a>
                <a href="qui-sommes-nous.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Qui sommes-nous' : (get_current_language() == 'en' ? 'About Us' : 'Kuhusu Sisi'); ?>
                </a>
                <a href="domaines-intervention.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Domaines' : (get_current_language() == 'en' ? 'Domains' : 'Maeneo'); ?>
                </a>
                <a href="galerie.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Galerie' : (get_current_language() == 'en' ? 'Gallery' : 'Picha'); ?>
                </a>
                <a href="actualites.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Actualités' : (get_current_language() == 'en' ? 'News' : 'Habari'); ?>
                </a>
                <a href="contact.php" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-blue">
                    <?php echo get_current_language() == 'fr' ? 'Contact' : (get_current_language() == 'en' ? 'Contact' : 'Mawasiliano'); ?>
                </a>
                <a href="s-impliquer.php" class="block px-3 py-2 text-primary-blue font-semibold">
                    <?php echo get_current_language() == 'fr' ? 'S\'impliquer' : (get_current_language() == 'en' ? 'Get Involved' : 'Jiunge Nasi'); ?>
                </a>
            </div>
        </div>
    </nav>