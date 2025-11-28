<?php

namespace App\Filament\Resources\LeadTrackings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Deal;
use App\Models\Leads;
use App\Models\User;
use App\Filament\Resources\Actions\LeadTaggingAction;

class LeadTrackingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Lead by')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lead_title')
                    ->label('Lead Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Lead Status')
                    ->badge()
                    ->color(function ($state) {
                        return match (strtolower($state)) {
                            'for review' => 'danger',
                            'new' => 'primary',
                            'contacted' => 'secondary',
                            'qualified' => 'success',
                            'disputed' => 'danger',
                            'lost' => 'danger',
                            default => 'secondary',
                        };
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tag')
                    ->label('Tag')
                    ->badge()
                    ->color(fn (string $state = null): string => match ($state) {
                        'First' => 'info',
                        'Second' => 'warning',
                        'Third' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i A')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y H:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('Filter by User')
                    ->relationship('user', 'name')
                    ->multiple()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'New' => 'New',
                        'Contacted' => 'Contacted',
                        'Qualified' => 'Qualified',
                        'For Review' => 'For Review',
                        'Declined' => 'Declined',
                        'Disputed' => 'Disputed',
                    ]),
                SelectFilter::make('lead_type')
                    ->label('Filter by Solution Type')
                    ->options([
                        'Procurement' => 'Procurement',
                        'Implementation' => 'Implementation',
                        'Support' => 'Support',
                        'Consultation' => 'Consultation',
                        'System Integration' => 'System Integration',
                        'Other' => 'Other',
                    ]),
                SelectFilter::make('company')
                    ->label('Filter by Company')
                    ->relationship('contact', 'company')
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                LeadTaggingAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
