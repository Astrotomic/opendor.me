<form action="{{ route('auth.signout') }}" method="POST">
    @csrf

    <button {{ $attributes }} type="submit">
        {{ $slot }}
    </button>
</form>
