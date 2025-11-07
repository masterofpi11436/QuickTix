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
