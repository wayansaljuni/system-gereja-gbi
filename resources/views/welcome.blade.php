<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'NAYATI-SYSTEM') }} — Enterprise Resource Planning</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700,900i|inter:400,500,600,700|ibm-plex-mono:500" rel="stylesheet" />

    <style>
        :root{
            --ink:#101826;
            --ink-soft:#1b2436;
            --paper:#EEF1F6;
            --paper-card:#FFFFFF;
            --gold:#B8862E;
            --gold-bright:#D9A441;
            --slate:#5B6472;
            --line:#D7DCE5;
            --line-dark:#2B3547;
            --ok:#2F7A4E;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Inter',ui-sans-serif,system-ui,sans-serif;
            background:var(--paper);
            color:var(--ink);
            line-height:1.5;
            -webkit-font-smoothing:antialiased;
        }
        a{color:inherit;text-decoration:none;}
        img,svg{display:block;max-width:100%;}
        .wrap{max-width:1180px;margin:0 auto;padding:0 28px;}
        .mono{font-family:'IBM Plex Mono',ui-monospace,monospace;letter-spacing:.03em;}

        :focus-visible{outline:2px solid var(--gold-bright);outline-offset:3px;}

        /* ---------- Top bar ---------- */
        header.topbar{
            position:sticky;top:0;z-index:50;
            background:rgba(238,241,246,.86);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--line);
        }
        .topbar-inner{
            display:flex;align-items:center;justify-content:space-between;
            padding:16px 0;
        }
        .brand{display:flex;align-items:center;gap:10px;}
        .brand-mark{
            width:34px;height:34px;border-radius:9px;
            background:linear-gradient(155deg,var(--ink) 0%,var(--ink-soft) 60%,#2c3854 100%);
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 1px 0 rgba(255,255,255,.06) inset;
        }
        .brand-mark svg{width:18px;height:18px;}
        .brand-name{font-weight:700;font-size:15px;letter-spacing:.02em;}
        .brand-name .dim{color:var(--slate);font-weight:500;}

        nav.mainnav{display:flex;align-items:center;gap:28px;}
        nav.mainnav a{font-size:14px;color:var(--slate);font-weight:500;transition:color .15s;}
        nav.mainnav a:hover{color:var(--ink);}

        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:8px;
            padding:11px 20px;border-radius:7px;font-weight:600;font-size:14px;
            border:1px solid transparent;cursor:pointer;transition:transform .15s ease, box-shadow .15s ease, background .15s ease;
        }
        .btn-primary{
            background:var(--ink);color:#fff;
            box-shadow:0 1px 0 rgba(255,255,255,.08) inset, 0 6px 16px -8px rgba(16,24,38,.6);
        }
        .btn-primary:hover{background:var(--ink-soft);transform:translateY(-1px);}
        .btn-ghost{
            background:transparent;color:var(--ink);border-color:var(--line-dark);
        }
        .btn-ghost:hover{border-color:var(--ink);}
        .btn-gold{
            background:var(--gold);color:#fff;
            box-shadow:0 6px 18px -8px rgba(184,134,46,.65);
        }
        .btn-gold:hover{background:var(--gold-bright);transform:translateY(-1px);}

        /* ---------- Hero ---------- */
        .hero{
            position:relative;overflow:hidden;
            background:
                repeating-linear-gradient(180deg, rgba(16,24,38,.035) 0px, rgba(16,24,38,.035) 1px, transparent 1px, transparent 34px),
                var(--paper);
            border-bottom:1px solid var(--line);
        }
        .hero-inner{
            padding:96px 0 80px;
            display:grid;grid-template-columns:1.15fr .85fr;gap:56px;align-items:center;
        }
        .eyebrow{
            display:inline-flex;align-items:center;gap:8px;
            font-family:'IBM Plex Mono',monospace;font-size:12px;letter-spacing:.08em;
            color:var(--gold);text-transform:uppercase;font-weight:500;
            padding:6px 12px;border:1px solid rgba(184,134,46,.35);border-radius:100px;
            background:rgba(184,134,46,.06);
            margin-bottom:22px;
        }
        .eyebrow .dot{width:6px;height:6px;border-radius:50%;background:var(--ok);}
        h1.headline{
            font-family:'Fraunces',Georgia,serif;
            font-weight:700;
            font-size:clamp(34px,4.4vw,58px);
            line-height:1.05;
            letter-spacing:-.01em;
            color:var(--ink);
            margin-bottom:22px;
        }
        h1.headline em{
            font-style:italic;font-weight:900;color:var(--gold);
        }
        .lede{
            font-size:17px;color:var(--slate);max-width:52ch;margin-bottom:34px;
        }
        .hero-cta{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:36px;}
        .hero-note{font-size:13px;color:var(--slate);display:flex;align-items:center;gap:8px;}
        .hero-note svg{width:15px;height:15px;color:var(--ok);flex-shrink:0;}

        .hero-stats{display:flex;gap:30px;padding-top:26px;border-top:1px solid var(--line);}
        .stat b{
            display:block;font-family:'Fraunces',serif;font-size:26px;font-weight:700;color:var(--ink);
        }
        .stat span{font-size:12.5px;color:var(--slate);}

        /* ---------- Ledger card (signature element) ---------- */
        .ledger{
            position:relative;
            background:var(--paper-card);
            border:1px solid var(--line);
            border-radius:14px;
            box-shadow:0 30px 60px -30px rgba(16,24,38,.35);
            padding:26px 26px 22px;
            transform:rotate(1.2deg);
        }
        .ledger::before{
            content:"";position:absolute;inset:10px;border:1px dashed rgba(16,24,38,.14);border-radius:8px;pointer-events:none;
        }
        .ledger-head{
            display:flex;justify-content:space-between;align-items:flex-start;
            padding-bottom:14px;border-bottom:1px solid var(--line);margin-bottom:14px;
        }
        .ledger-head .doc-id{font-family:'IBM Plex Mono',monospace;font-size:11.5px;color:var(--slate);}
        .stamp{
            font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:700;letter-spacing:.08em;
            color:var(--ok);border:1.5px solid var(--ok);padding:4px 10px;border-radius:5px;
            transform:rotate(-6deg);
        }
        .ledger-row{
            display:flex;justify-content:space-between;align-items:center;
            padding:11px 0;border-bottom:1px solid rgba(16,24,38,.07);font-size:13.5px;
        }
        .ledger-row:last-of-type{border-bottom:none;}
        .ledger-row .k{color:var(--slate);}
        .ledger-row .v{font-weight:600;}
        .badge{
            font-size:11px;font-weight:600;padding:3px 9px;border-radius:100px;
        }
        .badge.active{background:rgba(47,122,78,.12);color:var(--ok);}
        .badge.pending{background:rgba(184,134,46,.14);color:var(--gold);}
        .ledger-foot{
            margin-top:16px;padding-top:14px;border-top:1px solid var(--line);
            display:flex;justify-content:space-between;font-size:12px;color:var(--slate);
        }

        /* ---------- Section shared ---------- */
        section{padding:88px 0;}
        .section-head{max-width:640px;margin-bottom:52px;}
        .section-tag{
            font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--gold);
            text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;display:block;
        }
        h2.section-title{
            font-family:'Fraunces',serif;font-size:clamp(26px,3vw,36px);font-weight:700;color:var(--ink);
            margin-bottom:14px;letter-spacing:-.01em;
        }
        .section-desc{color:var(--slate);font-size:15.5px;max-width:56ch;}

        /* ---------- Modules grid ---------- */
        .modules{
            display:grid;grid-template-columns:repeat(3,1fr);gap:1px;
            background:var(--line);border:1px solid var(--line);border-radius:14px;overflow:hidden;
        }
        .module{
            background:var(--paper-card);padding:30px 26px;transition:background .15s;
        }
        .module:hover{background:#FBFAF7;}
        .module .idx{
            font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--gold);margin-bottom:18px;display:block;
        }
        .module h3{font-size:16px;font-weight:700;margin-bottom:8px;}
        .module p{font-size:13.5px;color:var(--slate);line-height:1.55;}

        /* ---------- Workflow strip ---------- */
        .flow{
            display:flex;align-items:stretch;background:var(--ink);border-radius:16px;
            padding:44px 40px;color:#fff;gap:0;overflow-x:auto;
        }
        .flow-step{flex:1;min-width:180px;position:relative;padding-right:28px;}
        .flow-step:not(:last-child)::after{
            content:"→";position:absolute;right:0;top:2px;color:var(--gold-bright);font-size:18px;opacity:.7;
        }
        .flow-step .num{
            font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--gold-bright);margin-bottom:10px;display:block;
        }
        .flow-step h4{font-size:15px;font-weight:600;margin-bottom:6px;}
        .flow-step p{font-size:12.5px;color:#9aa5b8;line-height:1.5;}

        /* ---------- CTA band ---------- */
        .ctaband{
            border-top:1px solid var(--line);border-bottom:1px solid var(--line);
            background:
                repeating-linear-gradient(180deg, rgba(16,24,38,.035) 0px, rgba(16,24,38,.035) 1px, transparent 1px, transparent 34px),
                var(--paper);
        }
        .ctaband-inner{
            padding:70px 0;text-align:center;display:flex;flex-direction:column;align-items:center;gap:22px;
        }
        .ctaband h2{
            font-family:'Fraunces',serif;font-weight:700;font-size:clamp(24px,3.4vw,34px);max-width:20ch;
        }

        /* ---------- Footer ---------- */
        footer{padding:40px 0;}
        .footer-inner{
            display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;
            font-size:12.5px;color:var(--slate);
        }

        @media (max-width:920px){
            .hero-inner{grid-template-columns:1fr;padding-top:64px;}
            .modules{grid-template-columns:1fr 1fr;}
            .ledger{transform:none;order:-1;}
            nav.mainnav{display:none;}
        }
        @media (max-width:560px){
            .modules{grid-template-columns:1fr;}
            .hero-stats{flex-wrap:wrap;gap:22px;}
            .flow{flex-direction:column;}
            .flow-step{padding-right:0;padding-bottom:20px;}
            .flow-step:not(:last-child)::after{display:none;}
        }
        @media (prefers-reduced-motion:reduce){
            *{transition:none !important;}
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="wrap topbar-inner">
            <div class="brand">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="5" r="2.2" fill="#D9A441"/>
                        <circle cx="6" cy="17" r="2.2" fill="#EEF1F6"/>
                        <circle cx="18" cy="17" r="2.2" fill="#EEF1F6"/>
                        <path d="M12 7.2V12M12 12L6.8 15.2M12 12L17.2 15.2" stroke="#EEF1F6" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="brand-name">NAYATI<span class="dim">-SYSTEM</span></span>
            </div>

            <nav class="mainnav">
                <a href="#modul">Modul</a>
                <a href="#alur">Alur Kerja</a>
                <a href="#tentang">Tentang</a>
            </nav>

            <a href="{{ Route::has('filament.admin.auth.login') ? route('filament.admin.auth.login') : url('/admin/login') }}" class="btn btn-primary">
                Masuk
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    </header>

    <section class="hero">
        <div class="wrap hero-inner">
            <div>
                <span class="eyebrow"><span class="dot"></span> Sistem internal — akses staf resmi</span>
                <h1 class="headline">Satu sistem untuk <em>seluruh operasional</em> perusahaan.</h1>
                <p class="lede">
                    NAYATI-SYSTEM menyatukan keuangan, inventaris, pengadaan, SDM, dan perjanjian dalam satu panel —
                    supaya setiap divisi bekerja dari data yang sama, bukan spreadsheet dan folder terpisah.
                </p>

                <div class="hero-cta">
                    <a href="{{ Route::has('filament.admin.auth.login') ? route('filament.admin.auth.login') : url('/admin/login') }}" class="btn btn-gold">
                        Masuk ke Panel Admin
                    </a>
                    <a href="#modul" class="btn btn-ghost">Lihat Modul</a>
                </div>

                <div class="hero-note">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Akses dibatasi untuk pengguna terverifikasi dengan peran yang sesuai.
                </div>

                <div class="hero-stats">
                    <div class="stat"><b>6</b><span>Modul Terintegrasi</span></div>
                    <div class="stat"><b>100%</b><span>Data Real-time</span></div>
                    <div class="stat"><b>1</b><span>Panel, Semua Divisi</span></div>
                </div>
            </div>

            <div class="ledger" aria-hidden="true">
                <div class="ledger-head">
                    <div>
                        <div class="doc-id">RINGKASAN / HARI INI</div>
                    </div>
                    <span class="stamp">LIVE</span>
                </div>
                <div class="ledger-row"><span class="k">Stok Kritis</span><span class="v">7 Item</span></div>
                <div class="ledger-row"><span class="k">Pesanan Pembelian</span><span class="badge pending">Menunggu Approval</span></div>
                <div class="ledger-row"><span class="k">Faktur Jatuh Tempo</span><span class="v">Rp 84.200.000</span></div>
                <div class="ledger-row"><span class="k">Perjanjian Aktif</span><span class="badge active">Berjalan</span></div>
                <div class="ledger-row"><span class="k">Cuti Karyawan</span><span class="v">3 Pengajuan</span></div>
                <div class="ledger-foot">
                    <span class="mono">Diperbarui otomatis</span>
                    <span class="mono">NAYATI-SYSTEM</span>
                </div>
            </div>
        </div>
    </section>

    <section id="modul">
        <div class="wrap">
            <div class="section-head">
                <span class="section-tag">Modul Inti</span>
                <h2 class="section-title">Setiap divisi, satu sumber data yang sama.</h2>
                <p class="section-desc">Dari gudang sampai pembukuan — semua tercatat di panel yang sama, jadi tidak ada lagi angka yang beda antar tim.</p>
            </div>

            <div class="modules">
                <div class="module">
                    <span class="idx">01</span>
                    <h3>Keuangan &amp; Akuntansi</h3>
                    <p>Pencatatan transaksi, faktur, dan arus kas terhubung langsung dengan aktivitas operasional.</p>
                </div>
                <div class="module">
                    <span class="idx">02</span>
                    <h3>Inventaris &amp; Gudang</h3>
                    <p>Pantau stok, mutasi barang, dan titik pemesanan ulang secara real-time.</p>
                </div>
                <div class="module">
                    <span class="idx">03</span>
                    <h3>Pembelian &amp; Pengadaan</h3>
                    <p>Kelola permintaan, penawaran vendor, dan pesanan pembelian dalam satu alur persetujuan.</p>
                </div>
                <div class="module">
                    <span class="idx">04</span>
                    <h3>CRM-Customer Relation Mangement </h3>
                    <p>Data Prospek, Deal, Purna Jual dan Services.</p>
                </div>
                <div class="module">
                    <span class="idx">05</span>
                    <h3>Perjanjian &amp; Kontrak</h3>
                    <p>Catat jenis dan status perjanjian perusahaan, lengkap dengan riwayat persetujuannya.</p>
                </div>
                <div class="module">
                    <span class="idx">06</span>
                    <h3>Laporan &amp; Kontrol Akses</h3>
                    <p>Dashboard lintas divisi dengan hak akses yang diatur sesuai peran masing-masing pengguna.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="alur">
        <div class="wrap">
            <div class="section-head">
                <span class="section-tag">Alur Kerja</span>
                <h2 class="section-title">Dari permintaan sampai laporan akhir.</h2>
            </div>

            <div class="flow">
                <div class="flow-step">
                    <span class="num">01</span>
                    <h4>Diajukan</h4>
                    <p>Permintaan barang, pembelian, atau dokumen dicatat masuk sistem.</p>
                </div>
                <div class="flow-step">
                    <span class="num">02</span>
                    <h4>Disetujui</h4>
                    <p>Pihak berwenang meninjau sesuai jalur persetujuan divisi terkait.</p>
                </div>
                <div class="flow-step">
                    <span class="num">03</span>
                    <h4>Dieksekusi</h4>
                    <p>Stok, transaksi, atau status berubah otomatis di seluruh modul terkait.</p>
                </div>
                <div class="flow-step">
                    <span class="num">04</span>
                    <h4>Dilaporkan</h4>
                    <p>Hasilnya langsung terlihat di dashboard lintas divisi.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ctaband" id="tentang">
        <div class="wrap ctaband-inner">
            <span class="section-tag">Mulai Bekerja</span>
            <h2>Masuk ke panel untuk mengelola operasional perusahaan hari ini.</h2>
            <a href="{{ Route::has('filament.admin.auth.login') ? route('filament.admin.auth.login') : url('/admin/login') }}" class="btn btn-primary">
                Masuk ke NAYATI-SYSTEM
            </a>
        </div>
    </section>

    <footer>
        <div class="wrap footer-inner">
            <span>&copy; {{ date('Y') }} NAYATI-SYSTEM. Seluruh hak cipta dilindungi.</span>
            <span class="mono">Enterprise Resource Planning — Internal</span>
        </div>
    </footer>

</body>
</html>