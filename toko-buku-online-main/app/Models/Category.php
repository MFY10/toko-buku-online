<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_buku', 'id');
    }

    public function getCategory()
    {
        return Category::withCount(['products as total_stock' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(stok), 0)'));
        }])->get();
    }
}
