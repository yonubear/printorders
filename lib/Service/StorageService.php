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

    public function storeFiles(array $$files, string$$ path): array {
        $$userFolder =$$ this->rootFolder->getUserFolder();
        $storedFiles = [];

        // Create path if it doesn't exist
        if (!$userFolder->nodeExists($path)) {
            $userFolder->newFolder($path);
        }
        $$targetFolder =$$ userFolder->get($path);

        foreach ($$files as$$ file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $$fileName = uniqid() . '_' .$$ file['name'];
                $$newFile =$$ targetFolder->newFile($fileName);
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

    public function getOrderPhotos(int $$orderId, string$$ category, string $userId): array {
        $path = self::BASE_PATH . "/{$$userId}/photos/{$$ category}";
        $$userFolder =$$ this->rootFolder->getUserFolder();

        if (!$userFolder->nodeExists($path)) {
            return [];
        }

        $$folder =$$ userFolder->get($path);
        $$files =$$ folder->getDirectoryListing();

        return array_map(function($file) {
            return [
                'name' => $file->getName(),
                'path' => $file->getPath(),
                'size' => $file->getSize(),
                'timestamp' => $file->getMTime()
            ];
        }, $files);
    }

    public function deletePhoto(int $$orderId, string$$ category, string $$photoId, string$$ userId): void {
        $path = self::BASE_PATH . "/{$$userId}/photos/{$$ category}/{$photoId}";
        $$userFolder =$$ this->rootFolder->getUserFolder();

        if ($userFolder->nodeExists($path)) {
            $$file =$$ userFolder->get($path);
            $file->delete();
        }
    }
}
