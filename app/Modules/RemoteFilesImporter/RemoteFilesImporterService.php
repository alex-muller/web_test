<?php declare(strict_types=1);

namespace App\Modules\RemoteFilesImporter;

use App\Models\File;
use App\Models\Profile;
use App\Modules\Interfaces\IImportStage;
use App\Modules\Interfaces\IRemoteStorageService;
use App\Modules\RemoteFilesImporter\Exceptions\ValidationException;
use App\Modules\RemoteFilesImporter\Stages\CampaignImportStage;
use App\Modules\RemoteFilesImporter\Stages\ClicksImportStage;
use App\Modules\RemoteFilesImporter\Stages\GeoImportStage;
use App\Modules\RemoteFilesImporter\Stages\ProfileImportStage;
use App\Modules\RemoteFilesImporter\Stages\SubscriptionImportStage;

final class RemoteFilesImporterService
{
    private $remoteStorageService;

    private $importStages = [
        GeoImportStage::class,
        SubscriptionImportStage::class,
        ClicksImportStage::class
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

        // Disable autocommit to increase insert performance
        $this->prepare();

        foreach ($fileContent as $row) {
            $jsonData = json_decode($row);
            if (!empty($jsonData)) {
                if ($this->insertProfile($jsonData)) {
                    $count++;
                }
            }
        }

        $this->saveFileReport($key, $count);

        $this->commit();

        return $count;
    }

    /**
     * @param $jsonData
     *
     * @return bool
     */
    public function insertProfile($jsonData): bool
    {
        $profile = $this->createProfile($jsonData);

        foreach ($this->importStages as $stage) {
            $this->runImportStage(new $stage(), $profile, $jsonData);
        }

        return true;
    }

    private function runImportStage(IImportStage $stage, Profile $profile, \stdClass $jsonData): bool
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

    /**
     * @param string $key
     * @param int    $count
     */
    private function saveFileReport(string $key, int $count): void
    {
        File::updateOrCreate(
            ['name' => $key],
            ['profiles_count' => $count]
        );
    }

    protected function prepare(): void
    {
        if (config('database.default') == 'mysql') {
            \DB::statement('SET autocommit=0');
        }
    }

    protected function commit(): void
    {
        if (config('database.default') == 'mysql') {
            \DB::statement('COMMIT');
        }
    }


}