<?php

declare(strict_types=1);

namespace App\Filament\Resources\TagResource\RelationManagers;

use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    BelongsToSelect::make('category_id')
                        ->relationship('category', 'name')
                        ->required(),
                    TextInput::make('title')
                        ->label('Title')
                        ->reactive()
                        ->afterStateUpdated(function (callable $set, $state) {
                            $set('slug', Str::slug($state));
                        })
                        ->required(),
                    TextInput::make('slug')->required(),
                    SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->collection('posts'),
                    RichEditor::make('content')->required(),
                    Toggle::make('is_publish')->required()
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->sortable(),
                TextColumn::make('slug'),
                BooleanColumn::make('is_publish'),
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('posts')
                    ->label('Thumbnail'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
