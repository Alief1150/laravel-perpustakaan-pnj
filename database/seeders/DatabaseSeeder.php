<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private const PLACEHOLDER_PDF_BASE64 = 'JVBERi0xLjQKMSAwIG9iago8PCAvVHlwZSAvQ2F0YWxvZyAvUGFnZXMgMiAwIFIgPj4KZW5kb2JqCjIgMCBvYmoKPDwgL1R5cGUgL1BhZ2VzIC9LaWRzIFszIDAgUl0gL0NvdW50IDEgPj4KZW5kb2JqCjMgMCBvYmoKPDwgL1R5cGUgL1BhZ2UgL1BhcmVudCAyIDAgUiAvTWVkaWFCb3ggWzAgMCA2MTIgNzkyXSAvUmVzb3VyY2VzIDw8IC9Gb250IDw8IC9GMSA0IDAgUiA+PiA+PiAvQ29udGVudHMgNSAwIFIgPj4KZW5kb2JqCjQgMCBvYmoKPDwgL1R5cGUgL0ZvbnQgL1N1YnR5cGUgL1R5cGUxIC9CYXNlRm9udCAvSGVsdmV0aWNhID4+CmVuZG9iago1IDAgb2JqCjw8IC9MZW5ndGggMTE4ID4+CnN0cmVhbQpCVCAvRjEgMTggVGYgNzIgNzIwIFRkIChQbGFjZWhvbGRlciBQREYgZm9yIGxpYnJhcnkgYm9vayB1cGxvYWRzKSBUaiBUKiAoVGhpcyBmaWxlIHdhcyBnZW5lcmF0ZWQgYXV0b21hdGljYWxseS4pIFRqIEVUCmVuZHN0cmVhbQplbmRvYmoKeHJlZgowIDYKMDAwMDAwMDAwMCA2NTUzNSBmIAowMDAwMDAwMDA5IDAwMDAwIG4gCjAwMDAwMDAwNTggMDAwMDAgbiAKMDAwMDAwMDExNSAwMDAwMCBuIAowMDAwMDAwMjQxIDAwMDAwIG4gCjAwMDAwMDAzMTEgMDAwMDAgbiAKdHJhaWxlcgo8PCAvU2l6ZSA2IC9Sb290IDEgMCBSID4+CnN0YXJ0eHJlZgo0ODAKJSVFT0YK';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@pnj.ac.id'],
            [
                'name' => 'Admin PNJ',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'user_type' => null,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@pnj.ac.id'],
            [
                'name' => 'User PNJ',
                'password' => Hash::make('password'),
                'role' => 'user',
                'user_type' => 'student',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'teacher@pnj.ac.id'],
            [
                'name' => 'Teacher PNJ',
                'password' => Hash::make('password'),
                'role' => 'user',
                'user_type' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        $category = Category::updateOrCreate(
            ['slug' => 'teknologi-informasi'],
            [
                'name' => 'Teknologi Informasi',
                'description' => 'Materi pemrograman, basis data, jaringan, dan pengembangan web.',
            ]
        );

        $books = [
            [
                'title' => 'Steve Jobs: The Man Who Thought Different',
                'slug' => 'steve-jobs-the-man-who-thought-different',
                'author' => 'Karen Blumenthal',
                'publisher' => 'Bloomsbury Publishing PLC',
                'publication_year' => 2012,
                'isbn' => '1408832062',
                'description' => 'Biografi Steve Jobs karya Karen Blumenthal yang menyoroti perjalanan hidup, Apple, dan inovasi teknologi.',
                'cover_path' => 'books/covers/TI_Apple_page-0001.jpg',
                'pdf_path' => 'books/pdfs/steve-jobs-the-man-who-thought-different.pdf',
            ],
            [
                'title' => 'Linux Bible 2007 Edition',
                'slug' => 'linux-bible-2007-edition',
                'author' => 'Christopher Negus',
                'publisher' => 'Wiley',
                'publication_year' => 2007,
                'isbn' => '0470082798',
                'description' => 'Panduan Linux referensi yang membahas distribusi, instalasi, dan administrasi sistem.',
                'cover_path' => 'books/covers/TI_Cover_Linux_page-0001.jpg',
                'pdf_path' => 'books/pdfs/linux-bible-2007-edition.pdf',
            ],
            [
                'title' => "Dapur'e Mikrotik MTCNA",
                'slug' => 'dapure-mikrotik-mtcna',
                'author' => 'Aida Mahmudah',
                'publisher' => 'Self-published',
                'publication_year' => 2023,
                'isbn' => '9780000000017',
                'description' => 'Modul lab MikroTik MTCNA berisi latihan konfigurasi jaringan.',
                'cover_path' => 'books/covers/TI_Dapur_page-0001.jpg',
                'pdf_path' => 'books/pdfs/dapure-mikrotik-mtcna.pdf',
            ],
            [
                'title' => 'Laporan Cluster 1',
                'slug' => 'laporan-cluster-1',
                'author' => 'Alief A. P',
                'publisher' => 'SMK BISA-HEBAT / Cisco CCNA',
                'publication_year' => 2023,
                'isbn' => '9780000000024',
                'description' => 'Laporan praktikum Cluster 1 tentang materi jaringan dan CCNA.',
                'cover_path' => 'books/covers/TI_Cluster1_page-0001.jpg',
                'pdf_path' => 'books/pdfs/laporan-cluster-1.pdf',
            ],
            [
                'title' => 'Laporan Cluster 2',
                'slug' => 'laporan-cluster-2',
                'author' => 'Alief A. P',
                'publisher' => 'SMK BISA-HEBAT / Cisco CCNA',
                'publication_year' => 2023,
                'isbn' => '9780000000031',
                'description' => 'Laporan praktikum Cluster 2 tentang topologi jaringan, VLAN, dan VTP.',
                'cover_path' => 'books/covers/TI_Cluster2_page-0001.jpg',
                'pdf_path' => 'books/pdfs/laporan-cluster-2.pdf',
            ],
            [
                'title' => 'Laporan Cluster 3',
                'slug' => 'laporan-cluster-3',
                'author' => 'Alief A. P',
                'publisher' => 'MikroTik Academy / SMK BISA-HEBAT',
                'publication_year' => 2023,
                'isbn' => '9780000000048',
                'description' => 'Laporan praktikum Cluster 3 tentang konfigurasi routing pada perangkat jaringan komputer.',
                'cover_path' => 'books/covers/TI_Cluster3_page-0001.jpg',
                'pdf_path' => 'books/pdfs/laporan-cluster-3.pdf',
            ],
        ];

        Storage::disk('private')->makeDirectory('books/pdfs');

        foreach ($books as $bookData) {
            Book::updateOrCreate(
                ['slug' => $bookData['slug']],
                [
                    'category_id' => $category->id,
                    'title' => $bookData['title'],
                    'author' => $bookData['author'],
                    'publisher' => $bookData['publisher'],
                    'publication_year' => $bookData['publication_year'],
                    'isbn' => $bookData['isbn'],
                    'description' => $bookData['description'],
                    'cover_path' => $bookData['cover_path'],
                    'pdf_path' => $bookData['pdf_path'],
                    'epub_path' => null,
                    'stock' => 10,
                    'status' => Book::STATUS_AVAILABLE,
                ]
            );

            if (! Storage::disk('private')->exists($bookData['pdf_path'])) {
                Storage::disk('private')->put($bookData['pdf_path'], base64_decode(self::PLACEHOLDER_PDF_BASE64));
            }
        }
    }
}
