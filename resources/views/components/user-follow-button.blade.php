<div style="display:flex;justify-content:end;margin-top:1rem;">

    @if(Auth::user()->follows()->where('user_id', $user->id)->exists())

        <form action="{{ route("user.unfollow", $id)}}" method="POST">
            @csrf
            <input type="hidden" id="userToFollow" name="userToFollow" value="{{$name}}">
            <input type="hidden" id="userFollowing" name="userFollowing" value="{{Auth::user()->name}}">
            <button type="submit" class="follow-unfollow-button unfollow-button">Unfollow</button>
        </form>

    @elseif(Auth::user()->id == $user->id)

    @else

        <form action="{{ route("user.follow", $id)}}" method="POST">
            @csrf
            <input type="hidden" id="userToFollow" name="userToFollow" value="{{$name}}">
            <input type="hidden" id="userFollowing" name="userFollowing" value="{{Auth::user()->name}}">
            <button type="submit" class="follow-unfollow-button follow-button">Follow</button>
        </form>

    @endif

</div>
