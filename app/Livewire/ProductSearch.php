<?php

namespace App\Livewire;

use Livewire\Component;

class ProductSearch extends Component
{
    public string $search = '';
    public int $debounce = 300; // Debounce time in milliseconds

    /**
     * Mount the component - Lifecycle Hook
     * Called when the component is first initialized
     */
    public function mount(): void
    {
        // Initialize search term if needed
        $this->search = '';
    }

    /**
     * Updated lifecycle hook - called when a property is updated
     * This demonstrates reactive property updates
     */
    public function updatedSearch(): void
    {
        // Dispatch event to ProductList component when search changes
        $this->dispatch('search-updated', search: $this->search);
    }

    /**
     * Clear search functionality
     */
    public function clearSearch(): void
    {
        $this->search = '';
        $this->dispatch('search-updated', search: '');
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.product-search');
    }
}
