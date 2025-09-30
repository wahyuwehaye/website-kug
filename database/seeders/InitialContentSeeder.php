<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\ContactChannel;
use App\Models\Faq;
use App\Models\FinancialDocument;
use App\Models\HeroSlide;
use App\Models\LeadershipMessage;
use App\Models\NavigationLink;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        $setting = SiteSetting::query()->updateOrCreate([], [
            'name' => ['id' => 'Direktorat Keuangan Telkom University', 'en' => 'Telkom University Finance Directorate'],
            'tagline' => ['id' => 'Layanan Keuangan Terintegrasi bagi Seluruh Sivitas', 'en' => 'Integrated Financial Services for the Telkom University Community'],
            'short_description' => ['id' => 'Direktorat Keuangan menghadirkan layanan penganggaran, penatausahaan, dan pelaporan keuangan yang transparan untuk mendukung akademik dan bisnis Telkom University.', 'en' => 'The Finance Directorate delivers transparent budgeting, treasury, and reporting services that support Telkom University’s academic and business ecosystem.'],
            'vision' => ['id' => 'Menjadi mitra strategis yang unggul dalam tata kelola keuangan perguruan tinggi.', 'en' => 'To become an excellent strategic partner in university financial governance.'],
            'mission' => ['id' => 'Menyediakan layanan keuangan yang profesional, akuntabel, dan adaptif terhadap kebutuhan sivitas.', 'en' => 'Provide professional, accountable, and responsive financial services for the entire community.'],
            'about' => ['id' => '<p>Direktorat Keuangan Telkom University mengelola siklus keuangan kampus mulai dari perencanaan anggaran, penatausahaan kas, administrasi pembiayaan mahasiswa, hingga pelaporan dan analisis kinerja keuangan. Seluruh layanan dikerjakan berbasis sistem digital terintegrasi untuk menjamin transparansi dan kepatuhan.</p>', 'en' => '<p>The Finance Directorate of Telkom University manages the full financial cycle from budget planning, treasury operations, student financing administration, to reporting and performance analytics. All services are supported by integrated digital systems to ensure transparency and compliance.</p>'],
            'address' => ['id' => 'Gedung Bangkit, Lantai 3, Telkom University, Bandung', 'en' => 'Bangkit Building, 3rd Floor, Telkom University, Bandung'],
            'meta_description' => ['id' => 'Portal resmi Direktorat Keuangan Telkom University yang memuat layanan, program, dan informasi keuangan terbaru.', 'en' => 'Official portal of Telkom University Finance Directorate featuring services, programmes, and latest financial information.'],
            'meta_keywords' => ['id' => 'direktorat keuangan telkom university, layanan keuangan telkom, rba telkom university', 'en' => 'telkom university finance directorate, telkom finance services, university budgeting'],
            'email' => 'finance@telkomuniversity.ac.id',
            'phone' => '+62 22 7564 108',
            'whatsapp' => '+62 811 910 1212',
            'hotline' => '1500-133 (Finance Care)',
            'office_hours' => 'Senin - Jumat, 08.00 - 16.30 WIB',
            'feedback_url' => 'https://forms.gle/finance-feedback',
            'facebook_url' => 'https://facebook.com/telkomuniversity',
            'instagram_url' => 'https://instagram.com/finance.telu',
            'linkedin_url' => 'https://linkedin.com/school/telkom-university',
            'youtube_url' => 'https://youtube.com/telkomuniversity',
            'sso_login_url' => 'https://login.telkomuniversity.ac.id',
            'logo_path' => 'assets/images/kug.png',
            'dark_logo_path' => 'assets/images/Logo-Tel-U-glow.png',
            'primary_color' => '#BF121C',
            'secondary_color' => '#0E7490',
            'map_embed' => '<p>Bangkit Building, 3rd Floor, Telkom University, Bandung</p>',
            'map_lat' => -6.9739398,
            'map_lng' => 107.6325532,
            'map_zoom' => 18,
        ]);

        // Navigation
        NavigationLink::query()->delete();

        $topLinks = [
            ['title' => ['id' => 'Portal Layanan', 'en' => 'Service Portal'], 'url' => '#services', 'location' => 'top'],
            ['title' => ['id' => 'Dokumen Publik', 'en' => 'Public Documents'], 'url' => '#documents', 'location' => 'top'],
            ['title' => ['id' => 'Formulir', 'en' => 'Forms'], 'url' => '#downloads', 'location' => 'top'],
            ['title' => ['id' => 'FAQ', 'en' => 'FAQ'], 'url' => '#faq', 'location' => 'top'],
            ['title' => ['id' => 'Kontak', 'en' => 'Contact'], 'url' => '#contact', 'location' => 'top'],
        ];
        foreach ($topLinks as $index => $link) {
            NavigationLink::create(array_merge($link, ['sort' => $index]));
        }

        $mainMenu = [
            [
                'title' => ['id' => 'Profil', 'en' => 'Profile'],
                'url' => '#profil',
                'location' => 'main',
                'children' => [
                    ['title' => ['id' => 'Tentang Direktorat', 'en' => 'About Directorate'], 'url' => '#profil'],
                    ['title' => ['id' => 'Visi & Misi', 'en' => 'Vision & Mission'], 'url' => '#profil'],
                    ['title' => ['id' => 'Struktur Organisasi', 'en' => 'Organisation Structure'], 'url' => '#profil'],
                ],
            ],
            [
                'title' => ['id' => 'Layanan', 'en' => 'Services'],
                'url' => '#services',
                'location' => 'main',
                'children' => [
                    ['title' => ['id' => 'Program Strategis', 'en' => 'Strategic Programmes'], 'url' => '/programs?type=program'],
                    ['title' => ['id' => 'Layanan Operasional', 'en' => 'Operational Services'], 'url' => '/programs?type=service'],
                    ['title' => ['id' => 'Highlight Kinerja', 'en' => 'Performance Highlights'], 'url' => '/programs?type=highlight'],
                ],
            ],
            [
                'title' => ['id' => 'Dokumen', 'en' => 'Documents'],
                'url' => '#documents',
                'location' => 'main',
                'children' => [
                    ['title' => ['id' => 'Repositori Dokumen', 'en' => 'Document Repository'], 'url' => '/documents'],
                    ['title' => ['id' => 'Formulir Layanan', 'en' => 'Service Forms'], 'url' => '/documents?category=form'],
                    ['title' => ['id' => 'Standar & SOP', 'en' => 'Standards & SOP'], 'url' => '/documents?category=service_standard'],
                ],
            ],
            [
                'title' => ['id' => 'Berita', 'en' => 'News'],
                'url' => '/news',
                'location' => 'main',
            ],
            [
                'title' => ['id' => 'FAQ', 'en' => 'FAQ'],
                'url' => '#faq',
                'location' => 'main',
            ],
            [
                'title' => ['id' => 'Kontak', 'en' => 'Contact'],
                'url' => '/contact',
                'location' => 'main',
            ],
        ];

        foreach ($mainMenu as $index => $item) {
            $children = $item['children'] ?? [];
            unset($item['children']);
            $parent = NavigationLink::create(array_merge($item, ['sort' => $index]));
            foreach ($children as $childIndex => $child) {
                NavigationLink::create(array_merge($child, [
                    'location' => 'main',
                    'parent_id' => $parent->id,
                    'sort' => $childIndex,
                ]));
            }
        }

        foreach ([
            ['title' => ['id' => 'Portal Akademik', 'en' => 'Academic Portal'], 'url' => 'https://siakad.telkomuniversity.ac.id', 'location' => 'quick'],
            ['title' => ['id' => 'SIM Keuangan', 'en' => 'Finance Information System'], 'url' => 'https://finance.telkomuniversity.ac.id', 'location' => 'quick'],
            ['title' => ['id' => 'E-Procurement', 'en' => 'E-Procurement'], 'url' => 'https://eproc.telkomuniversity.ac.id', 'location' => 'quick'],
            ['title' => ['id' => 'Repositori Dokumen', 'en' => 'Document Repository'], 'url' => '/documents', 'location' => 'footer'],
            ['title' => ['id' => 'Formulir Layanan', 'en' => 'Service Forms'], 'url' => '/documents?category=form', 'location' => 'footer'],
            ['title' => ['id' => 'Kebijakan Keuangan', 'en' => 'Financial Policies'], 'url' => '/documents?category=policy', 'location' => 'footer'],
            ['title' => ['id' => 'FAQ Keuangan', 'en' => 'Finance FAQ'], 'url' => '#faq', 'location' => 'footer'],
        ] as $index => $quick) {
            NavigationLink::create(array_merge($quick, ['sort' => $index]));
        }

        HeroSlide::query()->truncate();
        HeroSlide::create([
            'title' => ['id' => 'Modernisasi Pengelolaan Anggaran', 'en' => 'Budget Management Modernization'],
            'subtitle' => ['id' => 'Budaya keuangan digital dan transparan', 'en' => 'Digital and transparent finance culture'],
            'description' => ['id' => 'Direktorat Keuangan menghadirkan sistem keuangan terpadu untuk mendukung seluruh unit kerja.', 'en' => 'The Finance Directorate presents an integrated finance system to support every business unit.'],
            'cta_label' => ['id' => 'Pelajari Sistem RBA', 'en' => 'Learn about RBA'],
            'cta_url' => 'https://finance.telkomuniversity.ac.id/rba',
            'media_type' => 'video',
            'video_url' => 'https://www.youtube.com/embed/6ZcXzAJZciQ',
            'sort' => 1,
        ]);
        HeroSlide::create([
            'title' => ['id' => 'Sentral Layanan Dana Terintegrasi', 'en' => 'Integrated Fund Service Center'],
            'subtitle' => ['id' => 'Layanan satu pintu untuk sivitas', 'en' => 'One-stop service for the community'],
            'description' => ['id' => 'Helpdesk 24/7 memudahkan proses pengajuan dana, monitoring SPJ, serta konsultasi pajak.', 'en' => '24/7 helpdesk simplifies fund requests, SPJ monitoring, and tax consultation.'],
            'cta_label' => ['id' => 'Hubungi Helpdesk', 'en' => 'Contact Helpdesk'],
            'cta_url' => 'https://finance.telkomuniversity.ac.id/helpdesk',
            'media_type' => 'image',
            'media_path' => 'assets/images/telu1.webp',
            'sort' => 2,
        ]);
        HeroSlide::create([
            'title' => ['id' => 'Kemitraan Pembayaran Strategis', 'en' => 'Strategic Payment Partnerships'],
            'subtitle' => ['id' => 'Kolaborasi bank nasional Tel-U', 'en' => 'Collaboration with national banks'],
            'description' => ['id' => 'Integrasi virtual account, host-to-host, dan dashboard monitoring bersama Bank Mandiri, BNI, BJB, BSI, Finnet, serta Mitra Kasih Perkasa.', 'en' => 'Virtual accounts, host-to-host flows, and monitoring dashboards with Mandiri, BNI, BJB, BSI, Finnet, and Mitra Kasih Perkasa.'],
            'cta_label' => ['id' => 'Lihat Kemitraan', 'en' => 'View Partnerships'],
            'cta_url' => '#partners',
            'media_type' => 'image',
            'media_path' => 'assets/images/mandiri.jpg',
            'sort' => 3,
        ]);

        LeadershipMessage::query()->truncate();
        LeadershipMessage::create([
            'leader_name' => 'Dr. Maya Setyawati',
            'leader_title' => 'Direktur Keuangan Telkom University',
            'message' => [
                'id' => '<p>Kami berkomitmen menjaga keberlanjutan dan akuntabilitas pengelolaan keuangan Telkom University melalui proses yang terstandar serta layanan yang responsif.</p>',
                'en' => '<p>We are committed to sustaining accountable financial governance through standardized processes and responsive services.</p>',
            ],
        ]);

        Program::query()->truncate();
        Program::create([
            'name' => ['id' => 'Transformasi Digital Tata Kelola', 'en' => 'Governance Digital Transformation'],
            'summary' => ['id' => 'Implementasi dashboard keuangan real-time untuk pimpinan unit.', 'en' => 'Real-time finance dashboards for leaders.'],
            'body' => ['id' => '<p>Program ini menghadirkan platform analitik keuangan terpadu, memastikan seluruh keputusan didukung data aktual.</p>', 'en' => '<p>This program delivers an integrated finance analytics platform ensuring data-driven decision making.</p>'],
            'type' => 'program',
            'is_featured' => true,
            'icon' => 'heroicon-o-chart-bar',
        ]);
        Program::create([
            'name' => ['id' => 'Layanan Helpdesk Keuangan 24/7', 'en' => '24/7 Finance Helpdesk'],
            'summary' => ['id' => 'Pendampingan permintaan layanan dana, verifikasi SPJ, dan konsultasi pajak.', 'en' => 'Support for fund requests, SPJ verification, and tax consultation.'],
            'body' => ['id' => '<p>Layanan helpdesk menghadirkan kanal terpadu (email, telepon, live chat) untuk memastikan respon cepat.</p>', 'en' => '<p>The helpdesk provides unified channels (email, phone, live chat) for quick responses.</p>'],
            'type' => 'service',
            'icon' => 'heroicon-o-life-buoy',
        ]);
        Program::create([
            'name' => ['id' => 'Kebijakan Kepatuhan dan Audit Internal', 'en' => 'Compliance and Internal Audit Policy'],
            'summary' => ['id' => 'Menyusun kebijakan keuangan berbasis risk assessment serta monitoring audit internal.', 'en' => 'Develop risk-assessed financial policies with internal audit monitoring.'],
            'body' => ['id' => '<p>Kebijakan ini memastikan seluruh transaksi berjalan sesuai regulasi Telkom University dan standar nasional dengan dashboard monitoring kepatuhan.</p>', 'en' => '<p>This policy ensures all transactions align with Telkom University regulations and national standards with compliance dashboards.</p>'],
            'type' => 'policy',
            'icon' => 'heroicon-o-scale',
        ]);
        Program::create([
            'name' => ['id' => 'Highlight Kinerja Pengelolaan Kas', 'en' => 'Cash Management Performance Highlight'],
            'summary' => ['id' => 'Optimasi arus kas universitas melalui automasi rekonsiliasi bank.', 'en' => 'Optimise university cash flow through automated bank reconciliation.'],
            'body' => ['id' => '<p>Laporan highlight diterbitkan tiap kuartal untuk memberikan gambaran realisasi kas dan rekomendasi peningkatan likuiditas.</p>', 'en' => '<p>Quarterly highlights provide cash realisation overviews and recommendations to boost liquidity.</p>'],
            'type' => 'highlight',
            'icon' => 'heroicon-o-sparkles',
        ]);

        NewsCategory::query()->delete();

        $financeCategory = NewsCategory::query()->create([
            'name' => ['id' => 'Keuangan', 'en' => 'Finance'],
            'slug' => 'keuangan',
        ]);
        $governanceCategory = NewsCategory::query()->create([
            'name' => ['id' => 'Governansi', 'en' => 'Governance'],
            'slug' => 'governansi',
        ]);
        $serviceCategory = NewsCategory::query()->create([
            'name' => ['id' => 'Layanan', 'en' => 'Services'],
            'slug' => 'layanan',
        ]);

        NewsPost::query()->truncate();
        NewsPost::create([
            'news_category_id' => $financeCategory->id,
            'title' => ['id' => 'Direktorat Keuangan Luncurkan Dashboard RBA', 'en' => 'Finance Directorate Launches RBA Dashboard'],
            'excerpt' => ['id' => 'Dashboard memudahkan pemantauan realisasi anggaran unit Telkom University.', 'en' => 'The dashboard simplifies monitoring budget realization across units.'],
            'body' => ['id' => '<p>Dashboard RBA memberikan visibilitas menyeluruh terhadap progres anggaran, disertai indikator kinerja keuangan.</p>', 'en' => '<p>The RBA dashboard offers end-to-end visibility into budget progress with financial KPIs.</p>'],
            'status' => 'published',
            'published_at' => Carbon::now()->subDays(2),
            'author_name' => 'Humas Direktorat Keuangan',
        ]);
        NewsPost::create([
            'news_category_id' => $governanceCategory->id,
            'title' => ['id' => 'Workshop Tata Kelola Keuangan untuk Unit Akademik', 'en' => 'Financial Governance Workshop for Academic Units'],
            'excerpt' => ['id' => 'Lebih dari 120 peserta mengikuti workshop tata kelola dan kontrol internal.', 'en' => 'Over 120 participants joined the governance and internal control workshop.'],
            'body' => ['id' => '<p>Kegiatan ini memperkuat pemahaman SOP keuangan, audit internal, serta implementasi aplikasi persetujuan daring.</p>', 'en' => '<p>The session reinforced knowledge of financial SOPs, internal audit, and online approval systems.</p>'],
            'status' => 'published',
            'published_at' => Carbon::now()->subWeek(),
            'author_name' => 'Tim Governance DKU',
        ]);
        NewsPost::create([
            'news_category_id' => $serviceCategory->id,
            'title' => ['id' => 'Peluncuran Layanan Live Chat Keuangan', 'en' => 'Launch of Finance Live Chat Service'],
            'excerpt' => ['id' => 'Layanan live chat membantu percepatan penyelesaian isu pembayaran mahasiswa.', 'en' => 'Live chat service accelerates student payment issue resolution.'],
            'body' => ['id' => '<p>Layanan baru ini terkoneksi dengan knowledge base keuangan sehingga respons lebih akurat dan terdokumentasi.</p>', 'en' => '<p>The new service connects to a finance knowledge base delivering accurate, well-documented responses.</p>'],
            'status' => 'published',
            'published_at' => Carbon::now()->subDays(10),
            'author_name' => 'Customer Service Finance',
        ]);

        Announcement::query()->truncate();
        Announcement::create([
            'slug' => Str::slug('Penutupan Buku Semester Genap'),
            'title' => ['id' => 'Penutupan Buku Semester Genap', 'en' => 'Closing of Even Semester Books'],
            'body' => ['id' => '<p>Seluruh unit dimohon mengunggah SPJ maksimal 30 Juni 2025.</p>', 'en' => '<p>All units are requested to submit expense reports by 30 June 2025.</p>'],
            'cta_label' => ['id' => 'Unduh Jadwal', 'en' => 'Download Schedule'],
            'cta_url' => 'https://finance.telkomuniversity.ac.id/jadwal-penutupan',
            'status' => 'published',
            'type' => 'public',
            'starts_at' => Carbon::now()->subDays(5),
            'ends_at' => Carbon::now()->addDays(15),
            'published_at' => Carbon::now()->subDays(5),
        ]);
        Announcement::create([
            'slug' => Str::slug('Penyesuaian Jam Operasional Helpdesk Libur Nasional'),
            'title' => ['id' => 'Penyesuaian Jam Operasional Helpdesk Libur Nasional', 'en' => 'Helpdesk Operational Adjustment on National Holidays'],
            'body' => ['id' => '<p>Layanan helpdesk keuangan akan dialihkan ke kanal email pada 17 Agustus.</p>', 'en' => '<p>Finance helpdesk will be email-only on 17 August.</p>'],
            'cta_label' => ['id' => 'Lihat Detail', 'en' => 'See Details'],
            'cta_url' => 'https://finance.telkomuniversity.ac.id/helpdesk-jadwal',
            'status' => 'published',
            'type' => 'alert',
            'starts_at' => Carbon::now()->addDays(20),
            'ends_at' => Carbon::now()->addDays(22),
            'published_at' => Carbon::now(),
        ]);

        FinancialDocument::query()->truncate();
        FinancialDocument::create([
            'title' => ['id' => 'Laporan Keuangan Audited 2024', 'en' => 'Audited Financial Report 2024'],
            'description' => ['id' => 'Laporan lengkap hasil audit independen atas keuangan Telkom University Tahun 2024.', 'en' => 'Complete audited report for Telkom University FY 2024.'],
            'document_number' => 'DKU/LAK-AUD/2024',
            'category' => 'report',
            'year' => 2024,
            'published_at' => Carbon::now()->subMonths(2),
            'is_featured' => true,
        ]);
        FinancialDocument::create([
            'title' => ['id' => 'Rencana Bisnis dan Anggaran 2025', 'en' => 'Business and Budget Plan 2025'],
            'description' => ['id' => 'Rencana strategis dan proyeksi anggaran tahun berjalan.', 'en' => 'Strategic roadmap and budget projection for the upcoming year.'],
            'document_number' => 'DKU/RBA/2025',
            'category' => 'budget',
            'year' => 2025,
            'published_at' => Carbon::now()->subMonth(),
        ]);
        FinancialDocument::create([
            'title' => ['id' => 'SOP Pengelolaan Dana Hibah', 'en' => 'Grant Fund Management SOP'],
            'description' => ['id' => 'Standar operasional prosedur penyaluran dan pelaporan hibah.', 'en' => 'Operational standards for grant disbursement and reporting.'],
            'document_number' => 'DKU/SOP/2025-07',
            'category' => 'service_standard',
            'year' => 2025,
            'published_at' => Carbon::now()->subWeeks(3),
        ]);
        FinancialDocument::create([
            'title' => ['id' => 'Formulir Permohonan Pencairan Dana', 'en' => 'Fund Disbursement Request Form'],
            'description' => ['id' => 'Form standar pencairan dana kegiatan unit kerja beserta kelengkapan dokumen.', 'en' => 'Standard fund disbursement form for unit activities with required attachments.'],
            'document_number' => 'DKU/FRM/2025-01',
            'category' => 'form',
            'year' => 2025,
            'published_at' => Carbon::now()->subWeeks(2),
            'external_url' => 'https://finance.telkomuniversity.ac.id/form/formulir-permohonan-pencairan-dana.pdf',
        ]);
        FinancialDocument::create([
            'title' => ['id' => 'Formulir Pertanggungjawaban Dana (SPJ)', 'en' => 'Expense Accountability Form'],
            'description' => ['id' => 'Template pelaporan SPJ bulanan termasuk daftar bukti dan ringkasan realisasi.', 'en' => 'Monthly expense accountability template with supporting evidence checklist.'],
            'document_number' => 'DKU/FRM/2025-02',
            'category' => 'form',
            'year' => 2025,
            'published_at' => Carbon::now()->subWeek(),
            'external_url' => 'https://finance.telkomuniversity.ac.id/form/formulir-pertanggungjawaban-dana.pdf',
        ]);
        FinancialDocument::create([
            'title' => ['id' => 'Formulir Permintaan Layanan Helpdesk Keuangan', 'en' => 'Finance Helpdesk Service Request'],
            'description' => ['id' => 'Digunakan untuk eskalasi isu pembayaran, verifikasi SPJ, serta konsultasi pajak.', 'en' => 'Used to escalate payment issues, SPJ verification, and tax consultation support.'],
            'document_number' => 'DKU/FRM/2025-03',
            'category' => 'form',
            'year' => 2025,
            'published_at' => Carbon::now()->subDays(4),
            'external_url' => 'https://finance.telkomuniversity.ac.id/form/formulir-helpdesk-keuangan.pdf',
        ]);

        Faq::query()->truncate();
        Faq::create([
            'question' => ['id' => 'Bagaimana alur pengajuan dana kegiatan?', 'en' => 'How to request activity funding?'],
            'answer' => ['id' => '<p>Pengajuan dilakukan melalui SIM Keuangan dengan melampirkan RAB dan surat persetujuan pimpinan unit.</p>', 'en' => '<p>Submit via the Finance Information System attaching budget plan and unit approval letter.</p>'],
            'display_order' => 1,
        ]);
        Faq::create([
            'question' => ['id' => 'Kapan batas unggah SPJ setiap bulan?', 'en' => 'When is the monthly SPJ submission deadline?'],
            'answer' => ['id' => '<p>SPJ harus diunggah maksimal tanggal 5 bulan berikutnya melalui modul pelaporan SPJ.</p>', 'en' => '<p>Submit expense reports no later than the 5th of the following month via the SPJ reporting module.</p>'],
            'display_order' => 2,
        ]);
        Faq::create([
            'question' => ['id' => 'Apakah tersedia konsultasi pajak?', 'en' => 'Is tax consultation available?'],
            'answer' => ['id' => '<p>Ya, silakan jadwalkan sesi konsultasi melalui helpdesk atau email pajak@telkomuniversity.ac.id.</p>', 'en' => '<p>Yes, schedule a session via helpdesk or email pajak@telkomuniversity.ac.id.</p>'],
            'display_order' => 3,
        ]);

        ContactChannel::query()->truncate();
        ContactChannel::create([
            'name' => ['id' => 'Helpdesk Keuangan', 'en' => 'Finance Helpdesk'],
            'type' => 'hotline',
            'value' => '+62 811 1234 567',
            'notes' => ['id' => 'Tersedia setiap hari kerja 08.00 - 17.00 WIB', 'en' => 'Available on workdays 08.00 - 17.00 (GMT+7)'],
            'is_primary' => true,
        ]);
        ContactChannel::create([
            'name' => ['id' => 'Email Layanan Dana', 'en' => 'Fund Service Email'],
            'type' => 'email',
            'value' => 'layanan.dana@telkomuniversity.ac.id',
            'notes' => ['id' => 'Respons maksimal 1x24 jam kerja', 'en' => 'Response within 1 business day'],
        ]);
        ContactChannel::create([
            'name' => ['id' => 'WhatsApp Pengaduan Keuangan', 'en' => 'Finance Complaint WhatsApp'],
            'type' => 'whatsapp',
            'value' => '+62 811 9988 7766',
            'notes' => ['id' => 'Gunakan format: Nama - Unit - Permasalahan', 'en' => 'Use format: Name - Unit - Issue description'],
        ]);
    }
}
