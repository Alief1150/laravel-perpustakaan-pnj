<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Support\LibraryCatalog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));

        return view('catalog.index', [
            'search' => $search,
            'category' => $category,
            'categories' => LibraryCatalog::categories(),
            'books' => LibraryCatalog::filterBooks($search, $category),
        ]);
    }

    public function show(string $slug): View
    {
        $book = LibraryCatalog::findBookBySlug($slug);

        abort_if($book === null, 404);

        return view('catalog.show', [
            'book' => $book,
            'relatedBooks' => LibraryCatalog::relatedBooks($book['slug']),
        ]);
    }
}
