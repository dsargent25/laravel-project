    @if (request()->routeIs('chirps.index') || request()->routeIs('dashboard'))
    <details open>
    @else
    <details>
    @endif
    <summary class="chirpToggle">Click Here to Chirp Something!</summary>
    <div class="bg-white rounded-lg shadow-sm p-4 my-5 fixed right-0 bottom-9 w-[400px] z-10">
        <form method="POST" action="{{ route('chirps.store') }}" enctype="multipart/form-data">
            @csrf
            <textarea
                name="message"
                required
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                style="height:200px;"
            >{{ old('message') }}</textarea>
            <p class="pt-2">Upload Image (Optional):</p>
            <input id="chirp_image" name="chirp_image" type="file" class="block mt-1 w-full py-2">
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4" style="background-color:#26A7DE;">{{ __('Chirp') }}</x-primary-button>
        </form>
    </div>
</details>
