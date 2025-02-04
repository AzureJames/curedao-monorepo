<?php

declare(strict_types=1);

namespace App\DataSources\Connectors\Fitbit\User;

use App\DataSources\Connectors\Fitbit\Api\Fitbit;

class User
{
    private $fitbit;

    public function __construct(Fitbit $fitbit)
    {
        $this->fitbit = $fitbit;
    }

    /**
     * Returns a user's profile. The authenticated owner receives
     * all values. Access to other user's profile is not available.
     * If you wish to retrieve the profile information of the
     * authenticated owner's friends, use GetFriends.
     */
    public function getProfile()
    {
        return $this->fitbit->get('profile.json');
    }

    /**
     * Updates the current user profile.
     *
     * @param Profile $profile
     */
    public function updateProfile(Profile $profile)
    {
        return $this->fitbit->post('profile.json?' . $profile->asUrlParam());
    }

    /**
     * Retrieves the user's badges in the format requested. Response
     * includes all badges for the user as seen on the Fitbit website
     * badge locker (both activity and weight related.).
     */
    public function getBadges()
    {
        return $this->fitbit->get('badges.json');
    }
}
