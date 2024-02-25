<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum LeaveStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';

    case Approved = 'approved';

    case Rejected = 'rejected';

    case Cancelled = 'cancelled';

    case RequestCancellation = 'request_cancellation';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::Cancelled => 'Cancelled',
            self::RequestCancellation => 'Request Cancellation',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Cancelled => 'gray',
            self::RequestCancellation => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-arrow-path',
            self::Approved => 'heroicon-m-check',
            self::Rejected => 'heroicon-m-x-circle',
            self::Cancelled => 'heroicon-m-x-circle',
            self::RequestCancellation => 'heroicon-m-arrow-uturn-left',
        };
    }
}
