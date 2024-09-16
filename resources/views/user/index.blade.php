<x-app-layout>
    <x-chirps.chirp-box/>
    <div class="mt-6" style="display:flex; position:relative;">
        <div class="p-6 flex" style="max-width:1000px;flex-direction:column;flex-wrap:wrap;margin-left:auto;margin-right:auto;justify-content:center;">
            @foreach ($users as $user)
                <x-user-card :user="$user"/>
            @endforeach
        </div>
    </div>
</x-app-layout>
