<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SondagesResource\Pages;
use App\Filament\Resources\SondagesResource\RelationManagers;
use App\Models\Post;
use App\Models\Sondages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SondagesResource extends Resource
{
    protected static ?string $model = Post::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Voir tous les sondages';
    protected static ?string $modelLabel = 'Sondages';


    protected static ?string $title = 'Sondages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('questions')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSondages::route('/'),
            'create' => Pages\CreateSondages::route('/create'),
            'edit' => Pages\EditSondages::route('/{record}/edit'),
        ];
    }
}
