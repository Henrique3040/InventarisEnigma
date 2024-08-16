<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enigma Inventory</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container home-container">
        <h1>Welcome to Enigma Inventory</h1>
      
            <div class="links">
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                    
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            </div>
      
    </div>
</body>
</html>
