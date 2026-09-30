<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Makanan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 24px; }
        .container { max-width: 1100px; margin: 0 auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .btn-danger { background: #dc2626; color: white; }
        .alert { background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; }
        th, td { border: 1px solid #e5e7eb; padding: 12px 14px; text-align: left; }
        th { background: #f3f4f6; }
        .actions { display: flex; gap: 8px; }
        .image-box { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; background: #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <h1>Daftar Makanan</h1>
            <a href="{{ route('foods.create') }}" class="btn btn-primary">+ Tambah Makanan</a>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($foods as $food)
                    <tr>
                        <td>{{ $food->name }}</td>
                        <td>Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                        <td>{{ $food->category }}</td>
                        <td>{{ $food->description }}</td>
                        <td>
                            @if ($food->image)
                                <img src="{{ $food->image }}" alt="{{ $food->name }}" class="image-box">
                            @else
                                <span>Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('foods.show', $food->id) }}" class="btn btn-secondary">Lihat</a>
                                <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data makanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
