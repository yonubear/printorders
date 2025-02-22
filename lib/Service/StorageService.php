<?php

namespace OCA\PrintOrders\Service;

use OCP\Files\IRootFolder;
use OCP\Files\NotFoundException;
use OCP\Files\NotPermittedException;

class StorageService {
    private $rootFolder;
    private const BASE_PATH = 'print_orders';

    public function __construct(IRootFolder $rootFolder) {
        $this->rootFolder = $rootFolder;
    }

    public function storeFiles(array $files, string $path): array {
        $userFolder = $this->rootFolder->getUserFolder();
        $storedFiles = [];

        // Create path if it doesn't exist
        if (!$userFolder->nodeExists($path)) {
            $userFolder->newFolder($path);
        }
        $targetFolder = $userFolder->get($path);

        foreach ($files as $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . $file['name'];
                $newFile = $targetFolder->newFile($fileName);
                $newFile->putContent(file_get_contents($file['tmp_name']));

                $storedFiles[] = [
                    'name' => $fileName,
                    'path' => $newFile->getPath(),
                    'size' => $newFile->getSize(),
                    'timestamp' => time()
                ];
            }
        }

        return $storedFiles;
    }

    // Other methods...
}