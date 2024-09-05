<div class="p-6 flex space-x-2 shadow-sm rounded-lg" style="background-color:white;margin:1rem;width:400px;">
    <div class="flex-1">
        <div class="flex justify-between py-6">
            <div>
                <a href="/user/{{ $user->name }}">
                    <img width='100' height="100"src="{{$user->profile_image_url}}">
                </a>
            </div>
            <div class="ml-4">
                <a href="/user/{{ $user->name }}">{{ $user->name }}</a>
                <p>User Created: {{ $birthday }}</p>
                <p>Total Chirps: {{ $user->chirps_count }}</p>
            </div>
        </div>
    </div>
</div>
