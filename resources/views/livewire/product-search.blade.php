<div class="w-full">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex-1">
            <flux:input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search products by name, description, or category..."
                class="w-full"
            />
        </div>
        @if($search)
            <flux:button
                wire:click="clearSearch"
                variant="ghost"
                class="whitespace-nowrap"
            >
                Clear
            </flux:button>
        @endif
    </div>
    
    @if($search)
        <div class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
            Searching for: <span class="font-medium">{{ $search }}</span>
        </div>
    @endif
</div>
