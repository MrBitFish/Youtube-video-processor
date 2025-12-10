<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-500 px-8 py-6">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                <h1 class="text-2xl font-bold text-white">Video Data</h1>
            </div>
        </div>

        <div class="px-8 py-8">
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-6 overflow-x-auto">
                <pre class="text-sm text-slate-700 font-mono leading-relaxed whitespace-pre-wrap">{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="mt-6">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center space-x-2 text-red-600 font-semibold hover:text-red-700 transition duration-200 group"
                >
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Back to Lookup</span>
                </a>
            </div>
        </div>

        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
            <p class="text-xs text-gray-500 text-center">
                Powered by YouTube Data API
            </p>
        </div>
    </div>
</div>

</body>
</html>
