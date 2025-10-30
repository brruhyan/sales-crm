<?php

namespace App\Filament\Client\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('company')->label('Company'),
                TextColumn::make('type')->label('Type'),
                BadgeColumn::make('source')
                    ->label('Source')
                    ->colors([
                        'primary' => 'Website',
                        'info' => 'Referral',
                        'success' => 'Social Media',
                        'gray' => 'Other',
                    ]),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'New',
                        'warning' => 'Contacted',
                        'success' => 'Qualified',
                        'danger' => 'Lost',
                    ]),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('type')
                    ->options([
                        'Website' => 'Website',
                        'Referral' => 'Referral',
                        'Social Media' => 'Social Media',
                        'Other' => 'Other',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
