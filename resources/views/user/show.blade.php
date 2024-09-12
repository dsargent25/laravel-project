<x-app-layout>
{{-- View for Chirper User Profile --}}
    <div class="mt-6">
        <div class="p-6 flex space-x-2">
            <x-user-card :user="$user"/>
        </div>

            @foreach ($user->chirps as $chirp)
                <x-small-chirp :chirp="$chirp"/>
            @endforeach
    </div>
{{-- End of View for Chirper User Profile --}}
</x-app-layout>
