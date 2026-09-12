<!DOCTYPE html>
<html lang="en" data-theme="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-base-200 font-sans">

    <x-layout>
        <x-slot:title>
            Profile Page
        </x-slot:title>

        <div>
            <p class="text-2xl font-bold">Profile Page</p>

            <br>

            <!-- Bagian ini menampilkan informasi pengguna, 
            termasuk avatar, nama, email, dan tanggal bergabung. -->

            <div class="flex w-full">
                <div class="avatar mr-4">                 
                    <img src="https://avatars.laravel.cloud/{{ urlencode($user->email) }}" alt="{{ $user->name }}'s avatar" class="rounded-full" />
                </div>
                <div class="card card-body bg-base-300 rounded-box grid h-35 grow">
                    <p class="text-2xl font-bold text-primary">{{ $user->name }}</p>
                    <p>Email : <b>{{ $user->email }}</b></p>
                    <p>Joined : <b>{{ $user->created_at->format('d M Y') }}</b></p>
                </div>
            </div>

            <br>

            <!-- Bagian ini menampilkan daftar chirp yang dimiliki oleh pengguna. -->
            <!-- Jika pengguna tidak memiliki chirp, akan ditampilkan pesan "No chirps available." -->
            <!-- Jika ada chirp, akan ditampilkan dalam bentuk daftar dengan format tanggal dan waktu pembuatan chirp. -->
            
            <div class="divider">
                <p class="text-2xl font-bold">Posted Chirps</p>
            </div>

            <br>
            
            <div class="max-w-3xl mx-auto">
                @if ($user->chirps->isEmpty())
                    <p>No chirps available.</p>
                @else
                    <ul class="pl-5 space-y-2">
                        @foreach ($user->chirps->sortByDesc('created_at') as $chirp)
                            <x-chirp :chirp="$chirp" />
                        @endforeach
                    </ul>
                @endif
            </div>    

        </div>

    </x-layout>

</body>

</html>