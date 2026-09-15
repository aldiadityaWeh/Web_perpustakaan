<x-admin-layout>
    <x-slot:title>
        Validasi Pengembalian - Sistem Perpustakaan
    </x-slot:title>

    <div class="max-w-3xl mx-auto w-full pt-6 pb-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

            <!-- Header Info Buku -->
            <div class="bg-[#f8f9fa] rounded-xl p-5 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $peminjaman->buku->judul }}</h2>
                <p class="text-sm text-gray-500 mb-0.5">Dipinjam oleh: <span class="text-gray-700">{{ $peminjaman->anggota->nama_lengkap }}</span></p>
                <p class="text-sm text-gray-500">Tanggal Pinjam: <span class="text-gray-700">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</span></p>
            </div>

            <!-- FORM ACTION MENGARAH KE PROSES VALIDASI -->
            <form action="{{ route('peminjaman.prosesValidasi', $peminjaman->id) }}" method="POST">
                @csrf

                <!-- Dropdown Kondisi Buku -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-2">Kondisi Buku <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="kondisi_buku" name="kondisi_buku" class="w-full appearance-none border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-200 focus:border-purple-600 outline-none transition text-gray-700 bg-white" required>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak / Sobek</option>
                            <option value="Hilang">Hilang</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                            <i class="ph ph-caret-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Input Denda (Otomatis dari JS) -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-2">Denda (Rp)</label>
                    <input type="number" id="denda" name="denda" value="{{ $dendaTerlambat }}" readonly
                        class="w-full border border-gray-300 bg-gray-50 rounded-lg px-4 py-3 outline-none text-gray-700">
                    <p id="info-denda" class="text-xs mt-2 text-gray-500">
                        @if($dendaTerlambat > 0)
                            <span class="text-red-500 font-medium">Terdapat denda keterlambatan Rp {{ number_format($dendaTerlambat, 0, ',', '.') }}</span>
                        @else
                            Tidak ada denda keterlambatan.
                        @endif
                    </p>
                </div>

                <!-- Textarea Catatan -->
                <div class="mb-8">
                    <label class="block text-sm text-gray-600 mb-2">Catatan</label>
                    <textarea name="catatan" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-purple-200 focus:border-purple-600 outline-none transition text-gray-700 resize-none" placeholder="Opsional..."></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('peminjaman.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#9333ea] hover:bg-purple-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                        Simpan Pengembalian
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Script Kalkulasi Denda -->
    <script>
        const dendaTerlambatBase = {{ $dendaTerlambat }};
        const dendaRusak = 20000; // Tarif jika buku rusak (Bisa diedit)
        const dendaHilang = 50000; // Tarif jika buku hilang (Bisa diedit)

        const selectKondisi = document.getElementById('kondisi_buku');
        const inputDenda = document.getElementById('denda');
        const infoDenda = document.getElementById('info-denda');

        selectKondisi.addEventListener('change', function() {
            let total = dendaTerlambatBase;
            let info = "";

            if (dendaTerlambatBase > 0) {
                info += `Telat: Rp ${dendaTerlambatBase.toLocaleString('id-ID')}. `;
            }

            if (this.value === 'Rusak') {
                total += dendaRusak;
                info += `Denda Rusak: Rp ${dendaRusak.toLocaleString('id-ID')}.`;
            } else if (this.value === 'Hilang') {
                total += dendaHilang;
                info += `Denda Hilang: Rp ${dendaHilang.toLocaleString('id-ID')}.`;
            }

            inputDenda.value = total;

            if(total === 0) {
                infoDenda.innerHTML = `<span class="text-gray-500">Kondisi aman, tidak ada denda.</span>`;
            } else {
                infoDenda.innerHTML = `<span class="text-red-500 font-medium">Rincian: ${info}</span>`;
            }
        });
    </script>
</x-admin-layout>
