<?php
// Vérifier si l'ID est présent
if (empty($id)) {
    header("Location: ?table=$table");
    exit;
}

try {
    // Récupérer l'enregistrement avant suppression (utile pour supprimer l'image associée)
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `{$columns[0]['Field']}` = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        // Supprimer les images associées (si champ image/photo existe)
        foreach ($columns as $column) {
            $fieldName = $column['Field'];
            if (
                ($fieldName === 'image' || $fieldName === 'photo' || strpos($fieldName, 'image') !== false) &&
                !empty($record[$fieldName])
            ) {
                deleteImage($record[$fieldName]); // ta fonction de suppression d'image
            }
        }

        // Supprimer l'enregistrement
        $stmt = $pdo->prepare("DELETE FROM `$table` WHERE `{$columns[0]['Field']}` = ?");
        $stmt->execute([$id]);

        // ✅ Redirection propre
        if (!headers_sent()) {
            header("Location: ?table=$table&success=deleted");
            exit;
        } else {
            echo "<script>window.location.href='?table=$table&success=deleted';</script>";
            exit;
        }
    } else {
        if (!headers_sent()) {
            header("Location: ?table=$table&error=not_found");
            exit;
        } else {
            echo "<script>window.location.href='?table=$table&error=not_found';</script>";
            exit;
        }
    }
} catch (Exception $e) {
    if (!headers_sent()) {
        header("Location: ?table=$table&error=delete_failed");
        exit;
    } else {
        echo "<script>window.location.href='?table=$table&error=delete_failed';</script>";
        exit;
    }
}
?>
