<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Sidang PPS BPN</title>
    <style>
        body { font-family: Arial, sans-serif; background: #1a2530; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 25px; border-radius: 8px; width: 320px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .field { margin-bottom: 15px; }
        .field label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        .field input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        .alert { padding: 10px; background: #f8d7da; color: #721c24; border-radius: 4px; font-size: 13px; margin-bottom: 15px; }
        .link { text-align: center; margin-top: 15px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 style="text-align: center; margin-top: 0;">PPS BPN</h2>
        
        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert">
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>