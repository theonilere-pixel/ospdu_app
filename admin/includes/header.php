<?php
$user = getUserData();
?>

<header class="bg-gray-800 border-b border-gray-700 px-6 py-4">
    <div class="flex items-center justify-between">
        <!-- Breadcrumb / Back Button -->
        <div class="flex items-center">
            <button onclick="history.back()" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg mr-4 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-2xl mx-8">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="globalSearch" placeholder="Rechercher..." 
                       class="w-full bg-gray-700 border border-gray-600 rounded-full py-3 pl-10 pr-4 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent search-bar">
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4">
            <!-- Retour au site -->
            <a href="https://www.istdrv-ac.org" class="text-gray-400 hover:text-white transition-colors">
                Retour au site
            </a>

            <!-- Dark/Light Mode Toggle -->
           <!-- <div class="flex items-center">
                <!-- <span class="mr-3 text-sm text-gray-400">Tuombe</span>
                <button id="themeToggle" class="relative inline-flex items-center h-8 w-14 bg-blue-600 rounded-full transition-colors duration-300 focus:outline-none">
                    <span class="sr-only">Toggle theme</span>
                    <span id="toggleCircle" class="inline-block w-6 h-6 bg-white rounded-full transform transition-transform duration-300 translate-x-7"></span>
                </button>
            </div>-->

            <!-- User Avatar -->
            <div class="relative">
                <button onclick="openProfileModal()" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:ring-2 hover:ring-blue-400 transition-all">
                    <i class="fas fa-user text-white"></i>
                </button>
            </div>
        </div>
    </div>
</header>