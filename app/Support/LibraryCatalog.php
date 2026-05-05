<?php

namespace App\Support;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class LibraryCatalog
{
    public static function categories(): array
    {
        try {
            if (Category::query()->exists()) {
                return Category::query()
                    ->withCount('books')
                    ->orderBy('name')
                    ->get()
                    ->map(fn (Category $category) => self::formatCategory($category->name, $category->slug, $category->description, (int) $category->books_count))
                    ->all();
            }
        } catch (Throwable) {
            // Fall back to seed data when the database is unavailable.
        }

        return array_map(
            fn (array $category) => self::formatCategory(
                $category['name'],
                $category['slug'],
                $category['description'],
                $category['book_count'] ?? 0,
            ),
            self::seedData()['categories'],
        );
    }

    public static function books(): array
    {
        try {
            if (Book::query()->exists()) {
                return Book::query()
                    ->with('category')
                    ->orderByDesc('created_at')
                    ->get()
                    ->map(fn (Book $book) => self::formatBook($book))
                    ->all();
            }
        } catch (Throwable) {
            // Fall back to seed data when the database is unavailable.
        }

        return array_map(fn (array $book) => self::formatSeedBook($book), self::seedData()['books']);
    }

    public static function featuredBooks(int $limit = 6): array
    {
        return array_slice(
            array_values(array_filter(self::books(), fn (array $book) => $book['status'] === Book::STATUS_AVAILABLE)),
            0,
            $limit
        );
    }

    public static function filterBooks(?string $search = null, ?string $category = null): array
    {
        $books = self::books();

        if ($search !== null && $search !== '') {
            $needle = Str::lower($search);

            $books = array_values(array_filter($books, function (array $book) use ($needle) {
                $haystack = Str::lower(implode(' ', [
                    $book['title'],
                    $book['author'],
                    $book['publisher'],
                    $book['isbn'],
                ]));

                return str_contains($haystack, $needle);
            }));
        }

        if ($category !== null && $category !== '') {
            $books = array_values(array_filter($books, fn (array $book) => $book['category_slug'] === $category));
        }

        return $books;
    }

    public static function findBookBySlug(string $slug): ?array
    {
        foreach (self::books() as $book) {
            if ($book['slug'] === $slug) {
                return $book;
            }
        }

        return null;
    }

    public static function relatedBooks(string $slug, int $limit = 3): array
    {
        $book = self::findBookBySlug($slug);

        if ($book === null) {
            return [];
        }

        return array_slice(array_values(array_filter(self::books(), function (array $candidate) use ($book, $slug) {
            return $candidate['slug'] !== $slug
                && $candidate['category_slug'] === $book['category_slug']
                && $candidate['status'] === Book::STATUS_AVAILABLE;
        })), 0, $limit);
    }

    public static function stats(): array
    {
        $books = self::books();

        return [
            'books' => count($books),
            'categories' => count(self::categories()),
            'available' => count(array_filter($books, fn (array $book) => $book['status'] === Book::STATUS_AVAILABLE)),
            'formats' => count(array_filter($books, fn (array $book) => $book['pdf_available'] || $book['epub_available'])),
        ];
    }

    public static function seedData(): array
    {
        return [
            'categories' => [
                ['name' => 'Teknologi Informasi', 'slug' => 'teknologi-informasi', 'description' => 'Materi pemrograman, basis data, jaringan, dan pengembangan web.'],
                ['name' => 'Sistem Informasi', 'slug' => 'sistem-informasi', 'description' => 'Referensi analisis sistem, desain aplikasi, dan manajemen data.'],
                ['name' => 'Elektronika', 'slug' => 'elektronika', 'description' => 'Buku pengantar perangkat keras, mikrokontroler, dan instrumentasi.'],
                ['name' => 'Manajemen', 'slug' => 'manajemen', 'description' => 'Rujukan organisasi, kepemimpinan, kewirausahaan, dan operasional.'],
                ['name' => 'Bahasa dan Komunikasi', 'slug' => 'bahasa-dan-komunikasi', 'description' => 'Literatur akademik untuk presentasi, penulisan ilmiah, dan bahasa Inggris.'],
            ],
            'books' => [
                ['title' => 'Pemrograman Web Modern dengan Laravel', 'slug' => 'pemrograman-web-modern-dengan-laravel', 'author' => 'A. Nugraha', 'publisher' => 'PNJ Press', 'publication_year' => 2024, 'isbn' => '978-602-1234-01-0', 'category_slug' => 'teknologi-informasi', 'description' => 'Panduan membangun aplikasi web modern dengan pola kerja yang rapi, autentikasi, dan deployment dasar untuk lingkungan kampus.', 'stock' => 12, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => true],
                ['title' => 'Dasar-Dasar Basis Data untuk Mahasiswa', 'slug' => 'dasar-dasar-basis-data-untuk-mahasiswa', 'author' => 'R. Hidayat', 'publisher' => 'Andalan Informatika', 'publication_year' => 2023, 'isbn' => '978-602-1234-02-7', 'category_slug' => 'teknologi-informasi', 'description' => 'Konsep relational database, normalisasi, transaksi, dan desain tabel yang mudah diikuti untuk tugas kuliah.', 'stock' => 9, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => false],
                ['title' => 'Analisis dan Perancangan Sistem Informasi', 'slug' => 'analisis-dan-perancangan-sistem-informasi', 'author' => 'S. Wijaya', 'publisher' => 'PNJ Press', 'publication_year' => 2022, 'isbn' => '978-602-1234-03-4', 'category_slug' => 'sistem-informasi', 'description' => 'Membahas kebutuhan pengguna, pemodelan proses bisnis, dan penerjemahan kebutuhan ke rancangan aplikasi.', 'stock' => 6, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => true],
                ['title' => 'Dasar Elektronika dan Instrumentasi', 'slug' => 'dasar-elektronika-dan-instrumentasi', 'author' => 'M. Arifin', 'publisher' => 'Teknika Media', 'publication_year' => 2021, 'isbn' => '978-602-1234-04-1', 'category_slug' => 'elektronika', 'description' => 'Referensi pengenalan komponen, rangkaian dasar, dan alat ukur yang dipakai pada praktik laboratorium.', 'stock' => 4, 'status' => Book::STATUS_UNAVAILABLE, 'pdf_available' => false, 'epub_available' => true],
                ['title' => 'Manajemen Operasional untuk Institusi Pendidikan', 'slug' => 'manajemen-operasional-untuk-institusi-pendidikan', 'author' => 'L. Prasetyo', 'publisher' => 'Nusantara Edu', 'publication_year' => 2024, 'isbn' => '978-602-1234-05-8', 'category_slug' => 'manajemen', 'description' => 'Membahas alur kerja, pengelolaan aset, dan penjadwalan yang relevan untuk lingkungan kampus dan perpustakaan.', 'stock' => 11, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => false],
                ['title' => 'English for Academic Presentation', 'slug' => 'english-for-academic-presentation', 'author' => 'N. Anderson', 'publisher' => 'Global Scholar', 'publication_year' => 2020, 'isbn' => '978-602-1234-06-5', 'category_slug' => 'bahasa-dan-komunikasi', 'description' => 'Latihan bahasa Inggris untuk presentasi akademik, penulisan abstrak, dan komunikasi formal.', 'stock' => 7, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => true],
                ['title' => 'Dasar-Dasar Jaringan Komputer', 'slug' => 'dasar-dasar-jaringan-komputer', 'author' => 'T. Rahman', 'publisher' => 'PNJ Press', 'publication_year' => 2023, 'isbn' => '978-602-1234-07-2', 'category_slug' => 'teknologi-informasi', 'description' => 'Mengenal topologi jaringan, subnetting, troubleshooting, dan dasar pengelolaan jaringan lokal.', 'stock' => 0, 'status' => Book::STATUS_DRAFT, 'pdf_available' => false, 'epub_available' => false],
                ['title' => 'Kewirausahaan dan Inovasi Kampus', 'slug' => 'kewirausahaan-dan-inovasi-kampus', 'author' => 'D. Setiawan', 'publisher' => 'Edupreneur', 'publication_year' => 2024, 'isbn' => '978-602-1234-08-9', 'category_slug' => 'manajemen', 'description' => 'Buku ringkas mengenai ide usaha, validasi masalah, dan pengembangan proyek kewirausahaan mahasiswa.', 'stock' => 5, 'status' => Book::STATUS_AVAILABLE, 'pdf_available' => true, 'epub_available' => true],
            ],
        ];
    }

    private static function formatCategory(string $name, string $slug, ?string $description, int $bookCount): array
    {
        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $description ?? '',
            'accent' => self::accentFor($slug),
            'book_count' => $bookCount,
        ];
    }

    private static function formatBook(Book $book): array
    {
        return [
            'title' => $book->title,
            'slug' => $book->slug,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'publication_year' => $book->publication_year,
            'isbn' => $book->isbn,
            'category_slug' => $book->category?->slug ?? '',
            'category_name' => $book->category?->name ?? 'Kategori',
            'description' => $book->description ?? '',
            'stock' => $book->stock,
            'status' => $book->status,
            'cover_url' => filled($book->cover_path) ? Storage::disk('public')->url($book->cover_path) : null,
            'pdf_available' => filled($book->pdf_path),
            'epub_available' => filled($book->epub_path),
            'accent' => self::accentFor($book->slug),
            'initials' => self::initialsFor($book->title),
        ];
    }

    private static function formatSeedBook(array $book): array
    {
        $category = collect(self::seedData()['categories'])->firstWhere('slug', $book['category_slug']);

        return [
            ...$book,
            'category_name' => $category['name'] ?? 'Kategori',
            'cover_url' => null,
            'accent' => self::accentFor($book['slug']),
            'initials' => self::initialsFor($book['title']),
        ];
    }

    private static function initialsFor(string $title): string
    {
        return collect(explode(' ', $title))
            ->filter()
            ->take(2)
            ->map(fn (string $word) => Str::upper(Str::substr($word, 0, 1)))
            ->implode('');
    }

    private static function accentFor(string $key): array
    {
        $palette = [
            ['from' => '#fffdf5', 'via' => '#fde68a', 'to' => '#f59e0b'],
            ['from' => '#fffef7', 'via' => '#fef3c7', 'to' => '#fbbf24'],
            ['from' => '#fff8df', 'via' => '#fcd34d', 'to' => '#d97706'],
            ['from' => '#fffef2', 'via' => '#fde68a', 'to' => '#eab308'],
            ['from' => '#fff7db', 'via' => '#fcd34d', 'to' => '#ca8a04'],
            ['from' => '#fffdf0', 'via' => '#fde68a', 'to' => '#f59e0b'],
        ];

        return $palette[crc32($key) % count($palette)];
    }
}
