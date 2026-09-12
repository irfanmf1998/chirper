<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->take(50)
            ->paginate(5);
            //->get();

            // [
            //     'author' => 'Jane Doe',
            //     'message' => 'Just deployed my first Laravel app! 🚀',
            //     'time' => '5 minutes ago'
            // ],
            // [
            //     'author' => 'John Smith',
            //     'message' => 'Laravel makes web development fun again!',
            //     'time' => '1 hour ago'
            // ],
            // [
            //     'author' => 'Alice Johnson',
            //     'message' => 'Working on something cool with Chirper...',
            //     'time' => '3 hours ago'
            // ]
            //];

        return view('home',['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255',
                
                //Rule::unique('chirps')->where(function ($query) use ($user) {
                //return $query->where('user_id', $user->id);
                //})

        ], [
             'message.required' => 'Please write something to chirp!',
             'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Use the authenticated user
        auth()->user()->chirps()->create($validated);

        // Create the chirp (no user for now - we'll add auth later)
        //  \App\Models\Chirp::create([
            //  'message' => $validated['message'],
            //  'user_id' => null, // We'll add authentication in lesson 11
        //  ]);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Your chirp has been posted!');
        //return redirect('/')->with('success', 'Chirp created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp) //string $id
    {
        // We'll add authorization in lesson 11
        // return view('chirps.edit', compact('chirp'));
        //$this->authorize('update', $chirp);
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp) //string $id
    {
        //$this->authorize('update', $chirp);

        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Update
        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp) //string $id
    {
        //$this->authorize('delete', $chirp);

        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $chirp->delete();

        return redirect('/')->with('success', 'Chirp deleted!');
    }

    /**
     * Fungsi pencarian
     */
    public function search(Request $request)
    {
        //Menangkap data pencarian
        $cari = $request->input('cari');

        //Mengambil data dari table chirps sesuai pencarian data
        $chirps = Chirp::where('message', 'like', "%".$cari."%")
            ->latest()
            ->paginate(5);
            //->get();

        //Mengirim data ke view index
        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Fungsi profil pengguna yang sedang login
     */
    public function my_page()
    {
        // Mengambil data pengguna yang sedang login
        $user = auth()->user();

        // Mengirim data pengguna ke view my_page
        return view('my_page', compact('user'));
    }

    /**
     * Fungsi profil pengguna lain
     */
    public function user_profile($id)
    {
        // Mengambil data pengguna berdasarkan ID
        $user = \App\Models\User::findOrFail($id);

        //Jika pengguna sedang login mengakses profilnya sendiri, arahkan ke halaman my_page
        if ($user == auth()->user()) {
            return view('my_page', compact('user'));
        }

        // Mengambil data chirp milik pengguna tersebut
        $chirps = $user->chirps()->latest()->paginate(5);

        // Mengirim data pengguna dan chirp ke view user_profile
        return view('user_profile', compact('user', 'chirps'));
    }

}