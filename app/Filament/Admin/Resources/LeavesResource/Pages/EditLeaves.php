<?php

namespace App\Filament\Admin\Resources\LeavesResource\Pages;

use App\Filament\Admin\Resources\LeavesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeaves extends EditRecord
{
    protected static string $resource = LeavesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
