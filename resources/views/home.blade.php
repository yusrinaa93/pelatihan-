@php($activeNav = 'home')
@extends('layouts.public')

@section('title', 'Pelatihan Pendamping Penyelia Halal')

@section('content')
<section class="relative flex min-h-[88vh] items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto-format&fit=crop&q=80&w=2070');">
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
        <h1 class="mb-4 text-4xl font-bold leading-tight sm:text-5xl md:text-6xl">
            Pelatihan PPH - Batch 1
        </h1>
        <p class="mb-8 text-lg leading-relaxed text-white/90 sm:text-xl">
            Ini adalah deskripsi mengenai pelatihan PPH pada dengan Desmber tanggal 21.<br>Pelatihan ini bersifat online.
        </p>
        
        <a href="{{ route('courses') }}" 
           class="inline-block rounded-full border-2 border-emerald-600 bg-emerald-600 px-8 py-4 text-base font-semibold text-white transition hover:bg-emerald-700">
            START COURSE
        </a>
    </div>
</section>

<section class="bg-[#F7F9F7] py-16">
    <div class="mx-auto w-full max-w-6xl px-4">
        <div class="mb-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            
            {{-- KARTU ADDRESS (Diubah jadi <a> tag, href="#map-section") --}}
            <a href="#map-section">
                <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg h-full">
                    <i class="fas fa-map-marker-alt mb-4 text-3xl" style="color: #16A05D;"></i>
                    <h3 class="mb-2 text-lg font-semibold text-gray-800">Address</h3>
                    <p class="text-sm text-gray-600">
                        Papringan, Caturtunggal, Depok, Sleman, DIY 55281
                    </p>
                </div>
            </a>
            
            {{-- KARTU CONTACT (Diubah jadi <a> tag, href ke WhatsApp) --}}
            {{-- Nomor (0274) 123-4567 saya ubah ke format 622741234567 --}}
            <a href="https://wa.me/622741234567" target="_blank">
                <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg h-full">
                    <i class="fas fa-phone-alt mb-4 text-3xl" style="color: #16A05D;"></i>
                    <h3 class="mb-2 text-lg font-semibold text-gray-800">Contact</h3>
                    <p class="text-sm text-gray-600">
                        (0274) 123-4567
                    </p>
                </div>
            </a>
            
            {{-- KARTU EMAIL (Diubah jadi <a> tag, href ke mailto:) --}}
            <a href="mailto:kontak@pelatihanhalal.com">
                <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg h-full">
                    <i class="fas fa-envelope mb-4 text-3xl" style="color: #16A05D;"></i>
                    <h3 class="mb-2 text-lg font-semibold text-gray-800">Email</h3>
                    <p class="text-sm text-gray-600">
                        kontak@pelatihanhalal.com
                    </p>
                </div>
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            
            {{-- DIV PETA (Diberi id="map-section" dan scroll-mt) --}}
            {{-- scroll-mt-[96px] agar tidak tertutup header sticky (h-16 + py-4 = 64 + 32 = 96px) --}}
            <div id="map-section" class="rounded-xl border border-gray-200 bg-white p-4 shadow-md lg:col-span-2 scroll-mt-[96px]">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.153922633913!2d110.4085446152796!3d-7.773539094396001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599a2c3a0b8f%3A0x2ed9b2e91a33a57!2sUIN%20Sunan%20Kalijaga%20Yogyakarta!5e0!3m2!1sen!2sid!4v1672833139363!5m2!1sen!2sid" 
                    width="100%" 
                    height="440" 
                    style="border:0; border-radius: 8px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            {{-- Formulir Anda (Dihapus dari kode Anda, tapi saya biarkan di sini jika Anda masih memerlukannya) --}}
            {{-- <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-md"> ... Formulir ... </div> --}}
        </div>
    </div>
</section>
@endsection