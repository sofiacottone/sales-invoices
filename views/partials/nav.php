<nav class="w-full sticky top-0 bg-gray-800 z-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex">
                    <img class="w-12 h-8" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/711px-PHP-logo.svg.png" alt="Your Company">
                </div>
                <div class="flex gap-4">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="<?= urlIs('/') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    </div>
                    <div class="flex items-baseline space-x-4">
                        <a href="/invoices/create" class="<?= urlIs('/invoices/create') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-sm font-medium">Crea</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>