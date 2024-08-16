<nav class="navbar">
    <div class="navbar-container">
        {{-- Home Button --}}
        <a href="{{ route('overzicht') }}" class="btn btn-primary">Home</a>

        {{-- Profile Button --}}
        <a href="{{ route('profile.edit') }}" class="btn btn-success">Profile</a>

        {{-- Logout Form --}}
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Log Out</button>
        </form>
    </div>
</nav>
