<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Followable;
use Illuminate\Http\Request;
use DB;

class ChirpController extends Controller
{
    /**
     *          Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')
            ->latest()
            ->paginate(5);
            //->get();
            
        return view('home',['chirps' => $chirps]);
    }



    /**
     *          Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    /**
     *          Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
             'message.required' => 'Please write something to chirp!',
             'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Use the authenticated user
        auth()->user()->chirps()->create($validated);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Your chirp has been posted!');
    }


    
    /**
     *          Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     *          Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp) //string $id
    {
        // We'll add authorization in lesson 11
        // return view('chirps.edit', compact('chirp'));
        // $this->authorize('update', $chirp);
        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('chirps.edit', compact('chirp'));
    }
    


    /**
     *          Update the specified resource in storage.
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

        // return redirect('/')->with('success', 'Chirp updated!');
        return redirect()->back()->back()->with('success', 'Chirp updated!');
        }



    /**
     *          Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp) //string $id
    {
        //$this->authorize('delete', $chirp);

        if ($chirp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $chirp->delete();

        // return redirect('/')->with('success', 'Chirp deleted!');
        return redirect()->back()->with('success', 'Chirp deleted!');
    }



    /**
     *          Fungsi pencarian
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
     *          Fungsi profil pengguna yang sedang login
     */
    public function myPage()
    {
        // Mengambil data pengguna yang sedang login
        $user = auth()->user();

        //Mengambil Chirps dari ID Pengguna Yang Di-Follow
        $followings = $user->getFollowingsIds();
        $chirps = Chirp::whereIn('user_id', $followings)
        ->latest()->get();
        // ->latest()->paginate(5);
        
        // Mengirim data pengguna ke view my-page
        return view('my-page', compact('user','chirps'));
    }



    /**
     *          Fungsi profil pengguna lain
     */
    public function userProfile($id)
    {
        // Mengambil data pengguna berdasarkan ID
        $user = \App\Models\User::findOrFail($id);

        //Jika pengguna sedang login mengakses profilnya sendiri, arahkan ke halaman my_page
        if ($user == auth()->user()) {
            //Mengambil Chirps dari ID Pengguna Yang Di-Follow
            $followings = $user->getFollowingsIds();

            $chirps = Chirp::whereIn('user_id', $followings)
            ->latest()->get();
            // ->latest()->paginate(5);

            return view('my-page', compact('user', 'chirps'));
        }

        // Mengambil data chirp milik pengguna tersebut
        $chirps = $user->chirps()->latest()->paginate(5);

        // Mengirim data pengguna dan chirp ke view user-profile
        return view('user-profile', compact('user', 'chirps'));
    }



    /**
     *          Fungsi untuk mengikuti pengguna lain
     */

    //      OVERTRUE VERSION
    public function followOvertrue($id)
    {
        $userToFollow = \App\Models\User::findOrFail($id);
        $currentUser = auth()->user();

        // Check if the current user is trying to follow themselves
        // if ($currentUser->id === $userToFollow->id) {
        //     return redirect()->back()->with('error', 'You cannot follow yourself.');
        // }

        // Check if the current user is already following the target user
        // if ($currentUser->isFollowing($userToFollow)) {
        //     return redirect()->back()->with('error', 'You are already following this user.');
        // }

        // Follow the user (OverTrue Version)
        $currentUser->follow($userToFollow);

        return redirect()->back()->with('success', 'You are now following ' . $userToFollow->name . '.');
    }

    //      MY VERSION
    public function follow($id)
    {
        // Menangkap Data
        $userID = auth()->id();
        $followableID = \App\Models\User::findOrFail($id);
        $time = date("Y-m-d H:i:s");
        
        // Follow the user (My Version)
        // auth()->user()->followables()->create($followableId);
        DB::table('followables')->insert([
            'user_id' => $userID,
            'followable_type' => "App\Models\User",
            'followable_id' => $followableID->id,
            'accepted_at' => $time,
            'created_at' => $time,
            'updated_at' => $time
        ]);
        
        // Notifikasi Follow
        return redirect()->back()->with('success', 'Now Following : ' . $followableID->name . '.');
        // return redirect()->back()->with('success', 'User Followed Successfully.');
    }



    /**
     *          Fungsi untuk berhenti mengikuti pengguna lain
     */

    //      OVERTRUE VERSION
    public function unfollowOvertrue($id)
    {
        $userToUnfollow = \App\Models\User::findOrFail($id);
        $currentUser = auth()->user();

        // Check if the current user is trying to unfollow themselves
        // if ($currentUser->id === $userToUnfollow->id) {
        //     return redirect()->back()->with('error', 'You cannot unfollow yourself.');
        // }

        // Check if the current user is not following the target user
        // if (!$currentUser->isFollowing($userToUnfollow)) {
        //     return redirect()->back()->with('error', 'You are not following this user.');
        // }

        // Unfollow the user (OverTrue Version)
        $currentUser->unfollow($userToUnfollow);

        return redirect()->back()->with('success', 'You have unfollowed ' . $userToUnfollow->name . '.');
    }

    //      MY VERSION
    public function unfollow($id)
    {
        $followableID = \App\Models\User::findOrFail($id);
        $userID = auth()->id();

        // Unfollow the user (My Version)
        // auth()->user()->followables()->delete($followableId);
        DB::table('followables')->where('user_id',$userID)->where('followable_id',$followableID->id)->delete();
        
        // Notifikasi Unfollow
        return redirect()->back()->with('success', 'Successfully Unfollowed ' . $followableID->name . '.');
        // return redirect()->back()->with('success', 'User Unfollowed Successfully.');
    }

    /**
     *          Fungsi Untuk Memberikan "Like" Pada Suatu Chirp
     */
    public function like($id)
    {
        // Menangkap Data
        $userID = auth()->id();         // ID Pengguna
        $chirpID = \App\Models\Chirp::findOrFail($id);           // Data Chirp Berdasarkan ID
        $time = date("Y-m-d H:i:s");            // Waktu

        // Insert Data
        DB::table('likes')->insert([
            'user_id' => $userID,
            'chirp_id' => $chirpID->id,
            'created_at' => $time,
            'updated_at' => $time
        ]);

        // Notifikasi Like
        return redirect()->back()->with('info', 'Berhasil Memberi Like');
    }

    /**
     *          Fungsi Untuk Membatalkan "Like" Pada Suatu Chirp (Baca : "DisLike")
     */
    public function dislike($id)
    {
        // Menangkap Data
        $userID = auth()->id();         // ID Pengguna
        $chirpID = \App\Models\Chirp::findOrFail($id);           // Data Chirp Berdasarkan ID

        // Delete Data
        DB::table('likes')
            ->where('user_id',$userID)
            ->where('chirp_id',$chirpID->id)
            ->delete();

        // Notifikasi DisLike
        return redirect()->back()->with('error', 'Berhasil Membatalkan Like');
    }
    
    //  ... more code
}