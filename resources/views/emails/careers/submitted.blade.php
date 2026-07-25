<x-mail::message>
# Halo Tim HRD,

Ada lamaran pekerjaan baru yang dikirimkan melalui website Company Profile Diggity. Berikut rincian pelamar:

* **Nama Pelamar:** {{ $application->name }}
* **Email:** {{ $application->email }}
* **No. WhatsApp:** {{ $application->phone }}
* **Posisi Dilamar:** {{ $application->career?->title ?? '-' }} ({{ $application->career?->department ?? '-' }})

@if($application->cover_letter)
**Surat Pengantar / Cover Letter:**
{{ $application->cover_letter }}
@endif

Berkas CV/Resume pelamar telah dilampirkan bersama email ini. Silakan segera lakukan peninjauan berkas.

Salam hangat,<br>
Sistem Otomatisasi {{ config('app.name') }}
</x-mail::message>
