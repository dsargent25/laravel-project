<x-app-layout>
{{-- View for Chirper User Profile --}}
    <div class="mt-6">
        <div class="p-6 flex space-x-2">
            <x-user-card :user="$user"/>
        </div>
            @foreach ($user->chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <img width="50" height="50" src=" {{$chirp->user->profile_image_url}}">
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>
            @endforeach
    </div>
{{-- End of View for Chirper User Profile --}}
</x-app-layout>
