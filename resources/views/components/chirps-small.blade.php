<div class="p-6 flex space-x-2 bg-white rounded-lg shadow-lg" style="width:400px;margin:auto; margin-bottom:1rem;">
    <div class="flex-1">
        <div class="flex" style="flex-direction: row;">
                <div style="width:100px;margin:10px;">
                    <img width="50" height="50" src=" {{$chirp->user->profile_image_url}}">
                    <span class="text-gray-800">{{ $chirp->user->name }}</span>
                </div>
                <div style="align-items:left;width:200px;">
                    <p class="mt-4 text-m text-gray-600 ml-2">" {{ $chirp->message }} "</p>
                    <small class="ml-2 text-sm text-gray-500">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                 </div>
        </div>
    </div>
</div>
