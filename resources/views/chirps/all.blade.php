<x-app-layout>

<div class="mt-6 bg-white shadow-sm rounded-lg divide-y">



                <div class="p-6 flex space-x-2">
                    <div class="flex-1">

                        <div class="flex justify-between items-center">
                            <div>
                                <h2>Profile Image</h2>
                            </div>
                            <div>
                                <h2>Name</h2>
                            </div>
                            <div>
                                <h2>Account Creation Date</h2>
                            </div>
                            <div>
                                Total Post Count
                            </div>
                        </div>

                    </div>
                </div>


                <div class="p-6 flex space-x-2">
                    <div class="flex-1">
                    @foreach ($users as $user)
                        <div class="flex justify-between items-center py-6">
                            <div>
                                <a href="/user/{{$user->name}}">
                                <img width='100' height="100"src="{{$user->profile_image_url}}">
                                </a>
                            </div>
                            <div>
                                <a href="/user/{{$user->name}}">{{$user->name}}</a>
                            </div>
                            <div>
                                <p>{{$user->created_at}}</p>
                            </div>
                            <div>
                                <p>{{$user->chirp_count}}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
        </div>
</x-app-layout>