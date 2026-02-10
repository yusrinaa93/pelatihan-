<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // Rename tables (app domain)
        // =========================
        $this->renameTableIfExists('schedules', 'jadwal');
        $this->renameTableIfExists('attendances', 'presensi');
        $this->renameTableIfExists('duties', 'tugas');
        $this->renameTableIfExists('duty_submissions', 'pengumpulan_tugas');
        $this->renameTableIfExists('exams', 'ujian');
        $this->renameTableIfExists('exam_results', 'hasil_ujian');
        $this->renameTableIfExists('questions', 'pertanyaan');
        $this->renameTableIfExists('options', 'opsi');
        $this->renameTableIfExists('certificates', 'sertifikat');

        // =========================
        // Rename columns (keep PK/FK names as-is for now)
        // =========================

        // pelatihan
        if (Schema::hasTable('pelatihan')) {
            $this->renameColumnIfExists('pelatihan', 'title', 'judul');
            $this->renameColumnIfExists('pelatihan', 'description', 'deskripsi');
            $this->renameColumnIfExists('pelatihan', 'image_path', 'path_gambar');
            $this->renameColumnIfExists('pelatihan', 'start_date', 'tanggal_mulai');
            $this->renameColumnIfExists('pelatihan', 'end_date', 'tanggal_selesai');
            $this->renameColumnIfExists('pelatihan', 'is_certificate_active', 'sertifikat_aktif');
        }

        // jadwal (was schedules)
        if (Schema::hasTable('jadwal')) {
            $this->renameColumnIfExists('jadwal', 'category', 'kategori');
            $this->renameColumnIfExists('jadwal', 'start_time', 'waktu_mulai');
            $this->renameColumnIfExists('jadwal', 'end_time', 'waktu_selesai');
            $this->renameColumnIfExists('jadwal', 'zoom_link', 'tautan_zoom');
            $this->renameColumnIfExists('jadwal', 'manual_presensi', 'presensi_manual');
            $this->renameColumnIfExists('jadwal', 'presensi_open', 'presensi_buka');
            $this->renameColumnIfExists('jadwal', 'presensi_close', 'presensi_tutup');
        }

        // tugas (was duties)
        if (Schema::hasTable('tugas')) {
            $this->renameColumnIfExists('tugas', 'name', 'nama');
            $this->renameColumnIfExists('tugas', 'description', 'deskripsi');
            $this->renameColumnIfExists('tugas', 'attachment_path', 'path_lampiran');
            $this->renameColumnIfExists('tugas', 'deadline', 'batas_waktu');
        }

        // pengumpulan_tugas (was duty_submissions)
        if (Schema::hasTable('pengumpulan_tugas')) {
            $this->renameColumnIfExists('pengumpulan_tugas', 'file_path', 'path_file');
            $this->renameColumnIfExists('pengumpulan_tugas', 'original_filename', 'nama_file_asli');
            $this->renameColumnIfExists('pengumpulan_tugas', 'score', 'nilai');
        }

        // ujian (was exams)
        if (Schema::hasTable('ujian')) {
            // NOTE: some DBs might have either name/duration_in_minutes/gform_link (old) or title/description/deadline (new)
            $this->renameColumnIfExists('ujian', 'name', 'nama');
            $this->renameColumnIfExists('ujian', 'duration_in_minutes', 'durasi_menit');
            $this->renameColumnIfExists('ujian', 'gform_link', 'tautan_gform');

            $this->renameColumnIfExists('ujian', 'title', 'judul');
            $this->renameColumnIfExists('ujian', 'description', 'deskripsi');
            $this->renameColumnIfExists('ujian', 'deadline', 'batas_waktu');
        }

        // hasil_ujian (was exam_results)
        if (Schema::hasTable('hasil_ujian')) {
            $this->renameColumnIfExists('hasil_ujian', 'score', 'nilai');
        }

        // pertanyaan (was questions)
        if (Schema::hasTable('pertanyaan')) {
            $this->renameColumnIfExists('pertanyaan', 'question_text', 'teks_pertanyaan');
        }

        // opsi (was options)
        if (Schema::hasTable('opsi')) {
            $this->renameColumnIfExists('opsi', 'option_text', 'teks_opsi');
            $this->renameColumnIfExists('opsi', 'is_correct', 'benar');
        }

        // sertifikat (was certificates)
        if (Schema::hasTable('sertifikat')) {
            $this->renameColumnIfExists('sertifikat', 'title', 'judul');
            $this->renameColumnIfExists('sertifikat', 'serial_number', 'nomor_sertifikat');
            $this->renameColumnIfExists('sertifikat', 'name_on_certificate', 'nama_di_sertifikat');
            $this->renameColumnIfExists('sertifikat', 'ttl_on_certificate', 'ttl_di_sertifikat');
            $this->renameColumnIfExists('sertifikat', 'phone_on_certificate', 'hp_di_sertifikat');
        }

        // pendaftaran_pelatihan
        if (Schema::hasTable('pendaftaran_pelatihan')) {
            $this->renameColumnIfExists('pendaftaran_pelatihan', 'is_lulus', 'lulus');
            $this->renameColumnIfExists('pendaftaran_pelatihan', 'keterangan', 'catatan');
        }
    }

    public function down(): void
    {
        // Reverse columns first (best-effort)
        if (Schema::hasTable('pelatihan')) {
            $this->renameColumnIfExists('pelatihan', 'judul', 'title');
            $this->renameColumnIfExists('pelatihan', 'deskripsi', 'description');
            $this->renameColumnIfExists('pelatihan', 'path_gambar', 'image_path');
            $this->renameColumnIfExists('pelatihan', 'tanggal_mulai', 'start_date');
            $this->renameColumnIfExists('pelatihan', 'tanggal_selesai', 'end_date');
            $this->renameColumnIfExists('pelatihan', 'sertifikat_aktif', 'is_certificate_active');
        }

        if (Schema::hasTable('jadwal')) {
            $this->renameColumnIfExists('jadwal', 'kategori', 'category');
            $this->renameColumnIfExists('jadwal', 'waktu_mulai', 'start_time');
            $this->renameColumnIfExists('jadwal', 'waktu_selesai', 'end_time');
            $this->renameColumnIfExists('jadwal', 'tautan_zoom', 'zoom_link');
            $this->renameColumnIfExists('jadwal', 'presensi_manual', 'manual_presensi');
            $this->renameColumnIfExists('jadwal', 'presensi_buka', 'presensi_open');
            $this->renameColumnIfExists('jadwal', 'presensi_tutup', 'presensi_close');
        }

        if (Schema::hasTable('tugas')) {
            $this->renameColumnIfExists('tugas', 'nama', 'name');
            $this->renameColumnIfExists('tugas', 'deskripsi', 'description');
            $this->renameColumnIfExists('tugas', 'path_lampiran', 'attachment_path');
            $this->renameColumnIfExists('tugas', 'batas_waktu', 'deadline');
        }

        if (Schema::hasTable('pengumpulan_tugas')) {
            $this->renameColumnIfExists('pengumpulan_tugas', 'path_file', 'file_path');
            $this->renameColumnIfExists('pengumpulan_tugas', 'nama_file_asli', 'original_filename');
            $this->renameColumnIfExists('pengumpulan_tugas', 'nilai', 'score');
        }

        if (Schema::hasTable('ujian')) {
            $this->renameColumnIfExists('ujian', 'nama', 'name');
            $this->renameColumnIfExists('ujian', 'durasi_menit', 'duration_in_minutes');
            $this->renameColumnIfExists('ujian', 'tautan_gform', 'gform_link');

            $this->renameColumnIfExists('ujian', 'judul', 'title');
            $this->renameColumnIfExists('ujian', 'deskripsi', 'description');
            $this->renameColumnIfExists('ujian', 'batas_waktu', 'deadline');
        }

        if (Schema::hasTable('hasil_ujian')) {
            $this->renameColumnIfExists('hasil_ujian', 'nilai', 'score');
        }

        if (Schema::hasTable('pertanyaan')) {
            $this->renameColumnIfExists('pertanyaan', 'teks_pertanyaan', 'question_text');
        }

        if (Schema::hasTable('opsi')) {
            $this->renameColumnIfExists('opsi', 'teks_opsi', 'option_text');
            $this->renameColumnIfExists('opsi', 'benar', 'is_correct');
        }

        if (Schema::hasTable('sertifikat')) {
            $this->renameColumnIfExists('sertifikat', 'judul', 'title');
            $this->renameColumnIfExists('sertifikat', 'nomor_sertifikat', 'serial_number');
            $this->renameColumnIfExists('sertifikat', 'nama_di_sertifikat', 'name_on_certificate');
            $this->renameColumnIfExists('sertifikat', 'ttl_di_sertifikat', 'ttl_on_certificate');
            $this->renameColumnIfExists('sertifikat', 'hp_di_sertifikat', 'phone_on_certificate');
        }

        if (Schema::hasTable('pendaftaran_pelatihan')) {
            $this->renameColumnIfExists('pendaftaran_pelatihan', 'lulus', 'is_lulus');
            $this->renameColumnIfExists('pendaftaran_pelatihan', 'catatan', 'keterangan');
        }

        // Reverse table renames
        $this->renameTableIfExists('jadwal', 'schedules');
        $this->renameTableIfExists('presensi', 'attendances');
        $this->renameTableIfExists('tugas', 'duties');
        $this->renameTableIfExists('pengumpulan_tugas', 'duty_submissions');
        $this->renameTableIfExists('ujian', 'exams');
        $this->renameTableIfExists('hasil_ujian', 'exam_results');
        $this->renameTableIfExists('pertanyaan', 'questions');
        $this->renameTableIfExists('opsi', 'options');
        $this->renameTableIfExists('sertifikat', 'certificates');
    }

    private function renameTableIfExists(string $from, string $to): void
    {
        if (Schema::hasTable($from) && ! Schema::hasTable($to)) {
            Schema::rename($from, $to);
        }
    }

    private function renameColumnIfExists(string $table, string $from, string $to): void
    {
        if (Schema::hasTable($table) && Schema::hasColumn($table, $from) && ! Schema::hasColumn($table, $to)) {
            Schema::table($table, function (Blueprint $tableBlueprint) use ($from, $to) {
                $tableBlueprint->renameColumn($from, $to);
            });
        }
    }
};
