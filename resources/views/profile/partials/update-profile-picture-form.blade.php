<header>

    <h2 class="text-lg font-medium text-gray-900">
        {{ __('Upload/Replace Profile Picture') }}
    </h2>

    @empty(Auth::user()->images->first()->filename)
        <div class="rounded-lg" style="width:100px;height:100px;background-image:url('{{asset('storage/profile-images/default_profile.jpg')}}');background-position:center;background-size:cover;">
        </div>
        @else
        <div class="rounded-lg" style="width:100px;height:100px;background-image:url('{{asset('storage/'.Auth::user()->images->first()->filename)}}');background-position:center;background-size:cover;">
        </div>
    @endif

    <p class="mt-1 text-sm text-gray-600">
        {{ __('Ensure your profile image is in the correct format.') }}
    </p>

    <form method="POST" action="{{ route('user-image.store') }}" enctype="multipart/form-data">
        @csrf
        <input id="user_image" name="user_image" type="file" class="block mt-1 w-full" required>
        <x-input-error :messages="$errors->get('user_image')" class="mt-2" />

        <div class="mt-4">
            <x-primary-button style="background-color:rgb(38, 167, 222);">
                {{ __('Upload/Replace') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('user-image.destroy') }}">
        @csrf
        @method('delete')
        <div class="mt-4">
            <x-primary-button class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Delete') }}
            </x-primary-button>
            <x-input-error :messages="$errors->get('user_image_delete')" class="mt-2" />
        </div>

    </form>

    {{-- Where Delete Form Goes --}}

</header>
