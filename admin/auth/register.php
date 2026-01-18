<?php
session_start();
require_once '../config/config.php';


$error = '';
$success = '';

if ($_POST) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $role = $_POST['role'] ?? 'user';
    $status = $_POST['status'] ?? 'active';

    // Gestion de l'image (photo)
    $photo = null;
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('user_') . '.' . $ext;
        $uploadPath = '../uploads/users/' . $fileName;

        if (!is_dir('../uploads/users')) {
            mkdir('../uploads/users', 0777, true);
        }

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
            $photo = $fileName;
        }
    }

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        $error = 'Tous les champs obligatoires doivent être remplis';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format d\'email invalide';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM user WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = 'Ce nom d\'utilisateur ou email existe déjà';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user 
                (username, email, password, first_name, last_name, photo, role, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt->execute([$username, $email, $hashedPassword, $first_name, $last_name, $photo, $role, $status])) {
                $success = 'Compte créé avec succès !';
                header('Location: login.php?success=1');
            } else {
                $error = 'Erreur lors de la création du compte';
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription ISTDR-v</title>
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
</head>

<body class="bg-gradient-to-br from-green-50 via-white to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-blue-600 p-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">ISTDR DU VOLCAN</h1>
                <p class="text-green-100 mt-2">Créer un nouveau compte</p>
            </div>

            <div class="p-8">
                <?php if ($error): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-4">
                    

                    <div>
                        <div class="flex flex-col items-center space-y-4">
                            <!-- Preview de la photo (hidden par défaut) -->
                            <div id="photoPreviewContainer" class="hidden relative">
                                <img id="photoPreview" src=""
                                    class="w-24 h-24 rounded-full object-cover border border-gray-300 shadow-md">
                                <!-- Bouton remove -->
                                <button type="button" id="removePhotoBtn"
                                    class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <!-- Icône + Bouton Upload (affiché si pas de photo) -->
                            <div id="uploadContainer" class="flex flex-row items-center space-y-2">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center border border-gray-300">
                                    <i class="fas fa-user text-gray-400 text-3xl"></i>
                                </div>
                                <button type="button" onclick="document.getElementById('photo').click()"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center space-x-2 m-3">
                                    <i class="fas fa-upload"></i> <span>Uploader</span>
                                </button>
                            </div>
                            <!-- Input File caché -->
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                        </div>
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Prénom
                            </label>
                            <input type="text" id="first_name" name="first_name" required
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2"></i>Nom
                            </label>
                            <input type="text" id="last_name" name="last_name" required
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user-shield mr-2"></i>Rôle
                        </label>
                        <select id="role" name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <option value="user">Utilisateur</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-toggle-on mr-2"></i>Statut
                        </label>
                        <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                            <option value="active">Actif</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>


                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-at mr-2"></i>Nom d'utilisateur
                        </label>
                        <input type="text" id="username" name="username" required
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <input type="email" id="email" name="email" required
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2"></i>Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 pr-12">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2"></i>Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 pr-12">
                            <button type="button" onclick="togglePassword('confirm_password')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="confirm_passwordToggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 px-4 rounded-lg hover:from-green-700 hover:to-blue-700 transition-all duration-200 font-medium transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>Créer le compte
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">Déjà un compte ?</p>
                    <a href="login.php" class="text-blue-600 hover:text-blue-700 font-medium">
                        Se connecter
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(fieldId + 'ToggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }
    </script>
</body>

</html>

<script>
    const photoInput = document.getElementById("photo");
    const uploadContainer = document.getElementById("uploadContainer");
    const photoPreviewContainer = document.getElementById("photoPreviewContainer");
    const photoPreview = document.getElementById("photoPreview");
    const removePhotoBtn = document.getElementById("removePhotoBtn");

    // Lorsqu'on choisit une image
    photoInput.addEventListener("change", function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                uploadContainer.classList.add("hidden");
                photoPreviewContainer.classList.remove("hidden");
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Supprimer la photo et réafficher l'upload
    removePhotoBtn.addEventListener("click", function() {
        photoInput.value = "";
        photoPreview.src = "";
        photoPreviewContainer.classList.add("hidden");
        uploadContainer.classList.remove("hidden");
    });
</script>