<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
      $this->categoryModel = new Category();   
      $this->productModel = new Product();
    }
    public function index()
    {
        $categories = $this->categoryModel->getCategory();
        $products = $this->productModel->getProduct();

        return view('pages.ecommerce.product', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_buku' => 'required|exists:kategori,id',
            'nama_buku' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'url_image' => 'required|image',
        ]);

        try {
          
            DB::beginTransaction();

            $imagePath = $request->file('url_image')->store('images/products', 'public'); // 

            $product = new Product();
            $product->category_buku = $validatedData['category_buku'];
            $product->nama_buku = $validatedData['nama_buku'];
            $product->deskripsi = $validatedData['deskripsi'];
            $product->harga = $validatedData['harga'];
            $product->stok = $validatedData['stok'];
            $product->url_image = $imagePath; 
            $product->total_terjual = 0; 
            $product->save();

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $productModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $productModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $productModel, string $id)
    {
        $validatedData = $request->validate([
            'category_buku' => 'required',
            'nama_buku' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'url_image' => 'nullable|image',
        ]);
    
        try {
            DB::beginTransaction();
    
            $product = Product::findOrFail($id);
    
            $product->category_buku = $validatedData['category_buku'] ?? $product->category_buku;
            $product->nama_buku = $validatedData['nama_buku'] ?? $product->nama_buku;
            $product->deskripsi = $validatedData['deskripsi'] ?? $product->deskripsi;
            $product->harga = $validatedData['harga'] ?? $product->harga;
            $product->stok = $validatedData['stok'] ?? $product->stok;
    
            if ($request->hasFile('url_image')) {

                if ($product->url_image && Storage::disk('public')->exists($product->url_image)) {
                    Storage::disk('public')->delete($product->url_image);
                }

                $imagePath = $request->file('url_image')->store('images/products', 'public');
                $product->url_image = $imagePath;
            }

            $product->save();
    
            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $productModel, string $id)
    {
        try {
            DB::beginTransaction();
    
            $product = Product::findOrFail($id);

            if ($product->url_image && Storage::disk('public')->exists($product->url_image)) {
                Storage::disk('public')->delete($product->url_image);
            }

            $product->delete();
    
            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
