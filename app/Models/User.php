<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Ditambahkan agar bisa diisi saat membuat user admin
        'avatar_path',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_wa',
        'alamat',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mengatur tipe data atribut secara otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Memastikan is_admin selalu true/false
        ];
    }
    public function certificates()
    {   
    // Asumsi 1 user bisa punya banyak sertifikat
        return $this->hasMany(Certificate::class);
    }
    /**
     * Fungsi yang dibutuhkan oleh Filament untuk memeriksa
     * apakah seorang pengguna boleh mengakses panel admin.
     *
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan akses hanya jika pengguna memiliki is_admin = true.
        // (bool) memastikan nilai NULL atau 0 akan menjadi false.
        return (bool) $this->is_admin;
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return Storage::disk('public')->url($this->avatar_path);
        }

        $name = trim($this->name) !== '' ? $this->name : 'User';
        $initial = Str::upper(Str::substr($name, 0, 1));

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">
    <rect width="128" height="128" rx="64" fill="#059669"/>
    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="central"
          font-family="Inter, Arial, sans-serif" font-size="64" fill="#ffffff">{$initial}</text>
</svg>
SVG;

        $encodedSvg = base64_encode($svg);

        return "data:image/svg+xml;base64,{$encodedSvg}";
    }
}