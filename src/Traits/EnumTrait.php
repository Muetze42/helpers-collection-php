<?php

namespace NormanHuth\Helpers\Traits;

use Illuminate\Support\Arr;

trait EnumTrait
{
    /**
     * Return value label array.
     *
     * @return array<string, string>
     */
    public static function toOptionsArray(): array
    {
        return Arr::mapWithKeys(self::cases(), function (self $enum) {
            return [$enum->value => $enum->label()];
        });
    }
}
