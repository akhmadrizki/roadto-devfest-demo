<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public string $search = '';

    /**
     * Mount the component - Lifecycle Hook
     * Best Practice: Initialize properties in mount() for better performance
     */
    public function mount(): void
    {
        $this->search = '';
    }

    /**
     * Listen for search updates from ProductSearch component
     * Component Communication: Event Listener
     */
    #[On('search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;
        $this->resetPage(); // Reset pagination when search changes
    }

    /**
     * Computed property for products - Best Practice: Lazy Loading & Caching
     * 
     * Benefits:
     * - Cached until dependencies ($search) change
     * - Only executes when needed
     * - Reduces unnecessary database queries
     */
    #[Computed(persist: false, seconds: 0)]
    public function products()
    {
        $query = Product::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        // Best Practice: Pagination reduces memory usage and improves performance
        return $query
            ->orderBy('name')
            ->paginate(12);
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.product-list', [
            'products' => $this->products,
        ]);
    }
}
