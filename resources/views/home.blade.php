<!DOCTYPE html>
<html lang="en" data-theme="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Chirper - Home</title> -->
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-base-200 font-sans">

    <x-layout>
        <x-slot:title>
            Home Feed
        </x-slot:title>

        <div class="grid grid-cols-2 gap-4 w-full bg-base-300 rounded-box p-4">

            <!-- Welcome -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <div>
                        <p class="text-3xl font-bold text-primary">Welcome to Chirper!</p>
                        <p class="mt-4 text-base-content/60">This is your brand new Laravel application. Time to make it sing (or chirp)!</p>
                        <p class="mt-2 text-sm text-gray-600">Now this is live on the internet! 🎉</p>
                    </div>
                </div>
            </div>
            <!-- Welcome -->

            <!-- Chirp Form -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <form method="POST" action="/chirps">
                        @csrf
                        <div class="form-control w-full">
                            <!-- 
                                Textarea dibuat panjang ke pinggir 
                                agar tidak memunculkan "Blank Space" 
                                pada tampilan form chirp 
                            -->
                            <textarea name="message" placeholder="What's on your mind?" class="textarea w-full resize-none @error('message') textarea-error @enderror" rows="4" maxlength="255" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="mt-4 flex items-center justify-end">
                            <button type="submit" class="btn btn-primary">
                                Chirp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Chirp Form -->

        </div>

        <div class="divider py-4">
            <p class="text-3xl font-bold">Latest Chirps</p>     <!-- <h1 class="text-3xl font-bold mt-8">Latest Chirps</h1> -->
        </div>

        <div class="max-w-3xl mx-auto">

            <!-- Form pencarian chirp -->
            <div class="py-4">
                <form action="/search" method="GET" class="max-w-md mx-auto flex items-center">
                    <input type="text" style="width: 150%;" class="input input-primary" name="cari" placeholder="Find chirps by keyword ..." value="{{ old('cari') }}">
                    <input type="submit" class="btn btn-primary ml-4" value="Search">
                </form>
            </div>     
            <!-- Form pencarian chirp -->

            <!-- Menampilkan chirp -->
            <div class="space-y-4 mt-8">
                @forelse ($chirps as $chirp)
                    <x-chirp :chirp="$chirp"/>
                @empty
                    <div class="hero py-12">
                        <div class="hero-content text-center">
                            <div>
                                <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="mt-4 text-base-content/60">No chirps yet. Be the first to chirp!</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <!-- Menampilkan chirp -->

            <!-- Pagination -->
            <br>
            {{ $chirps->links() }}
            <!-- Pagination -->

        </div>
    </x-layout>

</body>

</html>