<?php
$user = getUserData();
$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($email) || empty($first_name) || empty($last_name)) {
        $error = 'Tous les champs obligatoires doivent être remplis';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format d\'email invalide';
    } elseif (!empty($new_password) && strlen($new_password) < 6) {
        $error = 'Le nouveau mot de passe doit contenir au moins 6 caractères';
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } else {
        // Vérifier si l'username ou email existe déjà pour un autre utilisateur
        $stmt = $pdo->prepare("SELECT id FROM user WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $user['id']]);
        
        if ($stmt->fetch()) {
            $error = 'Ce nom d\'utilisateur ou email est déjà utilisé par un autre compte';
        } else {
            // Préparer les champs à mettre à jour
            $fields = ['username', 'email', 'first_name', 'last_name'];
            $values = [$username, $email, $first_name, $last_name];
            
            // Gestion de l'image de profil
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Supprimer l'ancienne photo si elle existe
                if (!empty($user['photo'])) {
                    deleteImage($user['photo']);
                }
                
                $uploadResult = uploadImage($_FILES['photo']);
                if ($uploadResult['success']) {
                    $fields[] = 'photo';
                    $values[] = $uploadResult['filename'];
                } else {
                    $error = $uploadResult['message'];
                }
            }
            
            // Gestion du mot de passe
            if (!empty($new_password)) {
                $fields[] = 'password';
                $values[] = password_hash($new_password, PASSWORD_DEFAULT);
            }
            
            if (empty($error)) {
                $sql = "UPDATE user SET " . implode(' = ?, ', $fields) . " = ?, updated_at = NOW() WHERE id = ?";
                $values[] = $user['id'];
                
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute($values)) {
                    $success = 'Profil mis à jour avec succès !';
                    // Recharger les données utilisateur
                    $user = getUserData();
                } else {
                    $error = 'Erreur lors de la mise à jour du profil';
                }
            }
        }
    }
}
?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Mon Profil</h1>
        <p class="text-gray-400">Gérer les informations de votre compte</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-gray-800 rounded-2xl p-6">
            <div class="text-center">
                <div class="relative inline-block mb-4">
                    <?php if (!empty($user['photo'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de profil" 
                             class="w-32 h-32 object-cover rounded-full mx-auto">
                    <?php else: ?>
                        <div class="w-32 h-32 bg-blue-600 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-user text-4xl text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h3 class="text-xl font-semibold text-white mb-2">
                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                </h3>
                <p class="text-gray-400 mb-4"><?php echo htmlspecialchars($user['email']); ?></p>
                
                <div class="space-y-2">
                    <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full">
                        <?php echo ucfirst($user['role']); ?>
                    </span>
                    <span class="inline-block px-3 py-1 bg-green-600 text-white text-sm rounded-full">
                        <?php echo ucfirst($user['status']); ?>
                    </span>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-700 text-sm text-gray-400">
                    <div class="flex items-center justify-center mb-2">
                        <i class="fas fa-calendar mr-2"></i>
                        Inscrit le <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                    </div>
                    <?php if ($user['updated_at'] !== $user['created_at']): ?>
                        <div class="flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i>
                            Modifié le <?php echo date('d/m/Y', strtotime($user['updated_at'])); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2 bg-gray-800 rounded-2xl p-6">
            <?php if ($error): ?>
                <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-300 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-600 bg-opacity-20 border border-green-600 text-green-300 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Photo de profil -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-camera mr-2"></i>Photo de profil
                    </label>
                    <div class="space-y-4">
                        <input type="file" id="photo" name="photo" accept="image/*" 
                               onchange="previewProfileImage(this)"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <div id="photoPreview" class="hidden">
                            <div class="relative inline-block">
                                <img id="photoImage" src="" alt="Preview" class="w-24 h-24 object-cover rounded-full">
                                <button type="button" onclick="removePhotoPreview()" 
                                        class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center transition-colors">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations personnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2"></i>Prénom <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name" required
                               value="<?php echo htmlspecialchars($user['first_name']); ?>"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2"></i>Nom <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name" required
                               value="<?php echo htmlspecialchars($user['last_name']); ?>"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-at mr-2"></i>Nom d'utilisateur <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="username" name="username" required
                               value="<?php echo htmlspecialchars($user['username']); ?>"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo htmlspecialchars($user['email']); ?>"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Changement de mot de passe -->
                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">
                        <i class="fas fa-lock mr-2"></i>Changer le mot de passe
                    </h3>
                    <p class="text-gray-400 text-sm mb-4">Laissez vide pour conserver le mot de passe actuel</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-300 mb-2">
                                Nouveau mot de passe
                            </label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password" 
                                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12">
                                <button type="button" onclick="togglePassword('new_password')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="new_passwordToggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12">
                                <button type="button" onclick="togglePassword('confirm_password')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                    <i class="fas fa-eye" id="confirm_passwordToggleIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-700">
                    <button type="button" onclick="window.location.href='index.php'" 
                            class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Mettre à jour le profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewProfileImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            const image = document.getElementById('photoImage');
            image.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePhotoPreview() {
    const input = document.getElementById('photo');
    const preview = document.getElementById('photoPreview');
    input.value = '';
    preview.classList.add('hidden');
}

function togglePassword(fieldName) {
    const input = document.getElementById(fieldName);
    const icon = document.getElementById(fieldName + 'ToggleIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>