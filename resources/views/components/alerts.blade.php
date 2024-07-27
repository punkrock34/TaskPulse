<!-- resources/views/components/alerts.blade.php -->
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

@if ($errors->any())
    <div class="mb-4 text-sm text-red-600 dark:text-red-400">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
