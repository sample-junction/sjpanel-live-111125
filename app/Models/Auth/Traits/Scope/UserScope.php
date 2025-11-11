<?php

namespace App\Models\Auth\Traits\Scope;

/**
 * Class UserScope.
 */
trait UserScope
{
    /**
     * @param $query
     * @param bool $confirmed
     *
     * @return mixed
     */
    public function scopeConfirmed($query, $confirmed = true)
    {
        return $query->where('confirmed', $confirmed);
    }

    /**
     * @param $query
     * @param bool $status
     *
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where('active', $status);
    }

    /**
     * @param $query
     * @param bool $status
     *
     * @return mixed
     */
    public function scopeInviteAble($query, $status = true)
    {
        return $query->where('active', true)
            ->where('unsubscribed', false);
    }

    /**
     * @param $query
     * @param bool $status
     *
     * @return mixed
     */
    public function scopeInCountry($query, $country_code)
    {
        return $query->where('country_code', $country_code)
            ;
    }
}
