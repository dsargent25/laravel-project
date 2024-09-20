<x-app-layout>
    <x-chirps.chirp-box/>
    <div class="py-12">
        <div>
                <h1 class="chirp-feed-title">Your Chirp Flock:</h1>
                @foreach ($chirps as $chirp)
                    <x-chirps.chirp-card :chirp="$chirp"/>
                @endforeach
        </div>
    </div>
</x-app-layout>
