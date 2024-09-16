<x-app-layout>
    <x-chirps.chirp-box/>
    <div class="mx-auto p-4 sm:p-6 lg:p-8 mt-15">
        @foreach ($chirps as $chirp)
            <x-chirps.chirp-card :chirp="$chirp"/>
        @endforeach
    </div>
</x-app-layout>
