<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="hero min-h-[calc(100vh-16rem)]">
        <div class="hero-content flex-col">
            <div class="card w-96 bg-base-100">
                <div class="card-body">
                    <p class="text-3xl mt-1 font-bold text-center mb-6 text-primary">Create Account</p> <!-- text-3xl -->

                    <form method="POST" action="/register">
                        @csrf

                        <!-- Name -->
                        <label class="floating-label mb-6">
                            <input type="text"
                                   name="name"
                                   placeholder="John Doe"
                                   value="{{ old('name') }}"
                                   class="input input-bordered @error('name') input-error @enderror"
                                   required>
                            <span>Name</span>
                        </label>
                        @error('name')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <!-- Email -->
                        <label class="floating-label mb-6"> <!-- Original Placeholder:"[mail@example.com](<mailto:mail@example.com>)" -->
                            <input type="email"
                                   name="email"
                                   placeholder="mail@example.com"p
                                   value="{{ old('email') }}"
                                   class="input input-bordered @error('email') input-error @enderror"
                                   required>
                            <span>Email</span>
                        </label>
                        @error('email')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <!-- Password -->
                        <label class="floating-label mb-6">
                            <input type="password"
                                   name="password"
                                   placeholder="••••••••"
                                   class="input input-bordered @error('password') input-error @enderror"
                                   id="myPassword1"
                                   required>
                            <span>Password</span>
                        </label>
                        @error('password')
                            <div class="label -mt-4 mb-2">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror

                        <!-- Password Confirmation -->
                        <label class="floating-label mb-6">
                            <input type="password"
                                   name="password_confirmation"
                                   placeholder="••••••••"
                                   class="input input-bordered"
                                   id="myPassword2"
                                   required>
                            <span>Confirm Password</span>
                        </label>

                        <!-- Show Password -->
                        <div class="form-control mt-4">
                            <label class="label cursor-pointer justify-start">
                                <input type="checkbox"
                                       onclick="showPass()" 
                                       class="checkbox">
                                <span class="label-text ml-2">Show Password</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-control mt-8">
                            <button type="submit" class="btn btn-primary w-full">
                                Register
                            </button>
                        </div>
                    </form>

                    <div class="divider">OR</div>
                    <p class="text-center text-sm">
                        Already have an account?
                        <a href="/login" class="link link-primary">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    function showPass() {
        var x1 = document.getElementById("myPassword1");
        var x2 = document.getElementById("myPassword2");
        if (x1.type === "password") {
            x1.type = "text";
        } else {
            x1.type = "password";
        }
        if (x2.type === "password") {
            x2.type = "text";
        } else {
            x2.type = "password";
        }
    }
</script>