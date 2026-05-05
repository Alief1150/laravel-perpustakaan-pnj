<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state): void {
                        $set('slug', Str::slug($state ?? ''));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->helperText('Slug mengikuti judul dan bisa disesuaikan jika perlu.'),
                TextInput::make('author')
                    ->required(),
                TextInput::make('publisher')
                    ->required(),
                TextInput::make('publication_year')
                    ->required()
                    ->integer()
                    ->inputMode('numeric'),
                TextInput::make('isbn')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('cover_path')
                    ->image()
                    ->disk('public')
                    ->directory('books/covers')
                    ->maxSize(5120)
                    ->columnSpanFull(),
                FileUpload::make('pdf_path')
                    ->disk('private')
                    ->directory('books/pdfs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(20480)
                    ->columnSpanFull(),
                FileUpload::make('epub_path')
                    ->disk('private')
                    ->directory('books/epubs')
                    ->acceptedFileTypes(['application/epub+zip'])
                    ->maxSize(20480)
                    ->columnSpanFull(),
                TextInput::make('stock')
                    ->required()
                    ->integer()
                    ->inputMode('numeric')
                    ->default(0),
                Select::make('status')
                    ->required()
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                        'draft' => 'Draft',
                    ])
                    ->default('draft'),
            ]);
    }
}
