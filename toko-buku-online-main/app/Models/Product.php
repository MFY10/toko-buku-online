<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'category_buku',
        'nama_buku',
        'deskripsi',
        'harga',
        'stok',
        'url_image',
        'total_terjual',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_buku' , 'id');
    }

    public function getProduct()
    {
        return $this->select('product.*', 'kategori.nama_kategori')
        ->join('kategori', 'product.category_buku', '=', 'kategori.id')
        ->get();
    }
}
