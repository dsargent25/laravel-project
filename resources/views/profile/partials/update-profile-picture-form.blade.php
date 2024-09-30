<header>

    <h2 class="text-lg font-medium text-gray-900">
        {{ __('Upload/Replace Profile Picture') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
        {{ __('Ensure your profile image is in the correct format.') }}
    </p>

    <form method="POST" action="{{ route('user-image.store') }}" enctype="multipart/form-data">
        @csrf
        <input id="user_image" name="user_image" type="file" class="block mt-1 w-full">
        <x-input-error :messages="$errors->get('user_image')" class="mt-2" />

        <div class="mt-4">
            <x-primary-button style="background-color:rgb(38, 167, 222);">
                {{ __('Upload/Replace') }}
            </x-primary-button>
        </div>

    </form>

    //Where Delete Form Goes

</header>
