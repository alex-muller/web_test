<?php declare(strict_types=1);

namespace App\Modules\RemoteStorage;

use App\Infrastructure\Interfaces\IRemoteStorageClient;
use App\Modules\Interfaces\IRemoteStorageService;


final class RemoteStorageService implements IRemoteStorageService
{

    private $client;

    public function __construct(IRemoteStorageClient $client )
    {
        $this->client = $client;
    }
    
    /**
     * @return array
     */
    public function getRootDirectoryFiles(): array {
        $prefix = '/';
        $allItems = $this->client->getItemsList();
        $rootFiles = [];
        foreach ($allItems as $item) {
            if (mb_strpos($item, $prefix) === 0) {
                $pathWithoutDirPrefix = mb_substr($item,mb_strlen($prefix));
                if (mb_strpos($pathWithoutDirPrefix,'/') === false) {
                    $rootFiles[] = $pathWithoutDirPrefix;
                }
            }
        }

        return $rootFiles;
    }
    
    /**
     * @param $key
     * @return string
     */
    public function downloadRemoteFileByKey(string $key): string {
        try {
            return $this->client->downloadItem($key,$key);
        } catch (\Exception $e) {
            throw new CantDownloadFileException('Cant download file');
        }
    }


}