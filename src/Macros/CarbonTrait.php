<?php

namespace NormanHuth\Helpers\Macros;

use Carbon\Carbon;
use DateTimeInterface;

trait CarbonTrait
{
    /**
     * @return void
     */
    protected function addToAppDateString(): void
    {
        Carbon::macro('toAppDateString', function () {
            return Carbon::format('d.m.Y');
        });
    }

    /**
     * Format API datetime strings to Carbon include App timezone conversion.
     *
     * @return void
     */
    protected function responseToDateTimeString(): void
    {
        Carbon::macro('responseToDateTimeString', function (string $datetime, bool $addOffset = false): string {
            $date = Carbon::createFromFormat(DateTimeInterface::ATOM, $datetime);
            if ($addOffset) {
                $offset = $date->getOffset();$date
                    ->addSeconds($offset);
            }

            return $date->toDateTimeString();
        });
    }
}
