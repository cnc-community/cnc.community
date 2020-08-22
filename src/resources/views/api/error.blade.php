<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="/assets/css/app.css" />
</head>
<body>
    <main>
    <?php if($message): ?>
    <div style="padding: 15px;">
    <p>
        {{ $message }}
    </p>
    </div>
    <?php endif; ?>
    </main>
</body>
</html>