<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function pdf(Book $book)
    {
        return $this->download($book, 'pdf');
    }

    public function epub(Book $book)
    {
        return $this->download($book, 'epub');
    }

    private function download(Book $book, string $type)
    {
        abort_unless(auth()->check(), 403);
        abort_unless($book->status === Book::STATUS_AVAILABLE, 404);

        $path = $type === 'pdf' ? $book->pdf_path : $book->epub_path;

        abort_if(empty($path), 404);

        return Storage::disk('private')->download(
            $path,
            sprintf('%s.%s', $book->slug, $type)
        );
    }
}
