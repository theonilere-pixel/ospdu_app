<?php
$error = '';
$success = '';

if ($_POST) {
    try {
        $fields = [];
        $values = [];
        $placeholders = [];

        foreach ($columns as $column) {
            $fieldName = $column['Field'];

            // Ignorer les champs auto-incrémentés et les timestamps automatiques
            if (
                $column['Extra'] === 'auto_increment' ||
                ($fieldName === 'created_at' || $fieldName === 'updated_at')
            ) {
                continue;
            }

            // Traitement spécial pour les images
            if (($fieldName === 'image' || $fieldName === 'photo' || strpos($fieldName, 'image') !== false) &&
                isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK
            ) {

                $uploadResult = uploadImage($_FILES[$fieldName]);
                if ($uploadResult['success']) {
                    $fields[] = "`$fieldName`";
                    $values[] = $uploadResult['filename'];
                    $placeholders[] = '?';
                } else {
                    $error = $uploadResult['message'];
                    break;
                }
            }
            // Traitement des mots de passe
            elseif ($fieldName === 'password' && !empty($_POST[$fieldName])) {
                $fields[] = "`$fieldName`";
                $values[] = password_hash($_POST[$fieldName], PASSWORD_DEFAULT);
                $placeholders[] = '?';
            }
            // Autres champs
            elseif (isset($_POST[$fieldName])) {
                $fields[] = "`$fieldName`";
                $values[] = $_POST[$fieldName];
                $placeholders[] = '?';
            }
        }

        if (empty($error) && !empty($fields)) {
            $sql = "INSERT INTO `$table` (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute($values)) {
                $success = 'Enregistrement ajouté avec succès !';
                // Redirection après ajout réussi
                echo "<script>window.location='?table=$table&success=1';</script>";
                exit;
            } else {
                $error = 'Erreur lors de l\'ajout de l\'enregistrement';
            }
        }
    } catch (Exception $e) {
        $error = 'Erreur : ' . $e->getMessage();
    }
}