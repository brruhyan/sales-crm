<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Leads;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Deal extends Model
{   
    use Notifiable, HasFactory, LogsActivity;
    
    protected $fillable = [
        'title',
        'description',
        'amount',
        'currency',
        'probability',
        'status',
        'source',
        'expected_close_date',
        'actual_close_date',
        'contact_id',
        'lead_id',
        'user_id',
        'documents',
        'won_documents',
        'dispute_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',  
        'documents' => 'array',
        'won_documents' => 'array',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function closings(): HasMany
    {
        return $this->hasMany(Closing::class);
    }

    /**
     * Get the partner/company through contact relationship.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'company', 'id');
    }

    /**
     * Scope to get only closed deals.
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['Closed Won', 'Closed Lost']);
    }

    /**
     * Scope to get only won deals.
     */
    public function scopeWon($query)
    {
        return $query->where('status', 'Closed Won');
    }

    /**
     * Scope to get only lost deals.
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'Closed Lost');
    }

    /**
     * Scope to get active (not closed) deals.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['Closed Won', 'Closed Lost']);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Leads::class, 'lead_id');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('deals')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Deal '{$this->title}' created",
                'updated' => $this->getUpdatedDescription(),
                'deleted' => "Deal '{$this->title}' deleted",
                default => "Deal has been {$eventName}"
            });
    }

    private function getUpdatedDescription(): string
    {
        $status = $this->getAttribute('status');
        $title = $this->getAttribute('title');
        
        $original = $this->getOriginal();
        $changes = $this->getChanges();
        
        if (isset($changes['status']) && isset($original['status'])) {
            $oldStatus = $original['status'];
            $newStatus = $status ?? $changes['status'];
            return "Deal '{$title}' status changed from {$oldStatus} to {$newStatus}";
        }
        
        if (isset($changes['title'])) {
            $newTitle = $title ?? $changes['title'];
            return "Deal title changed to '{$newTitle}'";
        }
        
        return "Deal '{$title}' updated";
    }
}
