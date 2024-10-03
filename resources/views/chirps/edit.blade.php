<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.update', $chirp) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <p class="pb-2">Current Image:</p>

            @empty($chirp->images->first()->filename)
            @else
            <img src="{{asset('storage/'.$chirp->images->first()->filename)}}" style="max-width:300px;">
            @endif

            <p class="pt-2">Upload/Replace Image:</p>
            <input id="chirp_image" name="chirp_image" type="file" class="block mt-1 w-full py-2">

            <textarea
                name="message"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $chirp->message) }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('chirps.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
