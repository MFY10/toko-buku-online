<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Products</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <x-ecommerce.form-add-product :categories="$categories" />
            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 gap-6">
            <table id="table-product">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Nama Product
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Deskripsi
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Kategori
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Harga
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Stok
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr id="product-{{ $product->id }}">
                            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $product->nama_buku }}</td>
                            <td>{{ $product->deskripsi }}</td>
                            <td>{{ $product->nama_kategori }}</td>
                            <td>Rp {{ $product->harga }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>
                                <x-ecommerce.form-edit-product :prodId="$product->id" :prodName="$product->nama_buku" :prodDesc="$product->deskripsi"
                                    :prodCat="$product->nama_kategori" :prodCatId="$product->category_buku" :prodPrice="$product->harga" :prodStok="$product->stok"
                                    :prodImg="$product->url_image" :categories="$categories" />

                                <x-ecommerce.confirmation-delete :id="$product->id" :type="'Product'"
                                    :route="'delete-product'" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if (session('success'))
                <div class="relative">
                    <div class="absolute bottom-0 right-0">
                        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Success alert!</span> {{ session('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('warning'))
                <div class="relative">
                    <div class="absolute bottom-0 right-0">
                        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Warning alert!</span> {{ session('warning') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="relative">
                    <div class="absolute bottom-0 right-0">
                        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Danger alert!</span> {{ session('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
