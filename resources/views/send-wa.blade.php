<!-- resources/views/send-wa.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>TEST WA</title>
</head>
<body>
    <h1>cobak OTP mainan WhatsApp</h1>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/send-wa">
        @csrf
        
        <div>
            <label>Pesan</label>
            <textarea name="message" required>Hello World!</textarea>
        </div>
        
        <button type="submit">Kirim</button>
    </form>
</body>
</html>