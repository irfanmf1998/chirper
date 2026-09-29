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
            My Profile Page
        </x-slot:title>

        <div>
            <p class="text-2xl font-bold">My Profile Page</p>

            <br>

            <!-- 
                Bagian ini menampilkan informasi pengguna, 
                termasuk avatar, nama, email, dan tanggal bergabung. 
            -->

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

            <div class="tabs tabs-lift gap-x-64 justify-center w-full bg-base-300 rounded-box p-4">

                <!-- Bagian ini menampilkan daftar chirp yang dimiliki oleh pengguna. -->
                <input type="radio" name="my_tabs_3" class="tab font-bold text-xl" aria-label="My Posted Chirps" checked="checked"/>
                <div class="tab-content bg-base-100 border-base-300 p-6">
                    <div class="divider">
                        <p class="text-2xl font-bold">My Posted Chirps</p>
                    </div>
                    <br>
                    <div class="max-w-3xl mx-auto">
                        @if ($user->chirps->isEmpty())
                            <div class="hero py-12">
                                <div class="hero-content text-center">
                                    <div>
                                        <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <p class="mt-4 text-base-content/60">You haven't posted any chirps yet.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <ul class="pl-5 space-y-2">
                                @foreach ($user->chirps->sortByDesc('created_at') as $chirp)
                                    <x-chirp :chirp="$chirp" />
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <!-- Bagian ini menampilkan daftar chirp yang dimiliki oleh pengguna. -->

                <!-- Bagian ini menampilkan daftar chirp dari pengguna yang diikuti oleh pengguna saat ini. -->
                <input type="radio" name="my_tabs_3" class="tab font-bold text-xl" aria-label="Followed Chirps"/>
                <div class="tab-content bg-base-100 border-base-300 p-6">
                    <div class="divider">
                        <p class="text-2xl font-bold">Chirps from followed users</p>
                    </div>
                    <br>
                    <div class="max-w-3xl mx-auto">
                        @if ($user->followings->isEmpty())
                            <div class="hero py-12">
                                <div class="hero-content text-center">
                                    <div>
                                        <center>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#aaaaaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                            </svg>
                                        </center>
                                        <p class="mt-4 text-base-content/60">No chirps from followed users yet or you haven't followed any users.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                        <ul class="pl-5 space-y-2">
                            @foreach ($chirps as $chirp)
                                <x-chirp :chirp="$chirp" />
                            @endforeach
                            {{-- {{ $chirps->links() }} --}}
                        </ul>
                        @endif
                    </div>
                </div>
                <!-- Bagian ini menampilkan daftar chirp dari pengguna yang diikuti oleh pengguna saat ini. -->

                <!-- Bagian ini menampilkan daftar pengguna yang diikuti oleh pengguna saat ini. -->
                <input type="radio" name="my_tabs_3" class="tab font-bold text-xl" aria-label="Followed Users"/>
                <div class="tab-content bg-base-100 border-base-300 p-6">
                    <div class="divider">
                        <p class="text-2xl font-bold">Users that you are following</p>
                    </div>
                    <br>
                    <div class="max-w-3xl mx-auto">
                        @if ($user->followings->isEmpty())
                            <div class="hero py-12">
                                <div class="hero-content text-center">
                                    <div>
                                        <center>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#aaaaaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                        </center>
                                        <p class="mt-4 text-base-content/60">You haven't followed any users yet.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <ul class="pl-5 space-y-2">
                                @foreach($user->followings()->with('followable')->get()->sortByDesc('created_at') as $following)
                                    <li>
                                        <a href="/user/{{ $following->followable_id }}" class="btn btn-ghost p-6">
                                            <div class="avatar">
                                                <div class="size-10 rounded-full">
                                                    <img src="https://avatars.laravel.cloud/{{ urlencode($following->followable->email) }}"
                                                        alt="{{ $following->followable->name }}'s avatar" class="rounded-full" />
                                                </div>
                                            </div>
                                            {{$following->followable->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <!-- Bagian ini menampilkan daftar pengguna yang diikuti oleh pengguna saat ini. -->
                
            </div>
        </div>

    </x-layout>

</body>

</html>