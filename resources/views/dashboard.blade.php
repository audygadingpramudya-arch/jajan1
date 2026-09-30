<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Data Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('foods.create') }}" class="inline-block rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            + Tambah Makanan
        </a>

        @if (session('success'))
            <div class="mt-4 rounded border border-green-400 bg-green-100 p-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-4 overflow-x-auto rounded-lg bg-white shadow-sm">
            <table class="w-full min-w-[760px] border text-left">
                <thead>
                    <tr class="border-b bg-gray-100 text-sm text-gray-600">
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($foods as $food)
                        <tr class="border-b text-sm">
                            <td class="p-3">
                                @if ($food->image)
                                    <img src="{{ $food->image }}" alt="{{ $food->name }}" class="mx-auto h-16 w-16 rounded object-cover">
                                @else
                                    <span class="text-xs text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="p-3 font-semibold">{{ $food->name }}</td>
                            <td class="p-3">{{ $food->category }}</td>
                            <td class="p-3 font-bold text-green-600">Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <a href="{{ route('foods.show', $food) }}" class="mr-3 font-semibold text-gray-600 hover:underline">Lihat</a>
                                <a href="{{ route('foods.edit', $food) }}" class="mr-3 font-semibold text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('foods.destroy', $food) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus data ini?')" class="font-semibold text-red-600 hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data makanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-10 rounded-lg bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-xl font-bold text-gray-800">Pesanan Customer</h3>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] border text-left">
                    <thead>
                        <tr class="border-b bg-gray-100 text-sm text-gray-600">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Meja</th>
                            <th class="p-3">Pesanan</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b text-sm">
                                <td class="p-3 font-semibold text-gray-800">{{ $order->customer_name }}</td>
                                <td class="p-3">Meja {{ $order->table_number }}</td>
                                <td class="p-3">
                                    @foreach ($order->items as $item)
                                        <div>{{ $item->food?->name ?? 'Menu tidak ditemukan' }} x{{ $item->quantity }}</div>
                                    @endforeach
                                </td>
                                <td class="p-3 font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-700">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500">Belum ada pesanan customer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($foods->hasPages())
            <div class="mt-4">{{ $foods->links() }}</div>
        @endif
    </div>
</x-app-layout>
