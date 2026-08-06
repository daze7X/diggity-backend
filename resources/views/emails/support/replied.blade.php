<x-mail::message>
# Halo {{ $supportMessage->supportTicket->user->name }},

Ada balasan baru untuk tiket bantuan Anda **#{{ $supportMessage->supportTicket->ticket_number }}**.

## Subjek: {{ $supportMessage->supportTicket->subject }}
**Kategori:** {{ ucfirst($supportMessage->supportTicket->category) }}

<x-mail::panel>
**Pesan Balasan:**
{{ $supportMessage->message }}
</x-mail::panel>

Anda dapat memantau dan membalas kembali tiket ini langsung melalui dashboard client Diggity.

<x-mail::button :url="config('app.url') . '/dashboard/support/' . $supportMessage->supportTicket->id">
Lihat Tiket Bantuan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }} Support Team
</x-mail::message>
