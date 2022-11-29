<?php

namespace NormanHuth\Helpers\Macros;

use Carbon\Carbon;

trait CarbonTrait
{
    /**
     * @return string|Carbon|\Illuminate\Support\Carbon
     */
//    protected function getCarbonClass(): string|Carbon|\Illuminate\Support\Carbon
//    {
//        $laravel = 'Illuminate\\Support\\Carbon';
//
//        return class_exists($laravel) ? $laravel : Carbon::class;
//    }

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
        Carbon::macro('responseToDateTimeString', function (string $datetime): string {
            $offset = date('O')/100;
            $datetime = substr($datetime, 0, 19);
            return Carbon::createFromFormat('Y-m-d\TH:i:s', $datetime)
                ->addHours($offset)
                ->toDateTimeString();
        });
    }
}
