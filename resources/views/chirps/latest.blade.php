<x-app-layout>
    <x-chirps.chirp-box/>
    <div class="p-6" style="display:flex; flex-direction:column;margin-top:2rem;">
       @foreach ($chirps as $chirp)
            <x-chirps.chirp-card :chirp="$chirp"/>
       @endforeach
    </div>
 </x-app-layout>
