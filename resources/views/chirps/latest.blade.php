<x-app-layout>
<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="/chirps/user/{{ $chirp->user->name }}">
                                <img width="50" height="50" src=" {{$chirp->user->profile_image_url}}">
                                </a>
                                <a href="/chirps/user/{{ $chirp->user->name }}">
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                </a>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>
</x-app-layout>