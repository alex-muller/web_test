<?php declare(strict_types=1);


namespace App\Modules\RemoteFilesImporter;


use App\Models\Profile;

final class RemoteFileImporterRepository
{
    /**
     * @param $id
     * @return bool
     */
    public function insertProfile($id) {
        
        $profile = new Profile();
        $profile->profile_id = $id;
        $profile->save();

        return true;
    }

}