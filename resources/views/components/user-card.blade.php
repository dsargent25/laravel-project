<div class="p-6 flex space-x-2 shadow-sm rounded-lg" style="background-color:white;margin:1rem;width:400px;">
    <div class="flex-1">
        <div class="flex py-6">
            <div>
                <a href="/user/{{ $user->name }}">
                    <img width='100' height="100"src="{{$user->profile_image_url}}">
                </a>
            </div>

            <div style="padding-left:1rem;width:300px;">
                <a href="/user/{{ $user->name }}">{{ $user->name }}</a>
                @if ($firstChirp == null)
                    <p>Just Hatched</p>
                @else
                    <p>First Chirped: {{ $firstChirp }}</p>
                    <p>Chirps: {{ $user->chirps_count }}</p>
                @endif
            </div>

        </div>
    </div>
</div>
