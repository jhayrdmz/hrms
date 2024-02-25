<?php

namespace App\Filament\Admin\Resources\LeavesResource\Pages;

use App\Enums\LeaveStatus;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Admin\Resources\LeavesResource;
use App\Models\Leave;

class ListLeaves extends ListRecords
{
    protected static string $resource = LeavesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')->badge(Leave::query()->count()),
            'pending' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeaveStatus::Pending))
                ->badge(Leave::query()->where('status', LeaveStatus::Pending)->count()),
            'approved' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeaveStatus::Approved))
                ->badge(Leave::query()->where('status', LeaveStatus::Approved)->count()),
            'rejected' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeaveStatus::Rejected))
                ->badge(Leave::query()->where('status', LeaveStatus::Rejected)->count()),
            'cancelled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeaveStatus::Cancelled))
                ->badge(Leave::query()->where('status', LeaveStatus::Cancelled)->count()),
            'request_cancellation' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', LeaveStatus::RequestCancellation))
                ->badge(Leave::query()->where('status', LeaveStatus::RequestCancellation)->count()),
        ];
    }
}
