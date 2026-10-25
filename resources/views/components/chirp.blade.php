@props(['chirp'])

<div class="card bg-base-100"> <!-- shadow -->
    <div class="card-body">
        <div class="flex space-x-3">

            {{--            Profile Picture             --}}
            @if ($chirp->user)
                <a href="/user/{{ $chirp->user_id }}" class="flex-shrink-0">
                    <div class="avatar">
                        <div class="size-10 rounded-full">
                            <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                                alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                        </div>
                    </div>
                </a>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif
            {{--            Profile Picture             --}}

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <!-- <span class="text-sm font-semibold"> -->
                        <a href="/user/{{ $chirp->user_id }}" class="font-bold hover:underline">
                            {{ $chirp->user ? $chirp->user->name : 'Anonymous User' }}
                        </a>
                        <!-- </span> -->
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>

                    <!-- Replace the temporary @ php block and $canEdit check with: -->
                    <!-- @ can('update', $chirp) -->
                    @if (auth()->check() && auth()->id() === $chirp->user_id)
                        <div class="flex gap-1">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                    <!-- @ endcan -->
                </div>
                <p class="mt-1">{{ $chirp->message }}</p>

                {{--            Like/DisLike Button             --}}
                @if (auth()->check())           <!-- If Logged In -->
                    <div class="flex mt-2">
                        {{-- If Auth User_ID = Chirp->Like->User_ID && $chirp->id = Chirp->Like->Chirp_ID --}}
                        {{-- ( $chirp->id = $chirp->like->chirp_id && auth()->id() = $chirp->like->user_id ) --}}
                        <?php $userID = auth()->id(); ?>
                        @if (
                            // 1 === 1
                            // 1 === 0
                            DB::table('likes')->where('user_id',$userID)->where('chirp_id',$chirp->id)->exists()
                        )

                        <a href="/chirps/{{ $chirp->id }}/dislike">         <!-- DisLike -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                            </svg>
                        </a>
                        
                        @else

                        <a href="/chirps/{{ $chirp->id }}/like">            <!-- Like -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                        </a>     
                        
                        @endif
                        
                        &nbsp;
                        <b>         <!-- Jumlah Likes -->
                            {{ 
                                DB::table('likes')
                                    ->where('chirp_id',$chirp->id)
                                    ->count();
                            }}
                        </b>
                    </div>
                @else           <!-- If NOT Logged In -->
                    <div class="flex mt-2">
                        <div class="tooltip" data-tip="You must be logged in to give a Like.">
                            <a href="/login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#cccccc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                </svg>
                            </a>
                        </div>
                        &nbsp;
                        <b>         <!-- Jumlah Likes -->
                            {{ 
                                DB::table('likes')
                                    ->where('chirp_id',$chirp->id)
                                    ->count();
                            }}
                        </b>
                    </div>
                @endif
                {{--            Like/DisLike Button             --}}

            </div>
        </div>
    </div>
</div>