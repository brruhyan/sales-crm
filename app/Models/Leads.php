<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
class Leads extends Model
{   
    use SoftDeletes, Notifiable, HasFactory;

    use LogsActivity;

    protected $fillable = [
        'lead_title',
        'tag',
        'lead_type',
        'user_id',
        'product',
        'contact_id',
        'name',
        'email',
        'phone',
        'company',
        'source',
        'status',
        'documents',
        'qualified_documents',
        'dispute_reason',
    ];

    protected $casts = [
        'documents' => 'array',
        'qualified_documents' => 'array',
        'product' => 'array',
    ];

    /**
     * Get the user who owns this lead.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contact associated with this lead.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the partner/company for this lead.
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'company', 'id');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('leads')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Lead '{$this->lead_title}' created",
                'updated' => $this->getUpdatedDescription(),
                'deleted' => "Lead '{$this->lead_title}' deleted",
                default => "Lead has been {$eventName}"
            });
    }

    private function getUpdatedDescription(): string
    {
        // Get the current state (after changes)
        $status = $this->getAttribute('status');
        $title = $this->getAttribute('lead_title');
        
        // Check if status changed by looking at original values
        $original = $this->getOriginal();
        $changes = $this->getChanges();
        
        if (isset($changes['status']) && isset($original['status'])) {
            $oldStatus = $original['status'];
            $newStatus = $status ?? $changes['status'];
            return "Lead '{$title}' status changed from {$oldStatus} to {$newStatus}";
        }
        
        if (isset($changes['lead_title'])) {
            $newTitle = $title ?? $changes['lead_title'];
            return "Lead title changed to '{$newTitle}'";
        }
        
        return "Lead '{$title}' updated";
    }
}
