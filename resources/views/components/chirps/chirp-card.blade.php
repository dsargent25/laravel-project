<div class="px-6 pt-6 pb-3 flex space-x-2 bg-white rounded-lg shadow-lg" style="width:400px;margin:auto; margin-bottom:1rem;">
    <div class="flex-1">
        <div class="flex" style="flex-direction: row;">
                <div style="width:100px;margin:10px;">

                    <div class="rounded-lg" style="width:60px;height:60px;background-image:url('{{$profileImageUrl}}');background-position:center;background-size:cover;">
                    </div>

                    <span class="text-gray-800">{{ $name }}</span>
                </div>
                <div style="align-items:left;width:200px;">
                    <p class="mt-4 text-m text-gray-600">" {{ $message }} "</p>
                    <small class="text-sm text-gray-500">{{ $chirpCreatedDate }}</small>
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


        <details>
            <summary class="mt-[10px] mx-[100px] bg-[#26A7DE] text-white rounded-md">Toggle Comments</summary>
        <div style="margin-top:10px;padding:5px;">
            <div class="comment-section" style=" padding: 10px 10px;max-height:125px; overflow-y:scroll;}" id="comment-list">

                  @forelse($chirp->comment as $comment)
                      <x-chirp.chirp-comment :comment="$comment" />
                  @empty
                    <p class="text-gray-600 text-sm">No Comments. Be the first?</p>
                  @endforelse


            </div>
            <div class="mt-4">
               <form action="{{ route("chirps.comments.store", $chirp->id)}}" method="POST"
               class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md" id='save-comment'>
               @csrf
               <div style="display:flex;gap:10px;height:40px;">
                    <input name="content" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-[12px] w-[225px]" type="text" required>
                    <x-primary-button type="submit" class="comment-update" style="background-color:#26A7DE;font-size:11px;">{{ __('Comment') }}</x-primary-button>
                </div>
               <x-input-error :messages="$errors->get('message')" class="mt-2" />
               </form>
            </div>
        </div>
    </details>
    </div>
</div>
