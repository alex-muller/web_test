<?php

namespace App\Modules\Interfaces;

use App\Models\Profile;

interface IImportStage
{
    public function import(Profile $profile, \stdClass $jsonData) : bool;
}