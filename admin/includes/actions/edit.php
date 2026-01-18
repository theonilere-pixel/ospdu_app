<?php
if (empty($id)) {
    header("Location: ?table=$table");
    exit;
}
// Récupérer l'enregistrement existant
$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `{$columns[0]['Field']}` = ?");
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    header("Location: ?table=$table&error=not_found");
    exit;
}

$error = '';
$success = '';

if ($_POST) {
    try {
        $fields = [];
        $values = [];
        
        foreach ($columns as $column) {
            $fieldName = $column['Field'];
            
            // Ignorer les champs auto-incrémentés et les clés primaires
            if ($column['Extra'] === 'auto_increment' || $column['Key'] === 'PRI') {
                continue;
            }
            
            // Mettre à jour updated_at automatiquement
            if ($fieldName === 'updated_at') {
                $fields[] = "`$fieldName` = NOW()";
                continue;
            }
            
            // Traitement spécial pour les images file_path
            if (($fieldName === 'image' || $fieldName === 'photo' || $fieldName === 'file_path' || strpos($fieldName, 'image') !== false) && 
                isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                
                // Supprimer l'ancienne image
                if (!empty($record[$fieldName])) {
                    deleteImage($record[$fieldName]);
                }
                
                $uploadResult = uploadImage($_FILES[$fieldName]);
                if ($uploadResult['success']) {
                    $fields[] = "`$fieldName` = ?";
                    $values[] = $uploadResult['filename'];
                } else {
                    $error = $uploadResult['message'];
                    break;
                }
            }
            // Traitement des mots de passe
            elseif ($fieldName === 'password' && !empty($_POST[$fieldName])) {
                $fields[] = "`$fieldName` = ?";
                $values[] = password_hash($_POST[$fieldName], PASSWORD_DEFAULT);
            }
            // Autres champs
            elseif (isset($_POST[$fieldName])) {
                $fields[] = "`$fieldName` = ?";
                $values[] = $_POST[$fieldName];
            }
        }
        
        if (empty($error) && !empty($fields)) {
            $sql = "UPDATE `$table` SET " . implode(', ', $fields) . " WHERE `{$columns[0]['Field']}` = ?";
            $values[] = $id;
            
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute($values)) {
                $success = 'Enregistrement modifié avec succès !';
                // Recharger l'enregistrement mis à jour
                $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `{$columns[0]['Field']}` = ?");
                $stmt->execute([$id]);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = 'Erreur lors de la modification de l\'enregistrement';
            }
        }
    } catch (Exception $e) {
        $error = 'Erreur : ' . $e->getMessage();
    }
}
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <button onclick="history.back()" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div>
            <h1 class="text-3xl font-bold text-white">Modifier - <?php echo ucfirst(str_replace('_', ' ', $table)); ?></h1>
            <p class="text-gray-400">Modifier l'enregistrement #<?php echo $id; ?></p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-gray-800 rounded-2xl p-6">
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($columns as $column): ?>
                    <?php 
                    $fieldName = $column['Field'];
                    $fieldType = $column['Type'];
                    $isRequired = $column['Null'] === 'NO' && $column['Extra'] !== 'auto_increment';
                    $currentValue = $record[$fieldName] ?? '';
                    
                    // Ignorer les champs auto-incrémentés
                    if ($column['Extra'] === 'auto_increment') {
                        continue;
                    }
                    
                    // Afficher la clé primaire en lecture seule
                    if ($column['Key'] === 'PRI'):
                    ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                <?php echo ucfirst(str_replace('_', ' ', $fieldName)); ?> (ID)
                            </label>
                            <input type="text" value="<?php echo htmlspecialchars($currentValue); ?>" readonly
                                   class="w-full bg-gray-600 border border-gray-500 rounded-lg px-4 py-3 text-gray-300 cursor-not-allowed">
                        </div>
                        <?php continue; ?>
                    <?php endif; ?>
                    
                    <div class="<?php echo ($fieldName === 'description' || strpos($fieldType, 'text') !== false) ? 'md:col-span-2' : ''; ?>">
                        <label for="<?php echo $fieldName; ?>" class="block text-sm font-medium text-gray-300 mb-2">
                            <?php echo ucfirst(str_replace('_', ' ', $fieldName)); ?>
                            <?php if ($isRequired): ?>
                                <span class="text-red-400">*</span>
                            <?php endif; ?>
                        </label>
                        
                        <?php
                        // Champ image
                        if ($fieldName === 'image' || $fieldName === 'photo' || strpos($fieldName, 'image') !== false):
                        ?>
                            <div class="space-y-4">
                                <?php if (!empty($currentValue)): ?>
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <img src="uploads/<?php echo htmlspecialchars($currentValue); ?>" alt="Image actuelle" 
                                                 class="w-32 h-32 object-cover rounded-lg image-preview">
                                            <button type="button" onclick="removeCurrentImage('<?php echo $fieldName; ?>')" 
                                                    class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center transition-colors">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </div>
                                        <div class="text-gray-400">
                                            <p class="text-sm">Image actuelle</p>
                                            <p class="text-xs"><?php echo htmlspecialchars($currentValue); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <input type="file" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                       accept="image/*" onchange="previewImage(this, '<?php echo $fieldName; ?>Preview')"
                                       class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                
                                <div id="<?php echo $fieldName; ?>Preview" class="hidden">
                                    <div class="relative inline-block">
                                        <img id="<?php echo $fieldName; ?>Image" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg image-preview">
                                        <button type="button" onclick="removePreview('<?php echo $fieldName; ?>')" 
                                                class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center transition-colors">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-400 mt-2">Nouvelle image (remplacera l'actuelle)</p>
                                </div>
                                
                                <input type="hidden" id="<?php echo $fieldName; ?>_remove" name="<?php echo $fieldName; ?>_remove" value="0">
                            </div>
                        
                        <?php
                        // Champ mot de passe
                        elseif ($fieldName === 'password'):
                        ?>
                            <div class="space-y-2">
                                <div class="relative">
                                    <input type="password" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                           placeholder="Laisser vide pour conserver le mot de passe actuel"
                                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12">
                                    <button type="button" onclick="togglePassword('<?php echo $fieldName; ?>')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                        <i class="fas fa-eye" id="<?php echo $fieldName; ?>ToggleIcon"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-400">Laisser vide pour conserver le mot de passe actuel</p>
                            </div>
                        
                        <?php
                        // Champ email
                        elseif ($fieldName === 'email'):
                        ?>
                            <input type="email" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                   value="<?php echo htmlspecialchars($currentValue); ?>"
                                   <?php echo $isRequired ? 'required' : ''; ?>
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <?php
                        // Champ textarea pour texte long
                        /*elseif (strpos($fieldType, 'text') !== false):
                        ?>
                            <textarea id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" rows="4"
                                <?php echo $isRequired ? 'required' : ''; ?>
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($_POST[$fieldName] ?? ''); ?></textarea>

                        <?php*/
                        elseif (strpos($fieldType, 'text') !== false):
                            if ($fieldName === 'descriptionevents' || $fieldName === 'content'):
                            ?>
                                <!-- ✅ SunEditor intégré pour description/content -->
                                <textarea id="editor_<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" rows="10"
                                 class="suneditor w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($_POST[$fieldName] ?? $currentValue); ?></textarea>

                            <?php
                            else:
                            ?>
                                <textarea id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" rows="4"
                                    <?php echo $isRequired ? 'required' : ''; ?>
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <?php echo htmlspecialchars($_POST[$fieldName] ?? $currentValue); ?>
                                </textarea>

                            <?php
                            endif;
                        // Champ select pour enum
                        elseif (strpos($fieldType, 'enum') !== false):
                            preg_match("/enum\((.+)\)/", $fieldType, $matches);
                            $enumValues = str_getcsv($matches[1], ',', "'");
                        ?>
                            <select id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                    <?php echo $isRequired ? 'required' : ''; ?>
                                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionner...</option>
                                <?php foreach ($enumValues as $enumValue): ?>
                                    <option value="<?php echo $enumValue; ?>" <?php echo $currentValue === $enumValue ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($enumValue); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        
                        <?php
                        // Champ date
                        elseif (strpos($fieldType, 'date') !== false || strpos($fieldType, 'timestamp') !== false):
                            $dateValue = '';
                            if (!empty($currentValue) && $currentValue !== '0000-00-00 00:00:00') {
                                $dateValue = date('Y-m-d\TH:i', strtotime($currentValue));
                            }
                        ?>
                            <input type="datetime-local" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                   value="<?php echo $dateValue; ?>"
                                   <?php echo $isRequired ? 'required' : ''; ?>
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <?php
                        // Champ numérique
                        elseif (strpos($fieldType, 'int') !== false || strpos($fieldType, 'decimal') !== false || strpos($fieldType, 'float') !== false):
                        ?>
                            <input type="number" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                   value="<?php echo htmlspecialchars($currentValue); ?>"
                                   <?php echo $isRequired ? 'required' : ''; ?>
                                   <?php echo strpos($fieldType, 'decimal') !== false || strpos($fieldType, 'float') !== false ? 'step="0.01"' : ''; ?>
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        
                        <?php
                        // Champ texte par défaut
                        else:
                        ?>
                            <input type="text" id="<?php echo $fieldName; ?>" name="<?php echo $fieldName; ?>" 
                                   value="<?php echo htmlspecialchars($currentValue); ?>"
                                   <?php echo $isRequired ? 'required' : ''; ?>
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-700">
                <button type="button" onclick="history.back()" 
                        class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-times mr-2"></i>Annuler
                </button>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="assets/js/suneditor/suneditor.min.css">
<script src="assets/js/suneditor/suneditor.min.js"></script>
<script src="assets/js/suneditor/lang/fr.js"></script>
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const image = document.getElementById(previewId.replace('Preview', 'Image'));
            image.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview(fieldName) {
    const input = document.getElementById(fieldName);
    const preview = document.getElementById(fieldName + 'Preview');
    input.value = '';
    preview.classList.add('hidden');
}

function removeCurrentImage(fieldName) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        document.getElementById(fieldName + '_remove').value = '1';
        // Masquer l'image actuelle
        event.target.closest('.flex').style.display = 'none';
    }
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

// ✅ Initialisation de SunEditor
    const editors = {}; // pour stocker les instances
    document.querySelectorAll('.suneditor').forEach((el) => {
        const editor = SUNEDITOR.create(el.id, {
            lang: SUNEDITOR_LANG['fr'],
            width: '100%',
            height: '700px',
            resizingBar: true,
            popupDisplay: 'full',
            defaultStyle: 'font-size: 16px; font-family: Arial;',
            imageUploadUrl: 'includes/upload-editor-file.php',
            buttonList: [
                ['undo', 'redo'],
                ['font', 'fontSize', 'formatBlock'],
                ['bold', 'underline', 'italic', 'strike'],
                ['fontColor', 'hiliteColor'],
                ['align', 'list', 'lineHeight'],
                ['link', 'image', 'video', 'audio'],
                ['table', 'codeView']
            ],
            font: [
                'Calibri', 'Cambria', 'Cambria Math', 'Arial', 'Arial Black', 'Tahoma',
                'Courier New', 'Georgia', 'Verdana', 'Times New Roman', 'Franklin Gothic Demi Cond',
                'Franklin Gothic Heavy', 'Book Antiqua', 'Bookman Old Style', 'Bodoni MT',
                'Lucida Bright', 'Impact', 'Algerian', 'Californian FB', 'Felix Titling',
                'Comic Sans MS', 'Elephant', 'Lucida Console', 'Mongolian Baiti',
                'Lucida Handwriting', 'Lucida Sans', 'Lucida Calligraphy', 'Lucida Fax'
            ],
            fontSize: [
                8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36,
                38, 40, 42, 44, 46, 48, 50, 60, 72, 78, 80, 92
            ]
        });

        editors[el.id] = editor; // on stocke l’éditeur lié à ce textarea
    });

    // ✅ Avant la soumission du formulaire → injecter les contenus
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", function () {
            Object.keys(editors).forEach(id => {
                const textarea = document.getElementById(id);
                textarea.value = editors[id].getContents(); // met le HTML dans le textarea
            });
        });
    });
</script>