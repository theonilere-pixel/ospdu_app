<?php
if (empty($id)) {
    header("Location: ?table=$table");
    exit;
}

// Récupérer l'enregistrement
$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `{$columns[0]['Field']}` = ?");
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    header("Location: ?table=$table&error=not_found");
    exit;
}
?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <button onclick="history.back()" class="bg-gray-700 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div>
                <h1 class="text-3xl font-bold text-white">Détails - <?php echo ucfirst(str_replace('_', ' ', $table)); ?></h1>
                <p class="text-gray-400">Enregistrement #<?php echo $id; ?></p>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <button onclick="window.location.href='?table=<?php echo $table; ?>&action=edit&id=<?php echo $id; ?>'" 
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Modifier
            </button>
            <button onclick="confirmDelete('<?php echo $table; ?>', <?php echo $id; ?>)" 
                    class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-trash mr-2"></i>Supprimer
            </button>
        </div>
    </div>

    <!-- Details Card -->
    <div class="bg-gray-800 rounded-2xl overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <?php foreach ($columns as $column): ?>
                    <?php 
                    $fieldName = $column['Field'];
                    $fieldType = $column['Type'];
                    $value = $record[$fieldName];
                    
                    // Ignorer le mot de passe
                    if ($fieldName === 'password') {
                        continue;
                    }
                    ?>
                    
                    <div class="<?php echo ($fieldName === 'description' || strpos($fieldType, 'text') !== false) ? 'lg:col-span-2' : ''; ?>">
                        <dt class="text-sm font-medium text-gray-400 mb-2">
                            <?php echo ucfirst(str_replace('_', ' ', $fieldName)); ?>
                        </dt>
                        <dd class="text-white">
                            <?php
                            // Gestion des images
                            if (($fieldName === 'image' || $fieldName === 'photo' || strpos($fieldName, 'image') !== false) && !empty($value)):
                            ?>
                                <div class="flex items-center space-x-4">
                                    <img src="uploads/<?php echo htmlspecialchars($value); ?>" alt="Image" 
                                         class="w-32 h-32 object-cover rounded-lg cursor-pointer image-preview" 
                                         onclick="viewFullImage('uploads/<?php echo htmlspecialchars($value); ?>')">
                                    <div class="text-gray-400">
                                        <p class="text-sm">Nom du fichier: <?php echo htmlspecialchars($value); ?></p>
                                        <button onclick="viewFullImage('uploads/<?php echo htmlspecialchars($value); ?>')" 
                                                class="text-blue-400 hover:text-blue-300 text-sm">
                                            <i class="fas fa-expand mr-1"></i>Voir en grand
                                        </button>
                                    </div>
                                </div>
                            
                            <?php
                            // Gestion des statuts
                            elseif ($fieldName === 'status'):
                                $statusClass = $value === 'active' ? 'bg-green-600' : 'bg-red-600';
                            ?>
                                <span class="<?php echo $statusClass; ?> text-white px-3 py-1 rounded-full text-sm">
                                    <?php echo ucfirst($value); ?>
                                </span>
                            
                            <?php
                            // Gestion des emails
                            elseif ($fieldName === 'email'):
                            ?>
                                <a href="mailto:<?php echo htmlspecialchars($value); ?>" 
                                   class="text-blue-400 hover:text-blue-300 flex items-center">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <?php echo htmlspecialchars($value); ?>
                                </a>
                            
                            <?php
                            // Gestion des URLs
                            elseif (filter_var($value, FILTER_VALIDATE_URL)):
                            ?>
                                <a href="<?php echo htmlspecialchars($value); ?>" target="_blank" 
                                   class="text-blue-400 hover:text-blue-300 flex items-center">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    <?php echo htmlspecialchars($value); ?>
                                </a>
                            
                            <?php
                            // Gestion des dates
                            elseif (strpos($fieldType, 'timestamp') !== false || strpos($fieldType, 'datetime') !== false || strpos($fieldType, 'date') !== false):
                            ?>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <?php echo $value ? date('d/m/Y H:i:s', strtotime($value)) : '-'; ?>
                                </div>
                            
                            <?php
                            // Gestion du texte long
                            elseif (strlen($value) > 100):
                            ?>
                                <div class="bg-gray-700 rounded-lg p-4">
                                    <pre class="whitespace-pre-wrap text-gray-300"><?php echo ($value); ?></pre>
                                </div>
                            
                            <?php
                            // Valeur booléenne
                            elseif (is_bool($value) || in_array($value, ['0', '1', 'true', 'false'])):
                                $boolValue = in_array($value, ['1', 'true', true]);
                                $boolClass = $boolValue ? 'text-green-400' : 'text-red-400';
                                $boolIcon = $boolValue ? 'fa-check-circle' : 'fa-times-circle';
                                $boolText = $boolValue ? 'Oui' : 'Non';
                            ?>
                                <span class="<?php echo $boolClass; ?> flex items-center">
                                    <i class="fas <?php echo $boolIcon; ?> mr-2"></i>
                                    <?php echo $boolText; ?>
                                </span>
                            
                            <?php
                            // Valeur nulle ou vide
                            elseif (empty($value)):
                            ?>
                                <span class="text-gray-500 italic">Non défini</span>
                            
                            <?php
                            // Valeur normale
                            else:
                            ?>
                                <span class="text-gray-300"><?php echo htmlspecialchars($value); ?></span>
                            <?php endif; ?>
                        </dd>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-center space-x-4">
        <button onclick="window.location.href='?table=<?php echo $table; ?>'" 
                class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg transition-colors">
            <i class="fas fa-list mr-2"></i>Retour à la liste
        </button>
        <button onclick="window.location.href='?table=<?php echo $table; ?>&action=edit&id=<?php echo $id; ?>'" 
                class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg transition-colors">
            <i class="fas fa-edit mr-2"></i>Modifier cet enregistrement
        </button>
    </div>
</div>

<!-- Full Image Modal -->
<div id="fullImageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-full max-h-full">
            <button onclick="closeFullImage()" 
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <img id="fullImage" src="" alt="Image complète" class="max-w-full max-h-screen object-contain rounded-lg">
        </div>
    </div>
</div>

<script>
function viewFullImage(src) {
    document.getElementById('fullImage').src = src;
    document.getElementById('fullImageModal').classList.remove('hidden');
}

function closeFullImage() {
    document.getElementById('fullImageModal').classList.add('hidden');
}

function confirmDelete(table, id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
        window.location.href = `?table=${table}&action=delete&id=${id}`;
    }
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('fullImageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFullImage();
    }
});
</script>