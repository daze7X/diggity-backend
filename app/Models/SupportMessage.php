<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function supportTicket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($message) {
            $ticket = $message->ticket;
            if (!$ticket) return;

            // Load relations
            $message->load(['ticket.user', 'user']);

            // Jika pengirim pesan BUKAN pemilik tiket (berarti Admin/Staff yang membalas)
            if ($message->user_id !== $ticket->user_id) {
                if ($ticket->user && $ticket->user->email) {
                    try {
                        \Mail::to($ticket->user->email)->send(new \App\Mail\SupportTicketRepliedMail($message));
                    } catch (\Exception $e) {
                        \Log::error('Gagal mengirim email balasan tiket ke klien: ' . $e->getMessage());
                    }
                }
            } else {
                // Jika pengirim pesan ADALAH pemilik tiket (klien mengirim/membalas tiket)
                $settings = \App\Models\CompanySetting::first();
                $adminEmail = $settings?->email ?? 'hrd@diggity.com';
                try {
                    \Mail::to($adminEmail)->send(new \App\Mail\SupportTicketRepliedMail($message));
                } catch (\Exception $e) {
                    \Log::error('Gagal mengirim email notifikasi tiket ke admin: ' . $e->getMessage());
                }
            }
        });
    }
}
