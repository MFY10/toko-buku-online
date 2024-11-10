<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{
    protected $categoryModel;

    public function __construct()
    {
      $this->categoryModel = new Category();   
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategory();

        return view('pages.ecommerce.category', compact('categories'));
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
        try {
            $validatedData = $request->validate([
                'nama_kategori' => 'required|string|unique:kategori,nama_kategori|max:255',
            ], [
                'nama_kategori.required' => 'Nama kategori harus diisi.',
                'nama_kategori.string' => 'Nama kategori harus berupa string.',
                'nama_kategori.unique' => 'Kategori sudah ada.',
                'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            ]);

            Category::create($validatedData);
            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errors); 
    
            return redirect()->back()->with('warning', $errorMessage);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kategori gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
           
            $category = Category::findOrFail($id);
    
            $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $category->id,
            ], [
                'nama_kategori.required' => 'Nama kategori harus diisi.',
                'nama_kategori.string' => 'Nama kategori harus berupa string.',
                'nama_kategori.unique' => 'Kategori sudah ada.',
                'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            ]);
    
            $category->nama_kategori = $request->input('nama_kategori');
            $category->save();
    
            return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('warning', $errorMessage);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kategori gagal diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {           
            $category = Category::findOrFail($id);
    
            $category->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kategori gagal dihapus');
        }   
    }
}
