<?php

use Vinkla\Hashids\Facades\Hashids;

/**
 * Description : [ prodEnv ] Returns true if the environment is set to production.
 */
function prodEnv(): bool
{
    return in_array(config('app.env'), ['production']);
}

/**
 * Description : [ devEnv ] Returns true if the environment is set to to development.
 */
function devEnv(): bool
{
    return in_array(config('app.env'), ['development']);
}

/**
 * Description : [ encrypt ] Encrypts a given string.
 *
 * @param  string  $id
 */
function encryption($id): string
{
    return Hashids::encode($id);
}

/**
 * Description : [ decrypt ] Decrypts a given string.
 *
 * @param  string  $id
 */
function decryption($id): ?int
{
    if (! is_string($id)) {
        return null;
    }
    $decodeId = Hashids::decode($id);

    return reset($decodeId);
}

/**
 * Description : [ formatDateForDatabase ] Converts user date format to database format.
 *
 * @param  string|null  $date  Date in user format (d-m-Y)
 * @return string|null Date in database format (Y-m-d)
 */
function formatDateForDatabase(?string $date): ?string
{
    if (! $date) {
        return null;
    }

    try {
        $carbonDate = \Carbon\Carbon::createFromFormat(config('constant.DEFAULT_DATE_FORMAT'), $date);

        return $carbonDate->format(config('constant.DEFAULT_DATABASE_DATE_FORMAT'));
    } catch (\Exception $e) {
        // If parsing fails, try with database format (already in correct format)
        try {
            $carbonDate = \Carbon\Carbon::parse($date);

            return $carbonDate->format(config('constant.DEFAULT_DATABASE_DATE_FORMAT'));
        } catch (\Exception $e) {
            return null;
        }
    }
}

/**
 * Description : [ formatDateForUser ] Converts database date format to user format.
 *
 * @param  string|null  $date  Date in database format (Y-m-d)
 * @return string|null Date in user format (d-m-Y)
 */
function formatDateForUser(?string $date): ?string
{
    if (! $date) {
        return null;
    }

    try {
        $carbonDate = \Carbon\Carbon::parse($date);

        return $carbonDate->format(config('constant.DEFAULT_DATE_FORMAT'));
    } catch (\Exception $e) {
        return null;
    }
}

/**
 * Description : [ formatDateTimeForUser ] Converts database datetime to user format.
 *
 * @param  string|null  $datetime  DateTime in database format
 * @return string|null DateTime in user format (d-m-Y h:i A)
 */
function formatDateTimeForUser(?string $datetime): ?string
{
    if (! $datetime) {
        return null;
    }

    try {
        $carbonDate = \Carbon\Carbon::parse($datetime);

        return $carbonDate->format(config('constant.DEFAULT_DATE_TIME_FORMAT'));
    } catch (\Exception $e) {
        return null;
    }
}
