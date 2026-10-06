<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f3f6fb;
        color: #1e293b;
        line-height: 1.6;
    }

    .wrap {
        width: min(1120px, 100%);
        margin: 0 auto;
        padding: 24px;
    }

    .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        margin-bottom: 28px;
    }

    .label {
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
        margin: 0 0 6px;
    }

    h1 { margin: 0; font-size: 32px; }
    .intro, .date { color: #64748b; }
    .date { font-size: 13px; white-space: nowrap; }

    .cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .card {
        background: white;
        border: 1px solid #e2e8f0;
        border-top: 4px solid #2563eb;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 6px 20px rgb(15 23 42 / 5%);
    }

    .card.finance { border-top-color: #059669; }
    .card.activity { border-top-color: #9333ea; }

    /* Kotak dan ukuran ikon */
    .card .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eff6ff;
        color: #2563eb;
    }

    .card .icon svg {
        display: block;
        width: 28px;
        height: 28px;
        max-width: 28px;
        flex-shrink: 0;
    }

    .finance .icon { background: #ecfdf5; color: #059669; }
    .activity .icon { background: #faf5ff; color: #9333ea; }

    .card h3 { margin: 16px 0 8px; font-size: 18px; }
    .card p { color: #64748b; font-size: 14px; }
    .card a { color: #2563eb; font-size: 14px; font-weight: 600; }

    .panel {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
        scroll-margin-top: 24px;
    }

    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .panel-head h2 { margin: 0; font-size: 20px; }
    .panel-body { padding: 24px; }

    .tag {
        background: #eff6ff;
        color: #2563eb;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .feature h3 { margin: 0 0 8px; font-size: 15px; }
    .feature p { margin: 0; color: #64748b; font-size: 14px; }

    .notice {
        margin: 20px 0 0;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 8px;
        color: #64748b;
        font-size: 13px;
    }

    .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 20px; }

    .chip {
        background: #ecfdf5;
        color: #047857;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .access {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 28px;
        background: #172554;
        color: white;
        border-radius: 16px;
    }

    .access h2 { margin: 0 0 6px; font-size: 22px; }
    .access p { margin: 0; color: #cbd5e1; font-size: 14px; }

    .btn.gold {
        display: inline-flex;
        justify-content: center;
        padding: 12px 20px;
        background: #fbbf24;
        color: #172554;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        white-space: nowrap;
    }

    .footer {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        color: #64748b;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .cards, .features { grid-template-columns: 1fr; }
        .heading, .access, .footer {
            flex-direction: column;
            align-items: flex-start;
        }
        h1 { font-size: 28px; }
        .wrap { padding: 20px; }
        .date { margin: 0; }
    }
    .top-login {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }    
</style>

<main class="wrap">
    <div class="heading">
        <div><p class="label">Administrasi &amp; Pelayanan Gereja</p><h1>Dashboard Jemaat</h1><p class="intro">Kelola kehadiran, pencatatan keuangan, dan kegiatan jemaat dalam satu panel pelayanan.</p></div>
        <p class="date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        
        <div class="top-login">
            <a href="{{ $loginUrl }}" class="btn gold">
                Login ke Panel
            </a>
        </div>

    </div>
    <div class="cards">
        <article class="card">
            <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 5H5v15h14V5h-4M9 3h6v4H9zM8 13l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <h3>Absensi Jemaat</h3><p>Pencatatan kehadiran ibadah, komsel, dan kegiatan pelayanan.</p><a href="#absensi">Lihat informasi absensi</a>
        </article>
        <article class="card finance">
            <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18M7 15h4" stroke-linecap="round"/></svg></span>
            <h3>Laporan Keuangan</h3><p>Pencatatan persembahan, pengeluaran, dan laporan kas gereja.</p><a href="#keuangan">Lihat informasi keuangan</a>
        </article>
        <article class="card activity">
            <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4M17 3v4M3 11h18M8 15h2M14 15h2" stroke-linecap="round"/></svg></span>
            <h3>Kegiatan Jemaat</h3><p>Jadwal ibadah, persekutuan, dan agenda pelayanan jemaat.</p><a href="#kegiatan">Lihat informasi kegiatan</a>
        </article>
    </div>
    <section class="panel" id="absensi">
        <div class="panel-head"><h2>Absensi Jemaat</h2><span class="tag">Kehadiran &amp; Rekapitulasi</span></div>
        <div class="panel-body">
            <div class="features">
                <div class="feature"><h3>Kehadiran Ibadah</h3><p>Catat kehadiran jemaat berdasarkan tanggal dan jenis ibadah.</p></div>
                <div class="feature"><h3>Komsel &amp; Kelompok</h3><p>Rekap kehadiran persekutuan berdasarkan kelompok jemaat.</p></div>
                <div class="feature"><h3>Rekap Absensi</h3><p>Tinjau kehadiran per jemaat dan periode untuk mendukung tindak lanjut pelayanan.</p></div>
            </div>
            <p class="notice">Masuk ke panel untuk mengakses data kehadiran jemaat.</p>
        </div>
    </section>
    <section class="panel" id="keuangan">
        <div class="panel-head"><h2>Laporan Keuangan</h2><span class="tag">Persembahan &amp; Kas Gereja</span></div>
        <div class="panel-body">
            <div class="features">
                <div class="feature"><h3>Penerimaan Persembahan</h3><p>Pencatatan persembahan per kantong, nomor jemaat, atau tanpa identitas jemaat.</p></div>
                <div class="feature"><h3>Tunai &amp; Transfer</h3><p>Bedakan metode pembayaran dan rekening penerima pada setiap pencatatan.</p></div>
                <div class="feature"><h3>Laporan Kas</h3><p>Rekap pemasukan, pengeluaran, dan saldo berdasarkan periode dan rekening.</p></div>
            </div>
            <div class="chips" aria-label="Jenis persembahan"><span class="chip">Perpuluhan</span><span class="chip">Pembangunan</span><span class="chip">Sekolah Minggu Anak</span><span class="chip">Anak Muda</span><span class="chip">Janji Iman</span></div>
            <p class="notice">Laporan keuangan tersedia di panel sesuai hak akses pengguna.</p>
        </div>
    </section>
    <section class="panel" id="kegiatan">
        <div class="panel-head"><h2>Kegiatan Jemaat</h2><span class="tag">Jadwal &amp; Pelayanan</span></div>
        <div class="panel-body">
            <div class="features">
                <div class="feature"><h3>Ibadah &amp; Persekutuan</h3><p>Kelola jadwal ibadah raya, komsel, dan persekutuan doa.</p></div>
                <div class="feature"><h3>Pelayanan Anak &amp; Pemuda</h3><p>Atur kegiatan sekolah minggu dan persekutuan anak muda.</p></div>
                <div class="feature"><h3>Agenda Jemaat</h3><p>Catat tanggal, lokasi, dan penanggung jawab kegiatan gereja.</p></div>
            </div>
            <p class="notice">Masuk ke panel untuk melihat dan mengelola agenda kegiatan.</p>
        </div>
    </section>
    <div class="access"><div><h2>Panel Pelayanan Jemaat</h2><p>Akses data dan pengelolaan sesuai peran pengguna.</p></div><a href="{{ $loginUrl }}" class="btn gold">Login ke Panel</a></div>
</main>
<footer><div class="wrap footer"><span>&copy; {{ date('Y') }} Dashboard Jemaat.</span><span>Absensi · Keuangan · Kegiatan Jemaat</span></div></footer>
</body>
</html>
