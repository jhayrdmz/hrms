<?php

namespace App\Filament\Hr\Resources\DesignationResource\Pages;

use App\Filament\Hr\Resources\DesignationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDesignations extends ListRecords
{
    protected static string $resource = DesignationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
