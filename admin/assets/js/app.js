// Theme Management
let currentTheme = localStorage.getItem('theme') || 'dark';

function initTheme() {
    const html = document.documentElement;
    const toggleButton = document.getElementById('themeToggle');
    const toggleCircle = document.getElementById('toggleCircle');
    
    if (currentTheme === 'dark') {
        html.classList.add('dark');
        toggleButton.classList.add('bg-blue-600');
        toggleButton.classList.remove('bg-gray-400');
        toggleCircle.classList.add('translate-x-7');
        toggleCircle.classList.remove('translate-x-1');
    } else {
        html.classList.remove('dark');
        toggleButton.classList.remove('bg-blue-600');
        toggleButton.classList.add('bg-gray-400');
        toggleCircle.classList.remove('translate-x-7');
        toggleCircle.classList.add('translate-x-1');
    }
}

function toggleTheme() {
    const html = document.documentElement;
    const toggleButton = document.getElementById('themeToggle');
    const toggleCircle = document.getElementById('toggleCircle');
    
    if (currentTheme === 'dark') {
        // Switch to light
        currentTheme = 'light';
        html.classList.remove('dark');
        toggleButton.classList.remove('bg-blue-600');
        toggleButton.classList.add('bg-gray-400');
        toggleCircle.classList.remove('translate-x-7');
        toggleCircle.classList.add('translate-x-1');
    } else {
        // Switch to dark
        currentTheme = 'dark';
        html.classList.add('dark');
        toggleButton.classList.add('bg-blue-600');
        toggleButton.classList.remove('bg-gray-400');
        toggleCircle.classList.add('translate-x-7');
        toggleCircle.classList.remove('translate-x-1');
    }
    
    localStorage.setItem('theme', currentTheme);
}

// Sidebar Management
let sidebarExpanded = localStorage.getItem('sidebarExpanded') !== 'false';

function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (!sidebarExpanded) {
        collapseSidebar();
    }
}

function toggleSidebar() {
    if (sidebarExpanded) {
        collapseSidebar();
    } else {
        expandSidebar();
    }
}

function collapseSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    
    sidebar.classList.add('w-16');
    sidebar.classList.remove('w-64');
    
    sidebarTexts.forEach(text => {
        text.style.display = 'none';
    });
    
    const toggleIcon = sidebarToggle.querySelector('i');
    toggleIcon.classList.remove('fa-chevron-left');
    toggleIcon.classList.add('fa-chevron-right');
    
    sidebarExpanded = false;
    localStorage.setItem('sidebarExpanded', 'false');
}

function expandSidebar() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    
    sidebar.classList.remove('w-16');
    sidebar.classList.add('w-64');
    
    setTimeout(() => {
        sidebarTexts.forEach(text => {
            text.style.display = 'block';
        });
    }, 150);
    
    const toggleIcon = sidebarToggle.querySelector('i');
    toggleIcon.classList.add('fa-chevron-left');
    toggleIcon.classList.remove('fa-chevron-right');
    
    sidebarExpanded = true;
    localStorage.setItem('sidebarExpanded', 'true');
}

// Global Search
function initGlobalSearch() {
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            performGlobalSearch(searchTerm);
        });
    }
}

function performGlobalSearch(term) {
    if (term.length < 2) return;
    
    // Recherche dans les éléments visibles de la page
    const searchableElements = document.querySelectorAll('[data-searchable]');
    
    searchableElements.forEach(element => {
        const text = element.textContent.toLowerCase();
        const parent = element.closest('tr') || element.closest('.searchable-item');
        
        if (text.includes(term)) {
            if (parent) parent.style.display = '';
            element.classList.add('bg-yellow-200', 'dark:bg-yellow-800');
        } else {
            if (parent) parent.style.display = 'none';
            element.classList.remove('bg-yellow-200', 'dark:bg-yellow-800');
        }
    });
}

// Modal Management
function openProfileModal() {
    const modal = document.getElementById('profileModal');
    modal.classList.remove('hidden');
    modal.querySelector('.transform').classList.remove('scale-95');
    modal.querySelector('.transform').classList.add('scale-100');
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    modal.querySelector('.transform').classList.add('scale-95');
    modal.querySelector('.transform').classList.remove('scale-100');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    
    const colors = {
        success: 'bg-green-600 text-white',
        error: 'bg-red-600 text-white',
        warning: 'bg-yellow-600 text-white',
        info: 'bg-blue-600 text-white'
    };
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    notification.className += ` ${colors[type]}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icons[type]} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 5000);
}

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    return isValid;
}

// Image Handling
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const image = document.getElementById(previewId.replace('Preview', 'Image'));
            if (image && preview) {
                image.src = e.target.result;
                preview.classList.remove('hidden');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview(fieldName) {
    const input = document.getElementById(fieldName);
    const preview = document.getElementById(fieldName + 'Preview');
    if (input) input.value = '';
    if (preview) preview.classList.add('hidden');
}

// Responsive Menu
function initResponsiveMenu() {
    const mobileMenuButton = document.createElement('button');
    mobileMenuButton.id = 'mobileMenuButton';
    mobileMenuButton.className = 'lg:hidden fixed top-4 left-4 z-50 bg-gray-800 text-white p-2 rounded-lg';
    mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
    mobileMenuButton.onclick = toggleMobileSidebar;
    
    document.body.appendChild(mobileMenuButton);
}

function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobileOverlay');
    
    if (!overlay) {
        const newOverlay = document.createElement('div');
        newOverlay.id = 'mobileOverlay';
        newOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden';
        newOverlay.onclick = closeMobileSidebar;
        document.body.appendChild(newOverlay);
    }
    
    sidebar.classList.toggle('hidden');
    document.getElementById('mobileOverlay').classList.toggle('hidden');
}

function closeMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobileOverlay');
    
    sidebar.classList.add('hidden');
    overlay.classList.add('hidden');
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initTheme();
    initSidebar();
    initGlobalSearch();
    initResponsiveMenu();
    
    // Event listeners
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
    
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        const profileModal = document.getElementById('profileModal');
        if (profileModal && e.target === profileModal) {
            closeProfileModal();
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            // Desktop - ensure sidebar is visible and remove mobile overlay
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.remove('hidden');
            if (overlay) overlay.classList.add('hidden');
        } else {
            // Mobile - hide sidebar by default
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('hidden');
        }
    });
    
    // Check for URL parameters to show notifications
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === '1') {
        showNotification('Opération réalisée avec succès !', 'success');
    }
    if (urlParams.get('error') === 'not_found') {
        showNotification('Élément non trouvé', 'error');
    }
    if (urlParams.get('error') === 'delete_failed') {
        showNotification('Erreur lors de la suppression', 'error');
    }
    if (urlParams.get('success') === 'deleted') {
        showNotification('Élément supprimé avec succès', 'success');
    }
});

// Utility functions
function confirmDelete(table, id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
        window.location.href = `?table=${table}&action=delete&id=${id}`;
    }
}

function goBack() {
    history.back();
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showNotification('Copié dans le presse-papier !', 'success');
    });
}

// Export for global use
window.showNotification = showNotification;
window.confirmDelete = confirmDelete;
window.previewImage = previewImage;
window.removePreview = removePreview;
window.openProfileModal = openProfileModal;
window.closeProfileModal = closeProfileModal;