<?php

namespace App\Modules\RemoteFilesImporter\Stages;

use App\Models\City;
use App\Models\Country;
use App\Models\Profile;
use App\Models\ProfileView;
use App\Models\State;
use App\Modules\Interfaces\IImportStage;

class GeoImportStage implements IImportStage
{
    /** @var Profile */
    private $profile;

    public function import(Profile $profile, \stdClass $jsonData): bool
    {
        $this->profile = $profile;

        $this->importCountry($jsonData);

        return true;
    }

    private function importCountry(\stdClass $jsonData): ?Country
    {
        if (isset($jsonData->custom_vars->geo->name)) {
            $country = Country::firstOrCreate(['name' => $jsonData->custom_vars->geo->name]);

            $this->importStates($jsonData, $country);
        }

        return null;
    }

    private function importStates(\stdClass $jsonData, Country $country): Country
    {

        if (isset($jsonData->custom_vars->geo->states) && is_array($jsonData->custom_vars->geo->states)) {
            foreach ($jsonData->custom_vars->geo->states as $state) {
                $stateModel = $country->states()->firstOrCreate(['name' => $state->name]);
                $this->importCities($state, $stateModel);
            }
        }

        return $country;
    }

    private function importCities(\stdClass $stateData, State $state)
    {
        if (isset($stateData->cities) && is_array($stateData->cities)) {
            foreach ($stateData->cities as $cityData) {
                $city = $state->cities()->firstOrCreate(['name' => $cityData->name]);
                $this->importProfileViews($cityData, $city);
            }
        }
    }

    private function importProfileViews(\stdClass $cityData, City $city)
    {
        ProfileView::updateOrCreate(
            [
                'profile_id' => $this->profile->profile_id,
                'city_id'    => $city->id,
            ],
            ['count' => $cityData->view_count]
        );
    }
}