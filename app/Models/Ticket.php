<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'service',
        'ticket_number',
        'customer_id',
        'report_date',
        'status',
        'pending_clock',
        'closed_date',
        'problem_summary',
        'extra_description',
        'title',
        'description',
        'sla_id',
        'evidance_path',
        'created_by',  // Pastikan created_by diisi dengan ID user yang sedang login


    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sla()
    {
        return $this->belongsTo(SLA::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $lastTicket = self::orderBy('id', 'desc')->first();
            $ticket->no = $lastTicket ? $lastTicket->no + 1 : 1;
            $ticket->ticket_number = 'TFTTH-' . strtoupper(uniqid());
            $ticket->created_by = \Illuminate\Support\Facades\Auth::id();
        });

        static::updating(function ($ticket) {
            if ($ticket->isDirty('status')) {
                if ($ticket->status === 'PENDING') {
                    $ticket->pending_clock = now();
                } elseif ($ticket->status === 'CLOSED') {
                    $ticket->closed_date = now();
                }
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke User (Created By)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function getPendingClockAttribute($value)
    {
        return $value ?? 'Belum ada Pending';
    }

    public function getClosedDateAttribute($value)
    {
        return $value ?? 'Belum ada Ticket Closed';
    }
}