<a
    href="{{ url('/') }}"
    rel="home"
    class="flex items-center p-4 space-x-3 group"
    target="_blank"
>
    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 text-white transition-colors duration-200 rounded bg-primary-600 group-hover:bg-primary-700">
        <svg class="w-6 h-6 text-white" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M0 464v32a16 16 0 0 0 16 16h336v-64H16a16 16 0 0 0-16 16zm624-16h-80V113.45C544 86.19 522.47 64 496 64H384v64h96v384h144a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M312.24 1l-192 49.74C106 54.44 96 67.7 96 82.92V448h256V33.18C352 11.6 332.44-4.23 312.24 1zM264 288c-13.25 0-24-14.33-24-32s10.75-32 24-32 24 14.33 24 32-10.75 32-24 32z"></path></g></svg>
    </div>

    <span class="text-lg font-bold leading-tight text-white transition-colors duration-200 group-hover:text-gray-100">
        {{ config('app.name') }}
    </span>
</a>
