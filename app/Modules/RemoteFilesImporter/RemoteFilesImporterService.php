<?php declare(strict_types=1);

namespace App\Modules\RemoteFilesImporter;

use App\Models\Profile;
use App\Modules\Interfaces\IImportStage;
use App\Modules\Interfaces\IRemoteStorageService;
use App\Modules\RemoteFilesImporter\Exceptions\ValidationException;
use App\Modules\RemoteFilesImporter\Stages\GeoImportStage;
use App\Modules\RemoteFilesImporter\Stages\ProfileImportStage;
use App\Modules\RemoteFilesImporter\Stages\SubscriptionImportStage;

final class RemoteFilesImporterService
{
    private $remoteStorageService;

    private $importStages = [
        GeoImportStage::class,
        SubscriptionImportStage::class
    ];

    public function __construct(IRemoteStorageService $remoteStorageService)
    {
        $this->remoteStorageService = $remoteStorageService;
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
                if ($this->insertProfile($jsonData)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    /**
     * @param $jsonData
     *
     * @return bool
     */
    public function insertProfile($jsonData)
    {

      //  \DB::beginTransaction();

        // TODO Clicks

        $profile = $this->createProfile($jsonData);

        foreach ($this->importStages as $stage) {
            $this->runImportStage(new $stage(), $profile, $jsonData);
        }

     //   \DB::commit();

        return true;
    }

    private function runImportStage(IImportStage $stage, Profile $profile, \stdClass $jsonData)
    {
        return $stage->import($profile, $jsonData);
    }

    /**
     * @param $jsonData
     *
     * @return mixed
     */
    private function createProfile($jsonData) : Profile
    {
        $profile = Profile::firstOrCreate(
            ['profile_id' => $jsonData->profile_id],
            ['email' => $jsonData->profile_id]
        );

        return $profile;
    }


}