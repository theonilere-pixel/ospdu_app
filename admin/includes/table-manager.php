<?php
global $pdo, $database, $table, $action, $id;

if (empty($table)) {
    header('Location: index.php');
    exit;
}

$tables = $database->getAllTables();
if (!in_array($table, $tables)) {
    include '404.php';
    exit;
}

$columns = $database->getTableColumns($table);

// ✅ Si POST → traitement avant affichage
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    require __DIR__ . '/actions/add.php';
    exit; // on arrête ici après redirection
}

// ✅ Sinon → afficher le bon formulaire ou la liste
switch ($action) {
    case 'add':
        include __DIR__ . '/actions/add_form.php';
        break;
    case 'edit':
        include __DIR__ . '/actions/edit.php';
        break;
    case 'delete':
        include __DIR__ . '/actions/delete.php';
        break;
    case 'view':
        include __DIR__ . '/actions/view.php';
        break;
    default:
        include __DIR__ . '/actions/list.php';
}

?>