<div>
    <div>
        <div>
            <form action="<?= e($_ENV["APP_URL"]) ?>/search" method="GET">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400 z-10 pointer-events-none"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input
                        type="search"
                        name="q"
                        id="main-search"
                        value="<?= e($query) ?>"
                        placeholder="Search for products, categories, brands..."
                        class="input input-bordered h-14 pl-12 rounded-2xl w-full text-sm focus:input-primary"
                    />
                </div>
            </form>
        </div>
    </div>
</div>