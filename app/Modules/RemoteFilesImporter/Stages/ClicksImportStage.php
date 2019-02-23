<?php

namespace App\Modules\RemoteFilesImporter\Stages;

use App\Models\Profile;
use App\Modules\Interfaces\IImportStage;

class ClicksImportStage implements IImportStage
{

    public function import(Profile $profile, \stdClass $jsonData): bool
    {
        if (isset($jsonData->clicks) && is_array($jsonData->clicks)) {
            foreach ($jsonData->clicks as $click) {
                $this->importClick($click, $profile);
            }
        }

        return true;
    }

    private function importClick(\stdClass $click, Profile $profile): void
    {
        $profile->clicks()->firstOrCreate(
            [
                'campaign_id' => $click->campaign_id,
                'url'         => $click->url,
                'date'        => $click->time->date,
            ]
        );
    }
}