<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root{
            --card:#373941;       /* dark card background */
            --accent:#ffd166;     /* yellow accent */
            --input-bg:#f3f4f6;   /* light input bg */
        }
        body{ font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
        .card { background: var(--card); color: #fff; }
        .accent { color: var(--accent); }
        .accent-bg { background: var(--accent); }
        .input-icon { color: #fff; opacity: .9; }
        .field-bg { background: var(--input-bg); }
        .rounded-pill { border-radius: 12px; }
        .big-pill { border-radius: 9999px; padding: 16px 36px; }
        a.accent-link { color: var(--accent); text-decoration: underline; text-underline-offset: 3px; }
        
        /* Placeholder color */
        input::placeholder {
            color: #b1b1b1; /* make placeholder more visible */
        }
        
        /* Dark text for input */
        input {
            color: #333; /* Dark text for input */
        }

        /* Ensure text is dark even when input is active or has focus */
        input:focus, input:not(:focus):valid {
            color: #333; /* Dark text when focused or when valid */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-[460px] card rounded-2xl p-10 shadow-xl">
            <div class="text-center">
                <h2 class="text-5xl font-extrabold accent">Login</h2>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="space-y-6">
                    <div class="relative">
                        <label for="username" class="flex items-center text-sm font-semibold mb-2">
                            <i class="fa-solid fa-user input-icon mr-2"></i> Username
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-user input-icon absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input id="username" name="username" type="text" required 
                                placeholder="Masukkan username"
                                class="pl-12 block w-full px-4 py-3 field-bg rounded-pill focus:outline-none focus:ring-2 focus:ring-yellow-300"/>
                        </div>
                    </div>

                    <div class="relative">
                        <label for="password" class="flex items-center text-sm font-semibold mb-2">
                            <i class="fa-solid fa-lock input-icon mr-2"></i> Password
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-lock input-icon absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input id="password" name="password" type="password" required 
                                placeholder="Masukkan password"
                                class="pl-12 block w-full px-4 py-3 field-bg rounded-pill focus:outline-none focus:ring-2 focus:ring-yellow-300"/>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full big-pill accent-bg text-gray-800 font-extrabold shadow-md hover:opacity-95 transition">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
