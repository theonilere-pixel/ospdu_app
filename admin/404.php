<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .bounce-slow {
            animation: bounce 2s infinite;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <!-- 404 Animation -->
        <div class="mb-8">
            <div class="relative">
                <!-- Background circles -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-64 h-64 bg-blue-600 rounded-full opacity-20 animate-pulse"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-48 h-48 bg-cyan-500 rounded-full opacity-30 animate-ping"></div>
                </div>
                
                <!-- 404 Text -->
                <div class="relative z-10 floating">
                    <h1 class="text-9xl font-bold gradient-bg bg-clip-text text-transparent">
                        404
                    </h1>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div class="max-w-md mx-auto mb-8">
            <div class="bg-gray-800 rounded-2xl p-8 shadow-2xl border border-gray-700">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mx-auto mb-4 bounce-slow">
                        <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Page non trouvée</h2>
                    <p class="text-gray-400">
                        Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
                    </p>
                </div>
                
                <!-- Suggestions -->
                <div class="space-y-3 mb-6">
                    <p class="text-sm text-gray-500">Que souhaitez-vous faire ?</p>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="index.php" 
                           class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group">
                            <i class="fas fa-home mr-2 group-hover:scale-110 transition-transform"></i>
                            Retour au tableau de bord
                        </a>
                        <button onclick="history.back()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center group">
                            <i class="fas fa-arrow-left mr-2 group-hover:scale-110 transition-transform"></i>
                            Page précédente
                        </button>
                    </div>
                </div>
                
                <!-- Search -->
                <div class="border-t border-gray-700 pt-6">
                    <p class="text-sm text-gray-500 mb-3">Ou recherchez ce que vous cherchez :</p>
                    <form action="index.php" method="GET" class="flex space-x-2">
                        <input type="hidden" name="page" value="search">
                        <input type="text" name="q" placeholder="Rechercher..." 
                               class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Fun Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-2xl mx-auto mb-8">
            <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Utilisateurs</h3>
                    <p class="text-gray-400">Gérer les comptes</p>
                    <a href="index.php?table=users" class="text-blue-400 hover:text-blue-300 text-sm">
                        Accéder <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Configuration</h3>
                    <p class="text-gray-400">Paramètres système</p>
                    <a href="index.php?page=settings" class="text-blue-400 hover:text-blue-300 text-sm">
                        Accéder <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Statistiques</h3>
                    <p class="text-gray-400">Voir les données</p>
                    <a href="index.php?page=dashboard" class="text-blue-400 hover:text-blue-300 text-sm">
                        Accéder <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-500 text-sm">
            <p>© 2025 iAbstrack Dashboard. Tous droits réservés.</p>
            <p class="mt-2">
                Besoin d'aide ? 
                <a href="mailto:support@iabstrack.com" class="text-blue-400 hover:text-blue-300">
                    Contactez le support
                </a>
            </p>
        </div>
    </div>

    <!-- Background animation -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-10 left-10 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
        <div class="absolute top-20 right-20 w-1 h-1 bg-cyan-500 rounded-full animate-ping"></div>
        <div class="absolute bottom-20 left-20 w-3 h-3 bg-purple-500 rounded-full animate-bounce"></div>
        <div class="absolute bottom-10 right-10 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
    </div>
</body>
</html>