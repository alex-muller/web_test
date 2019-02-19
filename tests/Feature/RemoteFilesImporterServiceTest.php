<?php declare(strict_types=1);


namespace Test\Feature;


use App\Modules\RemoteFilesImporter\RemoteFileImporterRepository;
use App\Modules\RemoteFilesImporter\RemoteFilesImporterService;
use Tests\TestCase;

class RemoteFilesImporterServiceTest extends TestCase
{

    public function testImportFile() {
        $importService = app()->make(RemoteFilesImporterService::class);
        $count = $importService->importByKey('test.json');
        $this->assertTrue($count > 0);
    }

}