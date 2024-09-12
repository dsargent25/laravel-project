<x-app-layout>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

            @foreach ($chirps as $chirp)
                <x-large-chirp :chirp="$chirp"/>
            @endforeach

      </div>
</x-app-layout>
