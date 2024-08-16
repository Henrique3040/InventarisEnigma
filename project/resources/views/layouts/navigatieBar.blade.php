<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <a href="{{ route('overzicht') }}">
            <img src="{{ asset('storage/LeKaailogo3.jpg') }}" alt="App Logo" class="navbar-logo">
        </a>

        <!-- Navigation Links -->
        <a href="{{ route('overzicht') }}" class="btn btn-primary">Home</a>
        <a href="{{ route('profile.edit') }}" class="btn btn-success">Profile</a>
        
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Log Out</button>
        </form>
    </div>
</nav>
