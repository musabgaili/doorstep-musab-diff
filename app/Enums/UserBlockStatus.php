<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
// implements filament lables and colors
enum UserBlockStatus: int implements HasLabel, HasColor
{
    case Blocked = 1;
    case NotBlocked = 0;

    public function getLabel(): string
    {
        return match($this)  {
            self::Blocked => 'Yes',
            self::NotBlocked => 'No',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Blocked => 'success',
            self::NotBlocked => 'danger',
        };
    }


}



