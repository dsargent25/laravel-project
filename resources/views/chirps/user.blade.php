<x-app-layout>
    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">


               {{-- <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                        <div class="flex justify-between items-center py-6">
                            <div>
                                <a href="/user/{{$user->name}}">
                                <img width='100' height="100"src="{{$user->profile_image_url}}">
                                </a>
                            </div>
                            <div>
                                <a href="/user/{{$user->name}}">{{$user->name}}</a>
                            </div>
                            <div>
                                <p>{{$user->created_at}}</p>
                            </div>
                            <div>
                                <p>{{$user->chirp_count}}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}


                @foreach ($chirps as $chirp)
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
    </x-app-layout>