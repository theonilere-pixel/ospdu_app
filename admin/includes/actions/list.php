<?php
// 🔹 Sécurisation des paramètres GET
$page_num = isset($_GET['page_num']) ? max(1, (int)$_GET['page_num']) : 1;
$limit    = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset   = ($page_num - 1) * $limit;
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';

// 🔹 Construire la requête principale
$sql = "SELECT * FROM `$table`";
$params = [];

// 🔹 Recherche dynamique
if ($search !== '') {
    $searchConditions = [];
    foreach ($columns as $column) {
        if (
            in_array($column['Type'], ['varchar', 'text', 'longtext']) ||
            strpos($column['Type'], 'varchar') !== false ||
            strpos($column['Type'], 'text') !== false
        ) {
            $searchConditions[] = "`{$column['Field']}` LIKE ?";
            $params[] = "%$search%";
        }
    }
    if (!empty($searchConditions)) {
        $sql .= " WHERE " . implode(' OR ', $searchConditions);
    }
}

// 🔹 Ajout du tri + LIMIT/OFFSET (⚠️ sans placeholders)
$sql .= " ORDER BY `{$columns[0]['Field']}` DESC LIMIT $limit OFFSET $offset";

// 🔹 Exécution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 🔹 Compter le total pour la pagination
$countSql = "SELECT COUNT(*) FROM `$table`";
$countParams = [];

if ($search !== '') {
    $searchConditions = [];
    foreach ($columns as $column) {
        if (
            in_array($column['Type'], ['varchar', 'text', 'longtext']) ||
            strpos($column['Type'], 'varchar') !== false ||
            strpos($column['Type'], 'text') !== false
        ) {
            $searchConditions[] = "`{$column['Field']}` LIKE ?";
            $countParams[] = "%$search%";
        }
    }
    if (!empty($searchConditions)) {
        $countSql .= " WHERE " . implode(' OR ', $searchConditions);
    }
}

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($countParams);
$totalRecords = (int)$countStmt->fetchColumn();
$totalPages   = ceil($totalRecords / $limit);
?>


<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2"><?php echo ucfirst(str_replace('_', ' ', $table)); ?></h1>
            <p class="text-gray-400">Gérer les enregistrements de la table <?php echo $table; ?></p>
        </div>
        <button onclick="window.location.href='?table=<?php echo $table; ?>&action=add'" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Ajouter
        </button>
    </div>

    <!-- Table Container -->
    <div class="bg-gray-800 rounded-2xl overflow-hidden">
        <!-- Table Controls -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <select id="limitSelect" onchange="updateTable()" class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white">
                        <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                        <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                        <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                        <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                    </select>
                    <span class="text-gray-400">entries per page</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400">Search:</span>
                    <input type="text" id="searchInput" value="<?php echo htmlspecialchars($search); ?>" 
                           onkeyup="searchTable()" placeholder="" 
                           class="bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white w-64">
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <?php foreach ($columns as $column): ?>
                            <?php if ($column['Field'] !== 'password'): ?>
                                <th class="text-left py-3 px-4 text-gray-400 font-medium">
                                    <?php echo ucfirst(str_replace('_', ' ', $column['Field'])); ?>
                                    <i class="fas fa-sort ml-1 cursor-pointer"></i>
                                </th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <th class="text-left py-3 px-4 text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="<?php echo count($columns) + 1; ?>" class="py-8 px-4 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>Aucun enregistrement trouvé</p>
                                <button onclick="window.location.href='?table=<?php echo $table; ?>&action=add'" 
                                        class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-plus mr-2"></i>Ajouter le premier enregistrement
                                </button>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $row): ?>
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition-colors">
                                <?php foreach ($columns as $column): ?>
                                    <?php if ($column['Field'] !== 'password'): ?>
                                        <td class="py-4 px-4">
                                            <?php
                                            $value = $row[$column['Field']];
                                            
                                            // Gestion des images
                                            if (($column['Field'] === 'image' || $column['Field'] === 'photo' || strpos($column['Field'], 'image') !== false) && !empty($value)) {
                                                echo '<img src="uploads/' . htmlspecialchars($value) . '" alt="Image" class="w-12 h-12 object-cover rounded-lg cursor-pointer" onclick="viewImage(\'uploads/' . htmlspecialchars($value) . '\')">';
                                            }
                                            // Gestion des statuts
                                            elseif ($column['Field'] === 'status') {
                                                $statusClass = $value === 'active' ? 'bg-green-600' : 'bg-red-600';
                                                echo '<span class="' . $statusClass . ' text-white px-2 py-1 rounded-full text-sm">' . ucfirst($value) . '</span>';
                                            }
                                            // Gestion des emails
                                            elseif ($column['Field'] === 'email') {
                                                echo '<a href="mailto:' . htmlspecialchars($value) . '" class="text-blue-400 hover:text-blue-300">' . htmlspecialchars($value) . '</a>';
                                            }
                                            // Gestion des dates
                                            elseif (strpos($column['Type'], 'timestamp') !== false || strpos($column['Type'], 'datetime') !== false || strpos($column['Type'], 'date') !== false) {
                                                echo '<span class="text-gray-400">' . ($value ? date('d/m/Y H:i', strtotime($value)) : '-') . '</span>';
                                            }
                                            // Gestion du texte long
                                            elseif (strlen($value) > 50) {
                                                echo '<span class="text-gray-300" title="' . htmlspecialchars($value) . '">' . htmlspecialchars(substr($value, 0, 50)) . '...</span>';
                                            }
                                            // Valeur normale
                                            else {
                                                echo '<span class="text-white">' . htmlspecialchars($value) . '</span>';
                                            }
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <td class="py-4 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="window.location.href='?table=<?php echo $table; ?>&action=view&id=<?php echo $row[$columns[0]['Field']]; ?>'" 
                                                class="bg-gray-600 hover:bg-gray-700 text-white p-2 rounded transition-colors" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button onclick="window.location.href='?table=<?php echo $table; ?>&action=edit&id=<?php echo $row[$columns[0]['Field']]; ?>'" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded transition-colors" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="confirmDelete('<?php echo $table; ?>', <?php echo $row[$columns[0]['Field']]; ?>)" 
                                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded transition-colors" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="p-6 border-t border-gray-700">
                <div class="flex justify-between items-center">
                    <div class="text-gray-400">
                        Affichage de <?php echo $offset + 1; ?> à <?php echo min($offset + $limit, $totalRecords); ?> sur <?php echo $totalRecords; ?> entrées
                    </div>
                    <div class="flex space-x-2">
                        <?php if ($page_num > 1): ?>
                            <button onclick="goToPage(<?php echo $page_num - 1; ?>)" 
                                    class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page_num - 2); $i <= min($totalPages, $page_num + 2); $i++): ?>
                            <button onclick="goToPage(<?php echo $i; ?>)" 
                                    class="<?php echo $i == $page_num ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600'; ?> text-white px-3 py-2 rounded transition-colors">
                                <?php echo $i; ?>
                            </button>
                        <?php endfor; ?>
                        
                        <?php if ($page_num < $totalPages): ?>
                            <button onclick="goToPage(<?php echo $page_num + 1; ?>)" 
                                    class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Viewer Modal -->
<div id="imageViewerModal" class="fixed inset-0 bg-black bg-opacity-80 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-4xl max-h-screen">
            <button onclick="closeImageViewer()" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <img id="viewerImage" src="" alt="Image viewer" class="max-w-full max-h-screen object-contain rounded-lg">
        </div>
    </div>
</div>

<script>
function updateTable() {
    const limit = document.getElementById('limitSelect').value;
    const search = document.getElementById('searchInput').value;
    const params = new URLSearchParams(window.location.search);
    
    params.set('limit', limit);
    params.set('page_num', '1');
    if (search) params.set('search', search);
    else params.delete('search');
    
    window.location.href = '?' + params.toString();
}

function searchTable() {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(updateTable, 500);
}

function goToPage(page) {
    const params = new URLSearchParams(window.location.search);
    params.set('page_num', page);
    window.location.href = '?' + params.toString();
}

function viewImage(src) {
    document.getElementById('viewerImage').src = src;
    document.getElementById('imageViewerModal').classList.remove('hidden');
}

function closeImageViewer() {
    document.getElementById('imageViewerModal').classList.add('hidden');
}

function confirmDelete(table, id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
        window.location.href = `?table=${table}&action=delete&id=${id}`;
    }
}
</script>