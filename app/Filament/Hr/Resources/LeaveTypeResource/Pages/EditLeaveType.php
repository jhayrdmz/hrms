<?php

namespace App\Filament\Hr\Resources\LeaveTypeResource\Pages;

use App\Filament\Hr\Resources\LeaveTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaveType extends EditRecord
{
    protected static string $resource = LeaveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
