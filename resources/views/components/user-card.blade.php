<div class="p-6 flex space-x-2 shadow-md rounded-lg" style="background-color:white;margin:1rem;width:400px;">
    <div class="flex-1" style="width:300px;outline:2px dashed #26A7DE;border-radius:.3rem;padding:2rem;">
        <div class="flex p-1">
            <div>
                <a href="/user/{{ $user->name }}">
                    <div class="rounded-lg" style="width:100px;height:100px;background-image:url('{{$user->profile_image_url}}');background-position:center;background-size:cover;"></div>
                </a>
            </div>

            <div style="padding-left:1rem;width:250px;">
                <a  class="text-xl" href="/user/{{ $user->name }}">{{ $user->name }}</a>
                <div class="pt-1">
                    @if ($firstChirpDate == null)
                        <p class="text-gray-600 text-sm">Just Hatched!</p>
                    @else
                        <p class="text-gray-600 text-sm">First Chirped: </br>{{ $firstChirpDate }}</p>

                        <p class="text-gray-600 text-sm">Chirps: {{ $user->chirps_count }}</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
