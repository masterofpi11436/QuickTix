@props([
    'variant' => 'dropdown', // options: dropdown | responsive
])

@if ($variant === 'dropdown')
    <!-- Dropdown (desktop) version -->
    <x-dropdown-link
        href="#"
        x-data="{ theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }"
        @click.prevent="
            const html = document.documentElement;
            theme = html.classList.toggle('dark') ? 'dark' : 'light';
            fetch('/user/theme', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme }),
            });
        "
    >
        <span x-text="theme === 'dark' ? 'Light' : 'Dark'"></span> theme
    </x-dropdown-link>
@elseif ($variant === 'responsive')
    <!-- Mobile / responsive version -->
    <button
        x-data="{ theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }"
        @click.prevent="
            const html = document.documentElement;
            theme = html.classList.toggle('dark') ? 'dark' : 'light';
            fetch('/user/theme', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme }),
            });
        "
        class="w-full text-start"
    >
        <x-responsive-nav-link>
            <span x-text="theme === 'dark' ? 'Light' : 'Dark'"></span> theme
        </x-responsive-nav-link>
    </button>
@endif
