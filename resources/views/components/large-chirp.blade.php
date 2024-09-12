@props(['chirp'])

<div class="mt-6 bg-white shadow rounded-lg" style="padding:1rem;display:flex;flex-direction:column;">
    <div style="padding:1em;height:100px;">
       <div style="display:flex;">
          <div>
             <a href="/user/{{ $chirp->user->name }}">
             <img width="75" height="75" src=" {{$chirp->user->profile_image_url}}">
             </a>
          </div>
          <div style="margin-left:1rem;">
             <a href="/user/{{ $chirp->user->name }}">
                <span class="text-gray-800" >
                   <p style="font-size:1.25rem">{{ $chirp->user->name }}</p>
                </span >
             </a>
          </div>
          <div>

          </div>
       </div>
    </div>
    <div style="display:flex;flex-direction:row;">
       <div class="p-6 flex space-x-2" style="width:300px">
          <div class="flex-1 flex-row" style="position:relative;">
             <div class="flex-initial">
                <p class="text-m text-gray-900">" {{ $chirp->message }} "</p>
             </div>
             <div style="padding-top:10px">
                <small class="text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                @unless ($chirp->created_at->eq($chirp->updated_at))
                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                @endunless
                <div>
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
                </div>
             </div>
          </div>
       </div>


       <div style="margin-left:auto;width:300px;">


          <h3 class="text-l text-gray-600 font-bold">Comments:</h3>
          <div class="comment-section" style=" padding: 10px 10px; height:125px; overflow-y:scroll;}" id="comment-list">

                @foreach($chirp->comment as $comment)
                    <x-chirp-comments :comment="$comment" />
                @endforeach

          </div>
          <div class="px-5 mt-4">
             <form action="{{ route("chirps.comments.store", $chirp->id)}}" method="POST"
             class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md" id='save-comment'>
             @csrf
             <textarea name="content" class="form-control block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" style="margin-top:10px;width:95%;" required></textarea>
             <x-input-error :messages="$errors->get('message')" class="mt-2" />
             <br>
             <x-primary-button type="submit" class="mt-1 comment-update" style="background-color:#26A7DE;">{{ __('Comment') }}</x-primary-button>
             </form>
          </div>
       </div>
    </div>
 </div>
