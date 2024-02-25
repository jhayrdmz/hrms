<?php

namespace App\Filament\Admin\Resources\LeavesResource\Pages;

use App\Filament\Admin\Resources\LeavesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaves extends CreateRecord
{
    protected static string $resource = LeavesResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['approved_by'] = auth()->user()->id;

        return $data;
    }
}
