<div class="theme-transition flex flex-grow items-center justify-center min-h-full w-full bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
            Log in to your account
        </h1>
        <form class="space-y-4" action="#" method="POST">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
                    </div>
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <a href="{{ route('reset-password.request') }}" class="text-sm text-blue-700 hover:underline dark:text-blue-500">Forgot password?</a>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign in</button>
        </form>

        <div class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300">
            <p class="mx-4 mb-0 text-center font-semibold text-gray-900 dark:text-white">Or</p>
        </div>

        <button type="button" class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            <div class="flex items-center justify-center">
                <img class="h-5 w-5 mr-2" src="https://www.svgrepo.com/show/355037/google.svg" alt="Google logo">
                <span>Sign in with Google</span>
            </div>
        </button>

        <div class="mt-4 text-sm font-medium text-gray-500 dark:text-gray-300 text-center">
            Not registered? <a href="{{ route('register') }}" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
        </div>
    </div>
</div>
