<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Closing extends Model
{
    use Notifiable, HasFactory, LogsActivity;

    protected $fillable = [
        'deal_id',
        'title',
        'description',
        'status',
        'expected_close_date',
        'actual_close_date',
        'contact_id',
        'amount',
        'currency',
        'probability',
        'user_id',
        'documents',
        'notes',
        'dispute_reason',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->user_id) {
                $model->user_id = auth()->id();
            }
        });
    }

    protected $casts = [
        'amount' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
        'documents' => 'array',
        'currency' => 'string',
    ];

    protected $attributes = [
        'currency' => 'USD',
        'probability' => 0,
    ];

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only closed closings.
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['Closed Won', 'Closed Lost']);
    }

    /**
     * Scope to get only won closings.
     */
    public function scopeWon($query)
    {
        return $query->where('status', 'Closed Won');
    }

    /**
     * Scope to get only lost closings.
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'Closed Lost');
    }

    /**
     * Scope to get active (not closed) closings.
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['Closed Won', 'Closed Lost']);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('closings')
            ->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Closing '{$this->title}' created",
                'updated' => $this->getUpdatedDescription(),
                'deleted' => "Closing '{$this->title}' deleted",
                default => "Closing has been {$eventName}"
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
            return "Closing '{$title}' status changed from {$oldStatus} to {$newStatus}";
        }

        if (isset($changes['title'])) {
            $newTitle = $title ?? $changes['title'];
            return "Closing title changed to '{$newTitle}'";
        }

        return "Closing '{$title}' updated";
    }
}
