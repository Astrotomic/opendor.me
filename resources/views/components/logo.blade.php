<a href="{{ url('/') }}" class="flex items-center w-auto h-8 group" title="{{ config('app.name') }}">
    <svg class="w-8 h-8 text-brand-500 group-hover:text-brand-400" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><g class="fa-group"><path class="fa-secondary" fill="currentColor" d="M0 464v32a16 16 0 0 0 16 16h336v-64H16a16 16 0 0 0-16 16zm624-16h-80V113.45C544 86.19 522.47 64 496 64H384v64h96v384h144a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" opacity="0.4"></path><path class="fa-primary" fill="currentColor" d="M312.24 1l-192 49.74C106 54.44 96 67.7 96 82.92V448h256V33.18C352 11.6 332.44-4.23 312.24 1zM264 288c-13.25 0-24-14.33-24-32s10.75-32 24-32 24 14.33 24 32-10.75 32-24 32z"></path></g></svg>
    <span class="block ml-2 text-lg font-bold group-hover:text-brand-500 font-logo">
        {{ config('app.name') }}
    </span>
</a>
