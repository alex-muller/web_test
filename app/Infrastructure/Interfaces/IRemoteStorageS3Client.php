<?php declare(strict_types=1);

namespace App\Infrastructure\Interfaces;

use Aws\S3\S3ClientInterface;

interface IRemoteStorageS3Client extends S3ClientInterface
{

}