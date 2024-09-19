<div style="display:flex;justify-content:end;margin-top:1rem;">

    @if(Auth::user()->isFollowing($user))

    <form action="{{ route("user.unfollow", $id)}}" method="POST">
        @csrf
        <input type="hidden" id="userToFollow" name="userToFollow" value="{{$name}}">
        <input type="hidden" id="userFollowing" name="userFollowing" value="{{Auth::user()->name}}">
        <button type="submit" style="color:white;background-color:rgb(197, 71, 71);border-radius:.25rem;padding:.25rem;margin-left:.1rem;margin-right:.1rem;">Unfollow</button>
    </form>

    @else

        <form action="{{ route("user.follow", $id)}}" method="POST">
            @csrf
            <input type="hidden" id="userToFollow" name="userToFollow" value="{{$name}}">
            <input type="hidden" id="userFollowing" name="userFollowing" value="{{Auth::user()->name}}">
            <button type="submit" style="color:white;background-color:rgb(113, 209, 113);border-radius:.25rem;padding:.25rem;margin-left:.1rem;margin-right:.1rem;">Follow</button>
        </form>

    @endif

</div>
