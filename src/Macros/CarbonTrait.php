<?php

namespace NormanHuth\Helpers\Macros;

use Carbon\Carbon;

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
     * Format API datetime strings to Carbon include App timezone conversion
     *
     * @return void
     */
    protected function responseToDateTimeString(): void
    {
        Carbon::macro('responseToDateTimeString', function (string $datetime, bool $addOffset = false): string {
            $datetime = substr($datetime, 0, 19);
            $date = Carbon::createFromFormat('Y-m-d\TH:i:s', $datetime);
            if ($addOffset) {
                $offset = $date->getOffset();$date
                    ->addSeconds($offset);
            }

            return $date->toDateTimeString();
        });
    }
}
