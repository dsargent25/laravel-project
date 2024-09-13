<x-app-layout>

    <div class="mx-auto p-4 sm:p-6 lg:p-8" >


        <div style="max-width: 460px; margin-top:20px;">


        <div class="bg-white rounded-lg shadow-sm" style="padding:1rem;">
            <form method="POST" action="{{ route('chirps.store') }}">
                @csrf
                <textarea
                    name="message"
                    required
                    placeholder="{{ __('What\'s on your mind?') }}"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    style="height:200px;"
                >{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <x-primary-button class="mt-4" style="background-color:#26A7DE;">{{ __('Chirp') }}</x-primary-button>
            </form>
        </div>

            @foreach ($chirps as $chirp)
                <x-chirp.large-chirp :chirp="$chirp"/>
            @endforeach


        </div>


      </div>
</x-app-layout>
