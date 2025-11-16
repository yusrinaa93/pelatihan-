@php($activeNav = 'home')
@extends('layouts.public')

@section('title', 'Pelatihan Pendamping Penyelia Halal')

@section('content')
<!-- Hero Section -->
<section class="relative flex min-h-[88vh] items-center justify-center bg-cover bg-center bg-no-repeat" style="background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&q=80&w=2070');">
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
        <h1 class="mb-4 text-4xl font-bold leading-tight sm:text-5xl md:text-6xl">
            Pelatihan PPH - Batch 1
        </h1>
        <p class="mb-8 text-lg leading-relaxed text-white/90 sm:text-xl">
            Ini adalah deskripsi mengenai pelatihan PPH pada dengan Desmber tanggal 21.<br>Pelatihan ini bersifat online.
        </p>
        <a href="{{ route('courses') }}" 
           class="inline-block rounded-lg border-2 border-[#16A05D] bg-[#16A05D] px-8 py-4 text-base font-semibold text-white transition hover:bg-[#128a4f]">
            START COURSE
        </a>
    </div>
</section>

<!-- Contact Section -->
<section class="bg-[#F7F9F7] py-16">
    <div class="mx-auto w-full max-w-6xl px-4">
        <!-- Contact Info Cards -->
        <div class="mb-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg">
                <i class="fas fa-map-marker-alt mb-4 text-3xl" style="color: #16A05D;"></i>
                <h3 class="mb-2 text-lg font-semibold text-gray-800">Address</h3>
                <p class="text-sm text-gray-600">
                    Papringan, Caturtunggal, Depok, Sleman, DIY 55281
                </p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg">
                <i class="fas fa-phone-alt mb-4 text-3xl" style="color: #16A05D;"></i>
                <h3 class="mb-2 text-lg font-semibold text-gray-800">Contact</h3>
                <p class="text-sm text-gray-600">
                    (0274) 123-4567
                </p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-center shadow-md transition hover:shadow-lg">
                <i class="fas fa-envelope mb-4 text-3xl" style="color: #16A05D;"></i>
                <h3 class="mb-2 text-lg font-semibold text-gray-800">Email</h3>
                <p class="text-sm text-gray-600">
                    kontak@pelatihanhalal.com
                </p>
            </div>
        </div>

        <!-- Map and Form -->
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Map -->
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-md">
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

            <!-- Contact Form -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-md">
                <form action="#" method="post" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-gray-700">Your Name *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               placeholder="Name" 
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-[#16A05D] focus:outline-none focus:ring-2 focus:ring-[#16A05D]/20">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               placeholder="Email" 
                               required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-[#16A05D] focus:outline-none focus:ring-2 focus:ring-[#16A05D]/20">
                    </div>
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold text-gray-700">Phone Number</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               placeholder="Phone"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-[#16A05D] focus:outline-none focus:ring-2 focus:ring-[#16A05D]/20">
                    </div>
                    <div>
                        <label for="message" class="mb-2 block text-sm font-semibold text-gray-700">Description *</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4" 
                                  placeholder="Message" 
                                  required
                                  class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-[#16A05D] focus:outline-none focus:ring-2 focus:ring-[#16A05D]/20"></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full rounded-lg bg-[#16A05D] px-6 py-3 text-base font-semibold text-white transition hover:bg-[#128a4f]">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection