<?php

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Computed property untuk jumlah total produk
     * Volt Best Practice: Gunakan #[Computed] untuk operasi yang mahal
     */
    #[Computed]
    public function totalProducts(): int
    {
        return Product::count();
    }

    /**
     * Computed property untuk produk berdasarkan kategori
     * Menunjukkan bagaimana Volt dapat menangani agregasi data yang kompleks
     */
    #[Computed]
    public function productsByCategory(): array
    {
        return Product::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get()
            ->mapWithKeys(fn($item) => [$item->category => $item->count])
            ->toArray();
    }

    /**
     * Computed property untuk produk stok rendah (stock < 10)
     */
    #[Computed]
    public function lowStockCount(): int
    {
        return Product::where('stock', '<', 10)->count();
    }

    /**
     * Computed property untuk harga rata-rata
     */
    #[Computed]
    public function averagePrice(): float
    {
        return Product::avg('price') ?? 0;
    }

    /**
     * Computed property untuk total nilai stok
     */
    #[Computed]
    public function totalStockValue(): float
    {
        return Product::sum(DB::raw('price * stock')) ?? 0;
    }

    /**
     * Method untuk me-refresh statistik
     * Menunjukkan action methods di Volt
     */
    public function refresh(): void
    {
        // Hapus computed cache untuk memaksa perhitungan ulang
        unset($this->totalProducts);
        unset($this->productsByCategory);
        unset($this->lowStockCount);
        unset($this->averagePrice);
        unset($this->totalStockValue);

        $this->dispatch('stats-refreshed');
    }
};
?>

<div class="w-full space-y-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                Product Statistics
            </h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                Real-time product analytics powered by Livewire Volt
            </p>
        </div>
        <flux:button 
            variant="ghost" 
            wire:click="refresh"
            class="text-sm"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh
        </flux:button>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Products Card -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6 border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        Total Products
                    </p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">
                        {{ $this->totalProducts }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Low Stock Card -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6 border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        Low Stock
                    </p>
                    <p class="text-3xl font-bold {{ $this->lowStockCount > 0 ? 'text-red-600 dark:text-red-400' : 'text-neutral-900 dark:text-white' }} mt-2">
                        {{ $this->lowStockCount }}
                    </p>
                    <p class="text-xs text-neutral-500 dark:text-neutral-500 mt-1">
                        Products with stock &lt; 10
                    </p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Price Card -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6 border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        Average Price
                    </p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">
                        ${{ number_format($this->averagePrice, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stock Value Card -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6 border border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        Stock Value
                    </p>
                    <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">
                        ${{ number_format($this->totalStockValue, 2) }}
                    </p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Products by Category -->
    @if(count($this->productsByCategory) > 0)
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm p-6 border border-neutral-200 dark:border-neutral-700 mt-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">
                Products by Category
            </h3>
            <div class="space-y-3">
                @foreach($this->productsByCategory as $category => $count)
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-700 dark:text-neutral-300 font-medium">
                            {{ $category }}
                        </span>
                        <div class="flex items-center gap-3">
                            <div class="w-32 bg-neutral-200 dark:bg-neutral-700 rounded-full h-2">
                                <div 
                                    class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full transition-all duration-300"
                                    style="width: {{ ($count / $this->totalProducts) * 100 }}%"
                                ></div>
                            </div>
                            <span class="text-sm font-semibold text-neutral-900 dark:text-white w-8 text-right">
                                {{ $count }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Success Message -->
    <x-action-message class="mt-4" on="stats-refreshed">
        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Statistics refreshed successfully!
        </div>
    </x-action-message>
</div>

