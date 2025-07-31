<button @click="active = '{{ $name }}'" class="px-4 py-2" :class="{ 'font-bold border-b-2': active === '{{ $name }}' }">
    {{ $slot }}
</button>