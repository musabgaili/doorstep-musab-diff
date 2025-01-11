<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
// implements filament lables and colors
enum ApartmentAvailability: int implements HasLabel, HasColor
{
    case Available = 1;
    case Unavailable = 0;

    public function getLabel(): string
    {
        return match($this)  {
            self::Available => 'Available',
            self::Unavailable => 'Unavailable',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Available => 'success',
            self::Unavailable => 'danger',
        };
    }


}



