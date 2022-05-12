<?php

namespace App\Export;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ["ID", "Title", "Description", 'User ID'];
    }

    public function collection()
    {
        return Post::select('id', 'title', 'description', 'user_id')->get();
    }
}