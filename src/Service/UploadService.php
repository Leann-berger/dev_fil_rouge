<?php

namespace App\Service;

class UploadService
{
    public function uploadFile(array $file, string $uploadPath): ?string
    {
        if (isset($file)) {
            $tmp_name = $file["tmp_name"];
            $name_file = $file["name"];
            //récupération de l'extension
            $ext = $this->getFileExtension($name_file);
            //renommer le fichier
            $name_file = $this->renameFile($ext);
            //Déplacement du fichier aprés upload
            move_uploaded_file($tmp_name, $uploadPath . $name_file);
            return $name_file;
        }
        return null;
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
