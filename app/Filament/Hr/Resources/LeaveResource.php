<?php

namespace App\Filament\Hr\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Leave;
use Filament\Forms\Form;
use App\Enums\LeaveStatus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Hr\Resources\LeaveResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Hr\Resources\LeaveResource\RelationManagers;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Attendance';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('employee_id')
                                    ->label('Employee')
                                    ->required()
                                    ->native(false)
                                    ->relationship(
                                        name: 'employee',
                                        modifyQueryUsing: function (Builder $query) {
                                            $query
                                                ->filterSuperAdmin()
                                                ->orderBy('first_name')
                                                ->orderBy('last_name');
                                        },
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}"),
                                Forms\Components\Select::make('leave_type_id')
                                    ->label('Leave type')
                                    ->required()
                                    ->native(false)
                                    ->relationship(name: 'leaveType', titleAttribute: 'name'),
                                Forms\Components\DatePicker::make('start_at')
                                    ->label('Start date')
                                    ->required()
                                    ->native(false)
                                    ->closeOnDateSelection(),
                                Forms\Components\DatePicker::make('end_at')
                                    ->label('End date')
                                    ->required()
                                    ->native(false)
                                    ->closeOnDateSelection(),
                            ])
                            ->columns(2),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Textarea::make('reason')
                                    ->rows(10)
                                    ->autosize()
                            ])
                            ->columnSpan(1)
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->native(false)
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Reject',
                                        'cancelled' => 'Cancelled',
                                        'request_cancellation' => 'Request Cancellation'
                                    ])
                                    ->default('pending'),
                                Forms\Components\Textarea::make('note')
                                    ->rows(5)
                                    ->autosize()
                            ])
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name']),
                // ->formatStateUsing(function ($state) {
                //     return "{$state->first_name} {$state->last_name}";
                // }),
                Tables\Columns\TextColumn::make('leaveType.name'),
                Tables\Columns\TextColumn::make('start_at')
                    ->label('Start')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->label('End')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('approvedBy')
                    ->formatStateUsing(function ($state) {
                        return $state ? "{$state->first_name} {$state->last_name}" : '--';
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Approved Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Filed')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', LeaveStatus::Pending)->count();
    }
}
