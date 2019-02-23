<?php

namespace App\Modules\RemoteFilesImporter\Stages;

use App\Models\Profile;
use App\Models\Subscription;
use App\Modules\Interfaces\IImportStage;

class SubscriptionImportStage implements IImportStage
{

    public function import(Profile $profile, \stdClass $jsonData): bool
    {
        if (isset($jsonData->custom_vars->current_subscriptions) && is_array($jsonData->custom_vars->current_subscriptions)) {
            foreach ($jsonData->custom_vars->current_subscriptions as $subscriptionData) {
                $this->importSubscriptions($subscriptionData, $profile);
            }

            return true;
        }

        return false;
    }

    private function importSubscriptions(\stdClass $subscriptionData, Profile $profile): void
    {
        $subscription = Subscription::firstOrCreate(
            ['id' => $subscriptionData->id],
            ['name' => $subscriptionData->name]
        );

        $profile->subscriptions()->attach($subscription, ['subscribed_at' => $subscriptionData->time->date]);
    }
}