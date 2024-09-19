<div id="comment-{{$comment->id}}">
    <div>
        <p class="leading-5 text-sm text-gray-600">{{ $comment->user->name }} chirps: {{ $comment->content }}</p>
    </div>
    @if ($comment->user->is(auth()->user()))
        <form class="comment-delete-form">
            @csrf
            @method('delete')
            <input type="hidden" id="commentId" name="commentId" value="{{$comment->id}}">
            <button type="submit" class=" text-red-600 text-xs px-6">Delete Comment</button>
        </form>
    @endif
</div>
