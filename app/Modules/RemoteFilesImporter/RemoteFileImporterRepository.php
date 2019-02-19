<?php declare(strict_types=1);


namespace App\Modules\RemoteFilesImporter;


use App\Infrastructure\DBQueryBuilder;
use App\Models\Profile;

final class RemoteFileImporterRepository
{
    const TABLE_NAME = 'profiles';

    private $builder;

    public function __construct(DBQueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function insertProfile($id) {
        
        /*
        $this->builder->getTableQuery(static::TABLE_NAME)->insert([
            'profile_id' => $id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        */
        $profile = new Profile();
        $profile->profile_id = $id;
        $profile->save();

        return true;
    }

}