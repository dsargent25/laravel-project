<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4" style="background-color:#26A7DE;">{{ __('Chirp') }}</x-primary-button>
        </form>
    </div>

       <div class="mt-6 bg-white shadow-sm rounded-lg divide-y" style="background-color:aliceblue;">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">                    
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <a href="/user/{{ $chirp->user->name }}">
                                <img width="50" height="50" src=" {{$chirp->user->profile_image_url}}">
                                </a>
                                <a href="/user/{{ $chirp->user->name }}">
                                    <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                </a>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                            </div>
 				                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                            <p class="text-lg text-gray-900">" {{ $chirp->message }} "</p>
                        </div>
                    </div>

                    <h3 class="px-5 text-l text-gray-600 font-bold">Comments:</h3>

                    <div style=" padding: 10px 10px; height:150px; overflow-y:scroll;">

                    @foreach($chirp->comment as $comment)
                    <div class="px-5">
                        <p class="leading-3 ml-2 text-sm text-gray-600">{{ $comment->user->name }} chirps: {{ $comment->content }}</p>
                    </div>

                    @if ($comment->user->is(auth()->user()))
                    <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                        @csrf
                        @method('delete')
                        <button class=" text-red-600 text-xs px-6" :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">Delete Comment</button>
                    </form>
                    @endif
                    @endforeach
                    </div>
                    <div class="px-5">
                    <form action="{{ route("chirps.comments.store", $chirp->id)}}" method="POST"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @csrf
                        <textarea name="content" class="form-control"></textarea><br>
                        <x-primary-button type="submit" class="mt-1" style="background-color:#26A7DE;">{{ __('Comment') }}</x-primary-button>
                    </form>
                    </div>
                @endforeach
            </div>
</x-app-layout>