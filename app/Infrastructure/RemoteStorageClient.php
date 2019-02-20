<?php declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\Interfaces\IRemoteStorageClient;
use Aws\S3\S3ClientInterface;
use Illuminate\Contracts\Filesystem\Filesystem ;

final class RemoteStorageClient implements IRemoteStorageClient
{

    private $s3;
    private $bucketName;
    private $filesystem;

    public function __construct(S3ClientInterface $s3, string $bucketName, Filesystem $filesystem)
    {
        $this->s3 = $s3;
        $this->s3->registerStreamWrapper();

        $this->bucketName = $bucketName;
        $this->filesystem = $filesystem;
    }
    
    /**
     * @return array
     */
    public function getItemsList(): array
    {
        $items = [];
        $results = $this->s3->getPaginator('ListObjects',[
            'Bucket' => $this->bucketName
        ]);

        foreach ($results as $result) {
            foreach ($result['Contents'] as $object) {
                $items[] = '/'.$object['Key'];
            }
        }

        return $items;
    }
    
    /**
     * @param string $remoteKey
     * @param string $localKey
     * @return string
     * @throws \Exception
     */
    public function downloadItem(string $remoteKey, string $localKey): string
    {
        $remoteKey = ltrim($remoteKey, '/');
        if ($stream = fopen($this->getStreamPath($remoteKey), 'r')) {

            $this->filesystem->put($localKey, $stream);

            return config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . $localKey;
        }

        throw new \Exception('Invalid remote key');
    }

    /*
    public function putItem(string $localKey, string $remoteKey): bool {

        return file_put_contents($this->getStreamPath($remoteKey), $this->filesystem->get($localKey));

    }
    */

    private function getStreamPath(string $path): string {
        return "s3://{$this->bucketName}/$path";
    }



}