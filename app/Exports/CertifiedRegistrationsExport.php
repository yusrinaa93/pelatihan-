<?php

namespace App\Exports;

use App\Models\Certificate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CertifiedRegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected ?int $courseId = null,
    ) {}

    public function collection(): Collection
    {
        return Certificate::query()
            ->with(['user', 'course'])
            ->when($this->courseId, fn ($q) => $q->where('course_id', $this->courseId))
            ->latest('certificates.created_at')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'NIK Pendamping',
            'Nama',
            'Tempat Lahir',
            'Tgl. Lahir (yyyy-MM-dd)',
            'Alamat',
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'KodePos',
            'No. HP',
            'Email',
            'Bank',
            'No. Rekening',
            'Nama Rekening',
        ];
    }

    /**
     * @param Certificate $row
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;

        $user = $row->user;

        return [
            $no,
            $user?->nik,
            $user?->name,
            $user?->tempat_lahir,
            optional($user?->tanggal_lahir)?->format('Y-m-d'),
            $user?->alamat,
            $user?->provinsi,
            $user?->kabupaten,
            $user?->kecamatan,
            $user?->kodepos,
            $user?->nomor_wa,
            $user?->email,
            $user?->bank_name,
            $user?->bank_account_number,
            $user?->bank_account_name,
        ];
    }
}
