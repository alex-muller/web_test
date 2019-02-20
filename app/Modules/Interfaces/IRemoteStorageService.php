<?php declare(strict_types=1);

namespace App\Modules\Interfaces;

interface IRemoteStorageService
{
     public function getRootDirectoryFiles(): array;
     public function downloadRemoteFileByKey(string $key): string;

}