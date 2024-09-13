<div>
    <p class="leading-3 text-sm text-gray-600">{{ $comment->user->name }} chirps: {{ $comment->content }}</p>
</div>
@if ($comment->user->is(auth()->user()))
    <form method="POST" action="{{ route('comments.destroy', $comment) }}">
    @csrf
    @method('delete')
    <button class=" text-red-600 text-xs px-6" :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">Delete Comment</button>
    </form>
@endif
