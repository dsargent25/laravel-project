<div class="p-6 flex space-x-2 shadow-md rounded-lg" style="background-color:white;margin:1rem;width:400px;">
    <div class="flex-1" style="width:300px;outline:2px dashed #26A7DE;border-radius:.3rem;padding:2rem;">

        <a href="/user/{{ $id }}">
        <div class="flex p-1">
            <div>

                    <div class="rounded-lg" style="width:100px;height:100px;background-image:url('{{$profileImageUrl}}');background-position:center;background-size:cover;">
                    </div>

            </div>
            <div style="padding-left:1rem;width:250px;">
                <p class="text-l">{{ $name }}</p>
                <div class="pt-1">
                    @if ($firstChirpDate == null)
                        <p class="text-gray-600 text-sm">Just Hatched!</p>
                    @else
                        <p class="text-gray-600 text-sm">First Chirped: </br>{{ $firstChirpDate }}</p>

                        <p class="text-gray-600 text-sm">Chirps: {{ $userChirpsCount }}</p>
                    @endif
                </div>
            </div>

        </div>
        </a>

        <x-user-follow-button :user="$user"/>

    </div>
</div>
