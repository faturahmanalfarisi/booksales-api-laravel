<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Author</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; max-width: 800px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Daftar Author</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Negara</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $a)
                <tr>
                    <td>{{ $a['id'] }}</td>
                    <td>{{ $a['name'] }}</td>
                    <td>{{ $a['country'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
