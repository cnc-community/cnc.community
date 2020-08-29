<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C&C Community</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/app.css?v=3.8" />
</head>
<body>

<main>
    <div class="page page-@yield('page-class')">
        <main role="main">
            @yield('content')
        </main>
    </div>
</body>
</html>