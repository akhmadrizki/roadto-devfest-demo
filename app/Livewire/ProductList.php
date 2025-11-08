<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Mount komponen - Lifecycle Hook
     * Best Practice: Inisialisasi properti di mount() untuk performa yang lebih baik
     */
    public function mount(): void
    {
        $this->search = '';
    }

    /**
     * Dengarkan pembaruan pencarian dari komponen ProductSearch
     * Component Communication: Event Listener
     */
    #[On('search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;
        $this->resetPage();  // Reset pagination ketika pencarian berubah
    }

    /**
     * Computed property untuk produk - Best Practice: Lazy Loading & Caching
     *
     * Manfaat:
     * - Cached sampai dependensi ($search) berubah
     * - Hanya dieksekusi ketika diperlukan
     * - Mengurangi database queries yang tidak perlu
     */
    #[Computed(persist: false, seconds: 0)]
    public function products()
    {
        $query = Product::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        // Best Practice: Pagination mengurangi penggunaan memori dan meningkatkan performa
        return $query
            ->orderBy('name')
            ->paginate(12);
    }

    /**
     * Render komponen
     */
    public function render()
    {
        return view('livewire.product-list', [
            'products' => $this->products,
        ]);
    }
}
