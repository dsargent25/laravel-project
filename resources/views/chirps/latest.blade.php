<x-app-layout>
    <div class="p-6" style="display:flex; flex-direction:column;width:550px;margin-top:2rem;">
       @foreach ($chirps as $chirp)
            <x-chirp.small-chirp :chirp="$chirp"/>
       @endforeach
    </div>
 </x-app-layout>
