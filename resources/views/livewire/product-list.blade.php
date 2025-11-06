<div class="w-full" wire:loading.class="opacity-50">
    <div wire:loading class="mb-4 text-sm text-neutral-600 dark:text-neutral-400">
        Searching...
    </div>
    
    @if($products->count() > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <div class="group rounded-xl border border-neutral-200 bg-white p-6 shadow-sm transition-all hover:shadow-md dark:border-neutral-700 dark:bg-neutral-800">
                    <div class="mb-4 flex h-48 items-center justify-center rounded-lg bg-neutral-100 dark:bg-neutral-700">
                        <span class="text-4xl">📦</span>
                    </div>
                    
                    <h3 class="mb-2 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                        {{ $product->name }}
                    </h3>
                    
                    <p class="mb-4 line-clamp-2 text-sm text-neutral-600 dark:text-neutral-400">
                        {{ $product->description }}
                    </p>
                    
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <span class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </div>
                        <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-700 dark:bg-neutral-700 dark:text-neutral-300">
                            {{ $product->category }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-600 dark:text-neutral-400">
                            Stock: <span class="font-medium {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $product->stock }}
                            </span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center rounded-xl border border-neutral-200 bg-white py-12 dark:border-neutral-700 dark:bg-neutral-800">
            <div class="mb-4 text-6xl">🔍</div>
            <h3 class="mb-2 text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                No products found
            </h3>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">
                @if($search)
                    Try adjusting your search terms.
                @else
                    No products available at the moment.
                @endif
            </p>
        </div>
    @endif
</div>
