<?php declare(strict_types=1);


namespace App\Infrastructure\Interfaces;


interface IRemoteStorageClient
{

     public function getItemsList(): array;
     public function downloadItem(string $remotePath, string $localPath): string;

}