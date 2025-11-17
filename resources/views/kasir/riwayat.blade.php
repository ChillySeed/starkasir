<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background-color: #2f3136;">
    <nav class="bg-purple-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-2xl"></i>
                    <span class="text-xl font-bold">POS System - Kasir</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('kasir.pos') }}" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke POS
                    </a>
                    <span>Halo, {{ auth()->user()->nama }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Riwayat Transaksi</h2>
            </div>
            <div class="p-6">
                @if($transaksis->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($transaksis as $transaksi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->metode_pembayaran }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</div>
                                    @if($transaksi->pelanggan)
                                    <div class="text-xs text-gray-500">{{ $transaksi->pelanggan->golongan->nama_tier ?? '' }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                    Rp {{ number_format($transaksi->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('kasir.show-transaksi', $transaksi) }}" 
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $transaksis->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Belum ada transaksi</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
