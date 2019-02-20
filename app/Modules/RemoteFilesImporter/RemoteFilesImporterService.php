<?php declare(strict_types=1);

namespace App\Modules\RemoteFilesImporter;

use App\Modules\Interfaces\IRemoteStorageService;
use App\Modules\RemoteFilesImporter\Exceptions\ValidationException;

final class RemoteFilesImporterService
{
    private $remoteStorageService;
    private $repository;

    public function __construct(IRemoteStorageService $remoteStorageService, RemoteFileImporterRepository $repository)
    {
        $this->remoteStorageService = $remoteStorageService;
        $this->repository = $repository;
    }
    
    /**
     * @return array
     */
    public function getFilesAvailableForImport(): array {
        $files = $this->remoteStorageService->getRootDirectoryFiles();
        
        return array_filter($files, function(string $fileKey){
            return preg_match('#.json$#', $fileKey);
        });
    }
    
    /**
     * @param string $key
     * @return int
     * @throws ValidationException
     */
    public function importByKey(string $key): int {
        $filePath = $this->remoteStorageService->downloadRemoteFileByKey($key);
        if (!file_exists($filePath)) {
            throw new ValidationException('Cant download file for import');
        }
        $fileContent = file($filePath);

        $count = 0;
        foreach ($fileContent as $row) {
            $jsonData = json_decode($row);
            if (!empty($jsonData)) {
                $id = $jsonData->profile_id;
                if ($this->repository->insertProfile($id)) {
                    $count++;
                }
            }
        }

        return $count;
    }

}