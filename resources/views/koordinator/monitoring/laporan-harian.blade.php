<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - {{ $tanggal->format('d F Y') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --primary: #4F46E5;
            --primary-light: #EEF2FF;
            --secondary: #7C3AED;
            --success: #059669;
            --success-light: #D1FAE5;
            --warning: #D97706;
            --warning-light: #FEF3C7;
            --danger: #DC2626;
            --danger-light: #FEE2E2;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: var(--gray-900);
            background: #F8FAFF;
            padding: 24px;
        }

        /* ─── PRINT BUTTON ─── */
        .print-btn-wrap {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.4); }

        .btn-back {
            background: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
        }

        .btn-back:hover { background: var(--gray-50); }

        /* ─── PAGE WRAPPER ─── */
        .page {
            max-width: 960px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }

        /* ─── HEADER ─── */
        .header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
            padding: 32px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: 15%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header-icon {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(10px);
        }

        .header-title h1 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 3px;
        }

        .header-title p {
            font-size: 12px;
            opacity: 0.8;
        }

        .header-date {
            text-align: right;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 14px 20px;
            min-width: 180px;
        }

        .header-date .date-label { font-size: 10px; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.5px; }
        .header-date .date-value { font-size: 15px; font-weight: 800; margin-top: 2px; }

        /* ─── SUMMARY STRIP ─── */
        .summary-strip {
            background: var(--gray-50);
            border-bottom: 2px solid var(--gray-100);
            padding: 20px 40px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .summary-item {
            background: white;
            border-radius: 12px;
            padding: 14px 16px;
            text-align: center;
            border: 1px solid var(--gray-200);
        }

        .summary-item .s-label { font-size: 10px; color: var(--gray-500); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .summary-item .s-value { font-size: 22px; font-weight: 800; color: var(--primary); margin-top: 4px; }
        .summary-item .s-sub { font-size: 10px; color: var(--gray-500); margin-top: 2px; }

        /* ─── CONTENT BODY ─── */
        .body { padding: 32px 40px; }

        /* ─── SECTION HEADER ─── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--gray-100);
        }

        .section-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .icon-green { background: var(--success-light); }
        .icon-indigo { background: var(--primary-light); }

        .section-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--gray-900);
        }

        .section-subtitle {
            font-size: 11px;
            color: var(--gray-500);
            margin-top: 1px;
        }

        .section-badge {
            margin-left: auto;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 99px;
        }

        /* ─── TABLE ─── */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            margin-bottom: 32px;
        }

        .data-table thead tr {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .data-table thead th {
            padding: 12px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .data-table tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: background 0.15s;
        }

        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:nth-child(even) { background: var(--gray-50); }

        .data-table tbody td {
            padding: 10px 14px;
            font-size: 11px;
            color: var(--gray-700);
            vertical-align: middle;
        }

        .no-circle {
            width: 26px;
            height: 26px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
        }

        .avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            vertical-align: middle;
            margin-right: 8px;
        }

        .name-cell { display: flex; align-items: center; }

        /* ─── STATUS BADGES ─── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 700;
        }

        .badge-hadir { background: var(--success-light); color: var(--success); border: 1px solid #A7F3D0; }
        .badge-izin  { background: var(--warning-light); color: var(--warning); border: 1px solid #FDE68A; }
        .badge-sakit { background: var(--danger-light);  color: var(--danger);  border: 1px solid #FECACA; }
        .badge-selesai { background: var(--primary-light); color: var(--primary); border: 1px solid #C7D2FE; }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-hadir  { background: var(--success); }
        .dot-izin   { background: var(--warning); }
        .dot-sakit  { background: var(--danger); }

        .area-tag {
            background: #EEF2FF;
            color: #4338CA;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
        }

        .jam-tag {
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        .catatan-text {
            color: var(--gray-500);
            font-style: italic;
        }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 30px;
            color: var(--gray-500);
        }

        .empty-state .empty-icon { font-size: 32px; margin-bottom: 8px; }
        .empty-state p { font-size: 12px; font-weight: 600; }

        /* ─── FOOTER / SIGNATURE ─── */
        .footer-section {
            border-top: 2px solid var(--gray-100);
            padding: 28px 40px;
            background: var(--gray-50);
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .footer-info p {
            font-size: 11px;
            color: var(--gray-500);
            margin-bottom: 3px;
        }

        .footer-info strong { color: var(--gray-900); }

        .signature-block {
            text-align: center;
        }

        .signature-block p { font-size: 11px; color: var(--gray-700); margin-bottom: 4px; }
        .signature-line {
            width: 200px;
            border-bottom: 1.5px solid var(--gray-700);
            margin: 70px auto 8px;
        }

        .signature-name { font-size: 11px; font-weight: 700; color: var(--gray-900); }

        .footer-branding {
            text-align: center;
            padding-top: 16px;
            border-top: 1px solid var(--gray-200);
        }

        .footer-branding p {
            font-size: 10px;
            color: var(--gray-500);
        }

        .footer-branding strong { color: var(--primary); }

        /* ─── PRINT STYLES ─── */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .no-print { display: none !important; }

            .page {
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }

            .data-table { page-break-inside: avoid; }

            @page {
                margin: 1cm;
                size: A4;
            }
        }
    </style>
</head>
<body>

    <!-- Print/Back Buttons -->
    <div class="print-btn-wrap no-print">
        <a href="{{ url()->previous() }}" class="btn btn-back">
            ← Kembali
        </a>
        <button class="btn btn-primary" onclick="window.print()">
            🖨️ Print / Save PDF
        </button>
    </div>

    <div class="page">
        <!-- ── HEADER ── -->
        <div class="header">
            <div class="header-content">
                <div class="header-logo">
                    <div class="header-icon">🧹</div>
                    <div class="header-title">
                        <h1>Laporan Harian Pembersihan ATM</h1>
                        <p>Sistem Monitoring Cleaning Service · CS ATM Monitoring</p>
                    </div>
                </div>
                <div class="header-date">
                    <p class="date-label">Tanggal Laporan</p>
                    <p class="date-value">{{ $tanggal->format('d F Y') }}</p>
                    <p class="date-label" style="margin-top:6px;">{{ $tanggal->format('l') }}</p>
                </div>
            </div>
        </div>

        <!-- ── SUMMARY STRIP ── -->
        <div class="summary-strip">
            <div class="summary-item">
                <p class="s-label">Total CS</p>
                <p class="s-value">{{ $absensis->count() }}</p>
                <p class="s-sub">Cleaning Service</p>
            </div>
            <div class="summary-item">
                <p class="s-label">Hadir</p>
                <p class="s-value" style="color: var(--success);">{{ $absensis->where('status','hadir')->count() }}</p>
                <p class="s-sub">CS yang hadir</p>
            </div>
            <div class="summary-item">
                <p class="s-label">Total ATM</p>
                <p class="s-value">{{ $laporans->count() }}</p>
                <p class="s-sub">ATM dibersihkan</p>
            </div>
            <div class="summary-item">
                <p class="s-label">Dicetak</p>
                <p class="s-value" style="font-size: 13px; color: var(--gray-700);">{{ now()->format('H:i') }}</p>
                <p class="s-sub">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <!-- ── CONTENT BODY ── -->
        <div class="body">

            <!-- SECTION 1: ABSENSI -->
            <div class="section-header">
                <div class="section-icon icon-green">✅</div>
                <div>
                    <p class="section-title">Daftar Absensi</p>
                    <p class="section-subtitle">Rekap kehadiran cleaning service hari ini</p>
                </div>
                <span class="section-badge">{{ $absensis->count() }} CS</span>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:4%">No</th>
                        <th style="width:26%">Nama CS</th>
                        <th style="width:12%">Jam Absen</th>
                        <th style="width:22%">Area</th>
                        <th style="width:12%">Status</th>
                        <th style="width:24%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis as $index => $absensi)
                        <tr>
                            <td style="text-align:center">
                                <span class="no-circle">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="name-cell">
                                    <span class="avatar">{{ substr($absensi->csProfile->user->name, 0, 1) }}</span>
                                    <div>
                                        <div style="font-weight:700; color: var(--gray-900);">{{ $absensi->csProfile->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="jam-tag">🕐 {{ $absensi->jam_absen }}</span>
                            </td>
                            <td>
                                <span class="area-tag">📍 {{ $absensi->area->nama_area }}</span>
                            </td>
                            <td>
                                @if($absensi->status === 'hadir')
                                    <span class="badge badge-hadir">
                                        <span class="badge-dot dot-hadir"></span> Hadir
                                    </span>
                                @elseif($absensi->status === 'izin')
                                    <span class="badge badge-izin">
                                        <span class="badge-dot dot-izin"></span> Izin
                                    </span>
                                @else
                                    <span class="badge badge-sakit">
                                        <span class="badge-dot dot-sakit"></span> Sakit
                                    </span>
                                @endif
                            </td>
                            <td class="catatan-text">{{ $absensi->keterangan ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <p>Tidak ada data absensi untuk hari ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- SECTION 2: LAPORAN PEMBERSIHAN -->
            <div class="section-header">
                <div class="section-icon icon-indigo">📊</div>
                <div>
                    <p class="section-title">Laporan Pembersihan ATM</p>
                    <p class="section-subtitle">Detail ATM yang telah dibersihkan hari ini</p>
                </div>
                <span class="section-badge">{{ $laporans->count() }} ATM</span>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:4%">No</th>
                        <th style="width:22%">Nama CS</th>
                        <th style="width:18%">Area</th>
                        <th style="width:24%">Nama ATM</th>
                        <th style="width:16%">Lokasi</th>
                        <th style="width:16%">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $laporan)
                        <tr>
                            <td style="text-align:center">
                                <span class="no-circle">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="name-cell">
                                    <span class="avatar" style="background: linear-gradient(135deg, #10B981, #059669);">{{ substr($laporan->csProfile->user->name, 0, 1) }}</span>
                                    <div style="font-weight:700; color: var(--gray-900);">{{ $laporan->csProfile->user->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="area-tag">📍 {{ $laporan->atm->area->nama_area }}</span>
                            </td>
                            <td style="font-weight:700; color: var(--gray-900);">{{ $laporan->atm->nama_atm }}</td>
                            <td>{{ $laporan->atm->lokasi }}</td>
                            <td class="catatan-text">{{ $laporan->catatan ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">🏧</div>
                                    <p>Tidak ada laporan pembersihan untuk hari ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ── FOOTER / SIGNATURE ── -->
        <div class="footer-section">
            <div class="footer-top">
                <div class="footer-info">
                    <p>Laporan dibuat secara otomatis oleh sistem</p>
                    <p>Dicetak pada: <strong>{{ now()->format('l, d F Y · H:i') }} WIB</strong></p>
                    <p>Periode: <strong>{{ $tanggal->format('d F Y') }}</strong></p>
                </div>
                <div class="signature-block">
                    <p>Jakarta, {{ $tanggal->format('d F Y') }}</p>
                    <p style="margin-top:4px; font-weight:600;">Koordinator,</p>
                    <div class="signature-line"></div>
                    <p class="signature-name">( _____________________ )</p>
                </div>
            </div>
            <div class="footer-branding">
                <p>📊 <strong>CS ATM Monitoring System</strong> · Laporan ini merupakan dokumen resmi yang digenerate secara otomatis</p>
            </div>
        </div>
    </div>

</body>
</html>
