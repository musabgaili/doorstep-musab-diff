<?php

namespace App\Enums;

// use Filament\Support\Contracts\HasColor;
// use Filament\Support\Contracts\HasLabel;
// implements filament lables and colors
enum VisitRequestStatus: string
{
    // 'pending', 'approved', 'rejected'
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match($this)  {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Approved => 'success',
            self::Rejected => 'danger',
        };
    }


}



