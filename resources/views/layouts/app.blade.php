<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.comment-form').on('submit', function(event) {
                    event.preventDefault();

                    var chirpId = $(this).find("#chirpId").val();
                    var thisUser = $(this).find("#thisUser").val();
                    var urlString = `/chirps/${chirpId}/comments`;

                    $.ajax({
                        url: urlString,
                        method: 'POST',
                        dataType: 'json',
                        data: $(this).serialize(),
                        success: function(data) {
                            $.each(data, function(key,value){
                                var html = '<p class="leading-5 text-sm text-gray-600">' + thisUser + ' chirps: ' + value.content + '</p>'
                                var commentsList = `#comments-list-${chirpId}`
                                $(commentsList).append(html);
                            });

                            $('.comment-form')[0].reset();
                        },
                        error: function() {
                            alert('An error occurred. Please try again later.');
                        }
                    });
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased" style="background-color:aliceblue;min-width:485px;">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex self-center justify-center bg-[aliceblue] mt-[50px]">
                <div class="max-w-[460px]">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
