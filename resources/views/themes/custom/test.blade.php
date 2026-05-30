<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->groom_name ?? 'Groom' }} & {{ $invitation->bride_name ?? 'Bride' }}</title>
    <link rel="stylesheet" href="{{ asset('themes/custom/test/assets/css/style.css') }}">
</head>
<body>
    <div class="hero" style="background-image: url('assets/images/bg.jpg');">
        <h1>{{ $invitation->groom_name ?? 'Romeo' }} & {{ $invitation->bride_name ?? 'Juliet' }}</h1>
        <p>Are getting married!</p>
        
        <div class="guest-greeting">
            Dear {{ $guest->name ?? 'Guest' }},
            <br>
            We invite you to celebrate with us.
        </div>
    </div>
    <script src="{{ asset('themes/custom/test/assets/js/script.js') }}"></script>
</body>
</html>
