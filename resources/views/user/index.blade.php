<x-app-layout>

{{-- View Added for All Chirpers --}}
<div class="mt-6 bg-white shadow-sm rounded-lg" style="background-color:aliceblue; width:50%;display:flex; justify-content:center;">

                <div class="p-6 flex space-x-2">
                    <div class="flex-1" >
                    @foreach ($users as $user)
                        <x-user-card :user="$user"/>
                    @endforeach
                    </div>
                </div>
        </div>
{{-- End of View Added for All Chirpers --}}
</x-app-layout>