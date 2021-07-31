<?php

namespace App\Service;

class FolderGenerator 
{
    public function generateFolderSubIfAbsent(string $directory, string $subdirectory) {
        if(!is_dir($directory)) {
            mkdir($directory);
            if(!is_dir($subdirectory)) {
                mkdir($subdirectory);
            }
        }
    }

    public function generateForlderTripleIfAbsent(string $directory, string $subdirectory, string $thirddirectory) {
        if(!is_dir($directory)) {
            mkdir($directory);
            if(!is_dir($subdirectory)) {
                mkdir($subdirectory);
                if(!is_dir($thirddirectory)) {
                    mkdir($thirddirectory);
                }
            }
        }
    }
}

?>