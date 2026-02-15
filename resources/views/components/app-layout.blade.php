<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redis - {{ $title ?? 'vežba' }}</title>
</head>
<body>
    <header>
        Ovo je header 
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        &copy; Bojan {{ date('Y-m-d') }}
    </footer>
</body>
</html>