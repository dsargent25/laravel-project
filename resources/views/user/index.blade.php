<x-app-layout>
{{-- View for All Chirpers --}}
<div class="mt-6 shadow-sm rounded-lg" style="display:flex; justify-content:center;">

                <div class="p-6 flex space-x-2">
                    <div class="flex-1" >
                    @foreach ($users as $user)
                        <x-user-card :user="$user"/>
                    @endforeach
                    </div>
                </div>
        </div>
{{-- End of View for All Chirpers --}}
</x-app-layout>
