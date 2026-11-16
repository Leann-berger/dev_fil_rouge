<?php

namespace App\Service;

class UploadService
{
    public function uploadFile(array $file, string $uploadPath): ?string
    {
        // Pas de fichier choisi, ou erreur d'envoi et on ne stocke rien
        if ($file["error"] !== UPLOAD_ERR_OK) {
            return null;
        }

        $ext = $this->getFileExtension($file["name"]);

        // Seulement des images
        if (!in_array($ext, ["jpg", "jpeg", "png", "webp", "gif"], true)) {
            return null;
        }

        $name_file = $this->renameFile($ext);
        move_uploaded_file($file["tmp_name"], $uploadPath . $name_file);
        return $name_file;
    }


    private function renameFile(string $ext): string
    {
        return uniqid(true) . "." . $ext;
    }

 
    private function getFileExtension(string $fileName): string
    {
        return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    }
}
