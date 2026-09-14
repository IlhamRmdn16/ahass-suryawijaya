<div class="max-w-3xl mx-auto" x-data="signaturePad()">
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-800">Formulir Persetujuan Pemrosesan Data Pribadi</h1>
        <p class="text-sm text-slate-500">Perintah Kerja Bengkel (PKB) &mdash; {{ $antrean->no_polisi }}</p>
    </div>

    @if (session('message'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-8 text-sm leading-relaxed text-slate-700">

        <div class="grid grid-cols-2 gap-4 mb-6 pb-4 border-b border-slate-200">
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wide">Nama</p>
                <p class="font-semibold text-slate-800">{{ $antrean->nama_konsumen }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wide">No. PKB/WO</p>
                <p class="font-semibold text-slate-800">{{ $pkb?->no_pkb ?? '- Belum diisi admin -' }}</p>
            </div>
        </div>

        <p class="mb-4">
            Untuk memenuhi ketentuan Pelindungan Data Pribadi sesuai dengan peraturan yang berlaku, serta dengan
            adanya pembelian produk dan/atau penggunaan layanan maka dengan ini saya telah membaca dan memahami
            kebijakan privasi dari CV Surya Wijaya ("AHASS") dan memberikan persetujuan kepada AHASS, dan
            PT Daya Adicipta Motora ("Distributor") untuk :
        </p>

        {{-- Checkbox 1 --}}
        <div class="flex gap-3 mb-4 p-3 rounded-lg {{ $pkb ? 'bg-slate-50' : 'bg-amber-50 border border-amber-200' }}">
            @if (! $pkb)
                <input type="checkbox" wire:model="setuju_1" class="mt-1 shrink-0 rounded border-slate-300 text-slate-800 focus:ring-slate-800">
            @else
                <span class="mt-0.5 shrink-0 text-emerald-600">✓</span>
            @endif
            <p>
                <strong>1.</strong> Memperoleh, mengumpulkan, menyimpan, mengolah, memproses, menganalisa,
                mentransfer dan memusnahkan data pribadi yang diperlukan dari konsumen untuk kegiatan:
                a. Proses reminder perawatan berkala kendaraan, perbaikan kendaraan, garansi kendaraan (pabrikan),
                pemesanan suku cadang, serta berkomunikasi dengan konsumen melalui berbagai media komunikasi dan
                melakukan kajian umpan balik untuk memahami preferensi dari konsumen;
                b. Menerapkan sistem, prosedur dan perangkat teknis serta mengambil tindakan lain yang diperlukan
                untuk melindungi data pribadi yang dikumpulkan dan dikelola termasuk dengan cara bekerjasama dengan
                pihak penyedia layanan teknologi dan informasi dan/atau pihak lainnya yang ditunjuk oleh AHASS
                dan/atau Distributor dan/atau Manufaktur.
            </p>
        </div>
        @error('setuju_1') <p class="text-red-500 text-xs mb-3">{{ $message }}</p> @enderror

        {{-- Checkbox 2 --}}
        <div class="flex gap-3 mb-4 p-3 rounded-lg {{ $pkb ? 'bg-slate-50' : 'bg-amber-50 border border-amber-200' }}">
            @if (! $pkb)
                <input type="checkbox" wire:model="setuju_2" class="mt-1 shrink-0 rounded border-slate-300 text-slate-800 focus:ring-slate-800">
            @else
                <span class="mt-0.5 shrink-0 text-emerald-600">✓</span>
            @endif
            <p>
                <strong>2.</strong> Memperoleh, mengumpulkan, menyimpan, mengolah, memproses, menganalisa,
                mentransfer dan memusnahkan data pribadi untuk kegiatan promosi dan/atau informasi yang berkaitan
                dengan produk dan jasa kendaraan.
            </p>
        </div>
        @error('setuju_2') <p class="text-red-500 text-xs mb-3">{{ $message }}</p> @enderror

        <p class="mb-4">
            Apabila terdapat data pribadi selain milik Saya sendiri yang diserahkan kepada AHASS, maka Saya telah
            mendapatkan persetujuan dan/atau izin dari subjek data pribadi untuk melakukan pencantuman tersebut.
        </p>

        <p class="mb-4">
            Perbaikan data pribadi, pengakhiran pemrosesan, penarikan persetujuan, pengajuan keberatan, pembatasan
            atau penundaan pemrosesan data diri secara proporsional, penghapusan, serta pelaksanaan hak lain sesuai
            dengan Undang-Undang nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi, dapat diajukan oleh Pemilik /
            Pembawa melalui permohonan secara tertulis kepada AHASS melalui alamat email:
            <strong>customercare@astrahonda.com</strong>
        </p>

        <p class="mb-4">
            Formulir ini merupakan satu kesatuan dan tidak terpisahkan dengan lembar PKB/WO yang dikeluarkan secara
            resmi oleh PT Daya Adicipta Motora.
        </p>

        <p class="mb-6">
            Demikian Surat Pernyataan ini saya tandatangani dan beri tanda centang (✓) sesuai dengan kehendak saya
            pribadi tanpa ada paksaan dari pihak manapun.
        </p>

        <p class="mb-4 text-right">
            Garut, {{ ($pkb->ditandatangani_pada ?? now())->translatedFormat('d F Y') }}
        </p>

        <div class="text-right">
            <p class="mb-2">Pemilik Data Pribadi,</p>

            {{-- Sudah ada tanda tangan tersimpan --}}
            @if ($pkb && $pkb->tanda_tangan)
                <div class="flex justify-end mb-2">
                    <img src="{{ $pkb->tanda_tangan_url }}" alt="Tanda tangan" class="h-24 object-contain">
                </div>
            @else
                {{-- Signature pad -- belum ditandatangani --}}
                <div class="border-2 border-dashed border-slate-300 rounded-lg mb-2 bg-slate-50" wire:ignore>
                    <canvas x-ref="canvas" class="w-full" style="height: 180px; touch-action: none;"></canvas>
                </div>
                <div class="flex justify-end gap-2 mb-2">
                    <button type="button" @click="clear()" class="text-xs text-slate-500 hover:text-slate-800 underline">
                        Hapus & Ulangi
                    </button>
                </div>
            @endif

            <p class="font-semibold">({{ $antrean->nama_konsumen }})</p>
        </div>
    </div>

    {{-- Tombol simpan tanda tangan (belum ada PKB) --}}
    @if (! $pkb)
        <div class="mt-4 flex justify-end">
            <button type="button" @click="kirimTandaTangan()"
                class="px-6 py-3 rounded-lg bg-slate-900 text-white font-semibold hover:bg-slate-800">
                Simpan Persetujuan & Tanda Tangan
            </button>
        </div>
    @endif

    {{-- Form admin isi No. PKB/WO --}}
    @if ($pkb && $pkb->status === 'menunggu_no_pkb' && $bisaIsiNoPkb)
        <div class="mt-6 bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="text-sm font-semibold text-slate-700 mb-3">Isi No. PKB/WO (Admin)</h2>
            <div class="flex gap-3">
                <input type="text" wire:model="no_pkb" placeholder="Contoh: PKB/2026/08/0001"
                    class="flex-1 rounded-lg border-slate-300 text-sm focus:ring-slate-800 focus:border-slate-800">
                <button wire:click="simpanNoPkb" class="px-5 py-2 rounded-lg bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800">
                    Simpan
                </button>
            </div>
            @error('no_pkb') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    @elseif ($pkb && $pkb->status === 'menunggu_no_pkb')
        <div class="mt-6 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl p-4 text-sm">
            Formulir sudah ditandatangani konsumen, menunggu admin mengisi No. PKB/WO.
        </div>
    @endif

    {{-- Tombol download PDF (sudah selesai) --}}
    @if ($pkb && $pkb->status === 'selesai')
        <div class="mt-6 flex justify-end">
            <a href="{{ route('pkb.download', $pkb->id) }}" target="_blank"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Download / Cetak PDF
            </a>
        </div>
    @endif
</div>

@assets
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.7/signature_pad.umd.min.js"></script>
@endassets

@script
<script>
    Alpine.data('signaturePad', () => ({
        pad: null,

        init() {
            this.$nextTick(() => {
                if (this.$refs.canvas) {
                    const canvas = this.$refs.canvas;
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext('2d').scale(ratio, ratio);

                    this.pad = new SignaturePad(canvas, {
                        backgroundColor: 'rgb(255, 255, 255)',
                    });
                }
            });
        },

        clear() {
            if (this.pad) this.pad.clear();
        },

        async kirimTandaTangan() {
            if (! this.pad || this.pad.isEmpty()) {
                alert('Mohon tanda tangan dulu sebelum menyimpan.');
                return;
            }
            
            const dataUrl = this.pad.toDataURL('image/png');
            await $wire.set('tandaTanganBase64', dataUrl);
            await $wire.simpanTandaTangan();
        }
    }));
</script>
@endscript