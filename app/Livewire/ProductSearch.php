<?php

namespace App\Livewire;

use Livewire\Component;

class ProductSearch extends Component
{
    // Properti publik untuk menyimpan istilah pencarian
    public string $search = '';
    public int $debounce = 300;  // Waktu debounce dalam milidetik

    /**
     * Mount komponen - Lifecycle Hook
     * Dipanggil ketika komponen pertama kali diinisialisasi
     */
    public function mount(): void
    {
        // Inisialisasi istilah pencarian jika diperlukan
        $this->search = '';
    }

    /**
     * Updated lifecycle hook - dipanggil ketika properti diperbarui
     * Ini menunjukkan pembaruan properti reaktif
     */
    public function updatedSearch(): void
    {
        // Kirim event ke komponen ProductList ketika pencarian berubah
        $this->dispatch('search-updated', search: $this->search);
    }

    /**
     * Fungsi untuk membersihkan pencarian
     */
    public function clearSearch(): void
    {
        $this->search = '';
        $this->dispatch('search-updated', search: '');
    }

    /**
     * Render komponen
     */
    public function render()
    {
        return view('livewire.product-search');
    }
}
