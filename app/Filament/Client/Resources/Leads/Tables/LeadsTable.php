<?php

namespace App\Filament\Client\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TabsFilter;
use App\Filament\Resources\Actions\LeadTaggingAction;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead_title')
                    ->label('Lead Title')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable(),
                TextColumn::make('partner.name')
                    ->label('Company')
                    ->searchable()
                    ->placeholder('No company'),
                TextColumn::make('product')
                    ->label('Product')
                    ->state(function ($record) {
                        $state = $record->product;
                        if (empty($state)) {
                            return '-';
                        }
                        $ids = is_array($state) ? $state : json_decode($state, true);
                        if (!is_array($ids) || empty($ids)) {
                            return '-';
                        }
                        return \App\Models\ProductList::whereIn('id', $ids)->pluck('name')->implode(', ');
                    })
                    ->wrap()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'For Review',
                        'primary' => 'New',
                        'warning' => 'Contacted',
                        'success' => 'Qualified',
                        'danger' => 'Declined',
                        'danger' => 'Disputed',
                    ]),
                BadgeColumn::make('lead_type')
                    ->label('Lead Type')
                    ->color(fn (string $state): string => match ($state) {
                        'Procurement' => 'primary',
                        'Implementation' => 'warning',
                        'Support' => 'info',
                        'Consultation' => 'success',
                        'System Integration' => 'secondary',
                        'Other' => 'gray',
                        default => 'gray',
                    }),
                BadgeColumn::make('tag')
                    ->label('Tag')
                    ->color(fn (string $state = null): string => match ($state) {
                        'First' => 'info',
                        'Second' => 'warning',
                        'Third' => 'success',
                        default => 'gray',
                    })
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->date(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->date(),
            ])
                ->filters([
                    SelectFilter::make('status')
                        ->label('Status')
                        ->options([
                            'New' => 'New',
                            'Contacted' => 'Contacted',
                            'Qualified' => 'Qualified',
                            'Lost' => 'Lost',
                        ]),
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
                DeleteAction::make(),
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
