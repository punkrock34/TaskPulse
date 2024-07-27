<div class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
            Request a password reset
        </h1>

        <!-- Display Status Message -->
        @if (session('status'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 dark:text-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="space-y-4" action="{{ route('reset-password.request.send') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" value="{{ old('email') }}" required>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send password reset link</button>
        </form>

        <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
            Remembered your password? <a href="{{ route('login') }}" class="text-blue-700 hover:underline dark:text-blue-500">Log in</a>
        </div>
    </div>
</div>
