<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Lelang</title>
</head>
<body>
    <h1>Status Lelang</h1>

    <!-- Cek apakah ada data yang diterima -->
    @if($auctions->isEmpty())
        <p>Tidak ada lelang yang ditemukan.</p>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Kode Lelang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop melalui semua data auction dan tampilkan -->
                @foreach ($auctions as $auction)
                    <tr>
                        <td>{{ $auction->auction_code }}</td>
                        <td>{{ $auction->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
