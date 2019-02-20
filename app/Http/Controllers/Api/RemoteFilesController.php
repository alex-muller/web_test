<?php declare(strict_types=1);


namespace App\Http\Controllers\Api;


use App\Modules\RemoteFilesImporter\RemoteFilesImporterService;

class RemoteFilesController extends ApiController
{
    private $remoteFilesImporterService;

    public function __construct(
        RemoteFilesImporterService $remoteFilesImporterService
    )
    {
        $this->remoteFilesImporterService = $remoteFilesImporterService;
    }

    public function getRemoteFiles() {
        try {
            $files = $this->remoteFilesImporterService->getFilesAvailableForImport();

            return response()->json(array_values($files));
        } catch (\Exception $e) {
            $this->returnJsonErrorResponse($e);
        }
    }

    public function importRemoteFile(string $fileKey) {
        try {
            $importedCount = $this->remoteFilesImporterService->importByKey($fileKey);
            if ($importedCount > 0) {
                return response('',200);
            } else {
                throw new \Exception('Something gone wrong');
            }
        } catch (\Exception $e) {
            return $this->returnJsonErrorResponse($e);
        }
    }

}