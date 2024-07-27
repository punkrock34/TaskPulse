<div class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
            Sign up for an account
        </h1>

        <!-- Include the alerts component -->
        @include('components.alerts')

        <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                <input type="text" name="name" id="name" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('name') has-error @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('email') has-error @enderror" placeholder="name@company.com" value="{{ old('email') }}" required>
            </div>
            <div class="relative">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('password') has-error @enderror" required>

                <!-- eye icon -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 -bottom-7">
                    <button type="button" id="togglePassword" class="text-gray-400 focus:outline-none dark:text-gray-500">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="relative">
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('password') has-error @enderror @error('password_confirmation') has-error @enderror" required>

                <!-- eye icon -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 -bottom-7">
                    <button type="button" id="togglePasswordConfirmation" class="text-gray-400 focus:outline-none dark:text-gray-500">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <!-- password strength indicator -->
            <div class="flex items-center justify-between">
                <div class="flex items" id="password-strength-indicator">
                    <div class="w-2 h-2 bg-red-500 rounded-full mr-1 opacity-100"></div>
                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1 opacity-30"></div>
                    <div class="w-2 h-2 bg-green-500 rounded-full opacity-30"></div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items">
                        <input id="terms" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required>
                    </div>
                    <label for="terms" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree to the <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">terms and conditions</a></label>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
        </form>

        <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300">
            <p class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white">Or</p>
        </div>

        <button type="button" class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            <div class="flex items-center justify-center">
                <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/355037/google.svg" alt="Google logo">
                <span>Sign up with Google</span>
            </div>
        </button>

        <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-700 hover:underline dark:text-blue-500">Log in</a>
        </div>
    </div>
</div>
