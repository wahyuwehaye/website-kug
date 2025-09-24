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

class InitialContentSeeder extends Seeder
{
    public function run(): void
    {
        $setting = SiteSetting::query()->firstOrCreate([], [
            'name' => ['id' => 'Direktorat Keuangan', 'en' => 'Finance Directorate'],
            'tagline' => ['id' => 'Transparan, Akuntabel, dan Lincah', 'en' => 'Transparent, Accountable, and Agile'],
            'short_description' => ['id' => 'Direktorat Keuangan Telkom University memastikan tata kelola keuangan yang efektif dan berkelanjutan.', 'en' => 'Telkom University Finance Directorate ensures effective and sustainable financial governance.'],
            'vision' => ['id' => 'Menjadi pengelola keuangan perguruan tinggi terbaik berkelas dunia.', 'en' => 'To become a world-class university finance manager.'],
            'mission' => ['id' => 'Mengelola anggaran dan layanan keuangan secara inovatif, transparan, dan akuntabel.', 'en' => 'Manage budgeting and financial services in an innovative, transparent, and accountable manner.'],
            'about' => ['id' => '<p>Direktorat Keuangan bertanggung jawab memastikan pengelolaan keuangan Telkom University berjalan sesuai prinsip tata kelola yang baik dengan dukungan proses digital dan layanan prima.</p>', 'en' => '<p>The Finance Directorate ensures Telkom University finance management runs according to good governance principles supported by digital processes and excellent services.</p>'],
            'address' => ['id' => 'Gedung Bangkit Lantai 3, Telkom University, Bandung', 'en' => 'Bangkit Building 3rd Floor, Telkom University, Bandung'],
            'meta_description' => ['id' => 'Informasi program, layanan, dan laporan keuangan Direktorat Keuangan Telkom University.', 'en' => 'Programs, services, and financial reports of Telkom University Finance Directorate.'],
            'meta_keywords' => ['id' => 'direktorat keuangan, telkom university, anggaran, layanan keuangan', 'en' => 'finance directorate, telkom university, budget, financial services'],
            'email' => 'finance@telkomuniversity.ac.id',
            'phone' => '+62 22 7564 108',
            'whatsapp' => '+62 813 0000 1234',
            'hotline' => '0800-123-456',
            'office_hours' => 'Senin - Jumat, 08.00 - 16.00 WIB',
            'feedback_url' => 'https://forms.gle/finance-feedback',
            'facebook_url' => 'https://facebook.com/telkomuniversity',
            'instagram_url' => 'https://instagram.com/finance.telu',
            'linkedin_url' => 'https://linkedin.com/school/telkom-university',
            'youtube_url' => 'https://youtube.com/telkomuniversity',
            'sso_login_url' => 'https://login.telkomuniversity.ac.id',
            'map_embed' => <<<'HTML'
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.4089405329926!2d107.6318364750023!3d-7.040149369130789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e99027d06155%3A0xd7217aa1e69a8b4!2sTelkom%20University!5e0!3m2!1sen!2sid!4v1732990800000!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="h-full w-full"></iframe>
HTML,
        ]);

        // Navigation
        NavigationLink::query()->delete();

        $topLinks = [
            ['title' => ['id' => 'IT Support', 'en' => 'IT Support'], 'url' => 'https://helpdesk.telkomuniversity.ac.id', 'location' => 'top'],
            ['title' => ['id' => 'Portal SSO', 'en' => 'SSO Portal'], 'url' => $setting->sso_login_url, 'location' => 'top', 'is_external' => true],
            ['title' => ['id' => 'Publikasi', 'en' => 'Publication'], 'url' => '#news', 'location' => 'top'],
        ];
        foreach ($topLinks as $index => $link) {
            NavigationLink::create(array_merge($link, ['sort' => $index]));
        }

        $mainMenu = [
            [
                'title' => ['id' => 'Profil', 'en' => 'Profile'],
                'url' => '#profile',
                'location' => 'main',
                'children' => [
                    ['title' => ['id' => 'Tentang Direktorat', 'en' => 'About Directorate'], 'url' => '#about'],
                    ['title' => ['id' => 'Struktur Organisasi', 'en' => 'Organization Structure'], 'url' => '#about'],
                    ['title' => ['id' => 'Contact Center', 'en' => 'Contact Center'], 'url' => '/contact'],
                ],
            ],
            [
                'title' => ['id' => 'Program', 'en' => 'Programs'],
                'url' => '/programs',
                'location' => 'main',
                'children' => [
                    ['title' => ['id' => 'Transformasi Digital', 'en' => 'Digital Transformation'], 'url' => '/programs?type=program'],
                    ['title' => ['id' => 'Layanan Keuangan', 'en' => 'Financial Services'], 'url' => '/programs?type=service'],
                ],
            ],
            [
                'title' => ['id' => 'Dokumen', 'en' => 'Documents'],
                'url' => '#documents',
                'location' => 'main',
            ],
            [
                'title' => ['id' => 'Berita', 'en' => 'News'],
                'url' => '/news',
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
            ['title' => ['id' => 'Dokumen Standar', 'en' => 'Standard Documents'], 'url' => '/documents', 'location' => 'footer'],
            ['title' => ['id' => 'Kebijakan Keuangan', 'en' => 'Financial Policies'], 'url' => '/documents?category=policy', 'location' => 'footer'],
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
            'media_path' => null,
            'sort' => 2,
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
