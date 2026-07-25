<x-mail::message>
# Halo Tim Sales,

Ada pengajuan konsultasi baru dari website Company Profile Diggity. Berikut rincian datanya:

* **Nama Lengkap:** {{ $lead->name }}
* **Email Bisnis:** {{ $lead->email }}
* **No. WhatsApp:** {{ $lead->phone }}
* **Perusahaan:** {{ $lead->company ?? '-' }}
* **Layanan:** {{ $lead->service ?? '-' }}

**Detail Kebutuhan Proyek:**
{{ $lead->message }}

Silakan segera hubungi prospek di atas untuk ditindaklanjuti.

Salam hangat,<br>
Sistem Otomatisasi {{ config('app.name') }}
</x-mail::message>
