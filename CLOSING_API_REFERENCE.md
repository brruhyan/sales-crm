# Closing Resource - Developer API Reference

## Table of Contents
1. [Model Methods](#model-methods)
2. [Relationships](#relationships)
3. [Scopes](#scopes)
4. [Events](#events)
5. [Factory](#factory)
6. [Route Bindings](#route-bindings)

---

## Model Methods

### Creating a Closing

```php
// Direct creation
$closing = Closing::create([
    'deal_id' => $deal->id,
    'contact_id' => $contact->id,
    'user_id' => auth()->id(),
    'title' => 'Closing of ' . $deal->title,
    'description' => 'Description text',
    'status' => 'Open',
    'amount' => 50000,
    'currency' => 'USD',
    'probability' => 75,
    'expected_close_date' => now()->addMonths(1),
    'documents' => null,
    'notes' => 'Internal notes',
]);

// Using Model::make() and save()
$closing = new Closing();
$closing->deal_id = $deal->id;
$closing->contact_id = $contact->id;
$closing->user_id = auth()->id();
$closing->title = 'Closing Title';
$closing->status = 'Open';
$closing->save();

// Using updateOrCreate
$closing = Closing::updateOrCreate(
    ['id' => $closingId],
    ['status' => 'Closed Won', 'actual_close_date' => now()]
);
```

### Updating a Closing

```php
// Update single field
$closing->update(['status' => 'In Progress']);

// Update multiple fields
$closing->update([
    'status' => 'Closed Won',
    'actual_close_date' => now(),
    'probability' => 100,
]);

// Using fill() without save
$closing->fill(['status' => 'Closed Lost'])->save();

// Direct assignment
$closing->status = 'Pending Documentation';
$closing->save();
```

### Retrieving Closings

```php
// Get all
$closings = Closing::all();

// Get by ID
$closing = Closing::find($id);
$closing = Closing::findOrFail($id);

// First record
$closing = Closing::first();

// Pagination
$closings = Closing::paginate(15);

// With relationships
$closings = Closing::with('deal', 'contact', 'user')->get();

// Using chunks (for large datasets)
Closing::chunk(100, function ($closings) {
    foreach ($closings as $closing) {
        // Process $closing
    }
});
```

### Deleting a Closing

```php
// Delete single record
$closing->delete();

// Delete multiple
Closing::whereIn('id', $ids)->delete();

// Delete by status
Closing::where('status', 'Closed Lost')->delete();

// Force delete (if soft deletes added later)
$closing->forceDelete();

// Restore (if soft deletes added later)
$closing->restore();
```

---

## Relationships

### Access Related Models

```php
// Get the associated deal
$deal = $closing->deal;
$dealTitle = $closing->deal->title;

// Get the contact
$contact = $closing->contact;
$contactName = $closing->contact->name;

// Get the user
$user = $closing->user;
$userName = $closing->user->name;

// Get activities (activity log)
$activities = $closing->activities;
```

### Eager Loading

```php
// Load relationships
$closings = Closing::with('deal', 'contact', 'user')->get();

// Lazy eager loading
$closings = Closing::all();
$closings->load('deal', 'contact');

// Load specific relationship
$closing = Closing::with('deal')->find($id);

// Load relationships on collection
$closings = Closing::where('status', 'Open')->get();
$closings->loadMissing('deal');
```

### Relationship Queries

```php
// Find closings for a specific deal
$closings = $deal->closings;

// Filter closings by deal
$closings = Closing::whereHas('deal', function ($query) {
    $query->where('title', 'like', '%Implementation%');
})->get();

// Find closings with specific contact
$closings = Closing::where('contact_id', $contactId)->get();

// Get closings created by user
$closings = Closing::where('user_id', $userId)->get();
```

---

## Scopes

### Built-in Scopes

```php
// Get closed closings (status: Closed Won or Closed Lost)
$closed = Closing::closed()->get();

// Get won closings
$won = Closing::won()->get();

// Get lost closings
$lost = Closing::lost()->get();

// Get active closings (not closed)
$active = Closing::active()->get();

// Combine scopes
$recentWon = Closing::won()
    ->where('actual_close_date', '>=', now()->subMonths(3))
    ->get();

// Filter by user and scope
$userWon = Closing::where('user_id', auth()->id())
    ->won()
    ->get();
```

### Custom Scopes (Examples)

```php
// Add these as methods to the Closing model

// Scope by date range
public function scopeDateRange($query, $startDate, $endDate)
{
    return $query->whereBetween('expected_close_date', [$startDate, $endDate]);
}

// Usage:
$closings = Closing::dateRange(now(), now()->addMonths(1))->get();

// Scope by status array
public function scopeByStatus($query, $statuses)
{
    return $query->whereIn('status', (array) $statuses);
}

// Usage:
$closings = Closing::byStatus(['Open', 'In Progress'])->get();

// Scope by probability minimum
public function scopeMinProbability($query, $probability)
{
    return $query->where('probability', '>=', $probability);
}

// Usage:
$closings = Closing::minProbability(50)->get();
```

---

## Events

### Model Events

```php
// Available events
// - retrieved, creating, created, updating, updated
// - saving, saved, deleting, deleted, restoring, restored

// Listen to create event
Closing::creating(function ($closing) {
    // Before closing is created
    $closing->user_id = auth()->id();
});

Closing::created(function ($closing) {
    // After closing is created
    // Send notification
    $closing->user->notify(new ClosingCreatedNotification($closing));
});

// Listen to update event
Closing::updating(function ($closing) {
    if ($closing->isDirty('status')) {
        // Status was changed
        $oldStatus = $closing->getOriginal('status');
        $newStatus = $closing->status;
    }
});

Closing::updated(function ($closing) {
    // After update
    if ($closing->isDirty('status')) {
        // Send status change notification
    }
});

// Listen to delete event
Closing::deleted(function ($closing) {
    // After deletion
    // Log deletion
});
```

### Dispatch Custom Events

```php
// In AppServiceProvider or EventServiceProvider boot method
Event::listen('closing.created', function ($closing) {
    // Handle event
});

// Dispatch event
event(new ClosingCreated($closing));
```

---

## Factory

### Create Test Data

```php
// Create single closing
$closing = Closing::factory()->create();

// Create multiple
$closings = Closing::factory(5)->create();

// With specific deal
$closing = Closing::factory()
    ->for(Deal::factory())
    ->create();

// With specific contact and user
$closing = Closing::factory()
    ->for(Deal::factory())
    ->for(Contact::factory())
    ->for(User::factory())
    ->create();

// With specific attributes
$closing = Closing::factory()
    ->state([
        'status' => 'Closed Won',
        'probability' => 100,
    ])
    ->create();

// With custom attributes
$closing = Closing::factory()
    ->create([
        'title' => 'Custom Closing Title',
        'amount' => 100000,
    ]);

// Using afterCreating callback
$closing = Closing::factory()
    ->afterCreating(function ($closing) {
        // Do something after creation
    })
    ->create();
```

### Factory States

```php
// Extend factory with states (add to ClosingFactory.php)

public function won()
{
    return $this->state([
        'status' => 'Closed Won',
        'actual_close_date' => now(),
        'probability' => 100,
    ]);
}

public function lost()
{
    return $this->state([
        'status' => 'Closed Lost',
        'actual_close_date' => now(),
        'probability' => 0,
    ]);
}

public function pending()
{
    return $this->state([
        'status' => 'Pending Documentation',
        'probability' => 50,
    ]);
}

// Usage:
$wonClosing = Closing::factory()->won()->create();
$lostClosing = Closing::factory()->lost()->create();
```

---

## Route Bindings

### Resource Routes

```php
// Routes are automatically generated:
GET  /closings              # Index (ListClosings)
POST /closings              # Store
GET  /closings/create       # Create form
GET  /closings/{record}     # Show (ViewClosing)
GET  /closings/{record}/edit # Edit form
PUT  /closings/{record}     # Update
DELETE /closings/{record}   # Delete
```

### Accessing Routes

```php
// In blade templates
<a href="{{ route('filament.app.resources.closings.index') }}">All Closings</a>

<a href="{{ route('filament.app.resources.closings.create') }}">Create Closing</a>

<a href="{{ route('filament.app.resources.closings.view', $closing) }}">View Closing</a>

<a href="{{ route('filament.app.resources.closings.edit', $closing) }}">Edit Closing</a>

// In controllers
return redirect()->route('filament.app.resources.closings.index');
```

---

## Query Examples

### Complex Queries

```php
// Get all active closings for current user with deal info
$closings = Closing::where('user_id', auth()->id())
    ->active()
    ->with('deal')
    ->orderBy('expected_close_date')
    ->get();

// Find closings due this month
$dueThisMonth = Closing::whereMonth('expected_close_date', now()->month)
    ->whereYear('expected_close_date', now()->year)
    ->where('user_id', auth()->id())
    ->get();

// Closings with high probability of winning
$likelyClosed = Closing::where('probability', '>=', 75)
    ->where('status', 'In Progress')
    ->get();

// Total value of active closings
$totalValue = Closing::active()
    ->where('user_id', auth()->id())
    ->sum('amount');

// Average probability by status
$avgByStatus = Closing::where('user_id', auth()->id())
    ->groupBy('status')
    ->selectRaw('status, AVG(probability) as avg_probability')
    ->get();

// Get latest 10 closings
$recent = Closing::where('user_id', auth()->id())
    ->orderByDesc('created_at')
    ->limit(10)
    ->get();

// Search closings
$results = Closing::where('title', 'like', "%{$search}%")
    ->orWhere('description', 'like', "%{$search}%")
    ->where('user_id', auth()->id())
    ->get();
```

---

## Mass Operations

```php
// Update multiple records
Closing::where('status', 'Open')
    ->where('user_id', auth()->id())
    ->update(['status' => 'In Progress']);

// Delete multiple
Closing::where('probability', '<', 10)
    ->delete();

// Increment field
Closing::find($id)->increment('probability', 5);

// Decrement field
Closing::find($id)->decrement('probability', 5);

// Increment with conditions
Closing::where('status', 'Open')
    ->increment('probability', 10);
```

---

## Attributes & Casting

```php
// Access casted attributes
$closing->amount;           // Decimal(2)
$closing->probability;      // Integer
$closing->expected_close_date; // Date
$closing->actual_close_date;   // Date
$closing->documents;        // Array
$closing->created_at;       // DateTime
$closing->updated_at;       // DateTime

// Mutate values
$closing->amount = 50000.50;  // Automatically casted
$closing->expected_close_date = '2026-02-28';  // Converted to date

// Check if changed
if ($closing->isDirty('status')) {
    // Status was changed
}

// Get original value
$original = $closing->getOriginal('status');
```

---

## Performance Tips

```php
// ✅ Good: Load relationships upfront
$closings = Closing::with('deal', 'contact')->get();

// ❌ Bad: N+1 queries
$closings = Closing::all();
foreach ($closings as $closing) {
    echo $closing->deal->title;  // Queries database each iteration
}

// ✅ Good: Use select to limit columns
$closings = Closing::select('id', 'title', 'status')->get();

// ✅ Good: Use whereHas for relationship filters
$closings = Closing::whereHas('deal', function ($query) {
    $query->where('status', 'Closed Won');
})->get();

// ✅ Good: Paginate large datasets
$closings = Closing::paginate(50);

// ✅ Good: Use chunk for processing
Closing::chunk(100, function ($closings) {
    // Process $closings
});
```

---

## Testing Examples

```php
// test/Feature/ClosingResourceTest.php

public function test_can_create_closing()
{
    $deal = Deal::factory()->create();
    
    $response = $this->post('/closings', [
        'deal_id' => $deal->id,
        'title' => 'Test Closing',
        'status' => 'Open',
    ]);
    
    $this->assertDatabaseHas('closings', [
        'deal_id' => $deal->id,
        'title' => 'Test Closing',
    ]);
}

public function test_user_can_only_see_own_closings()
{
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    Closing::factory()->for($user1)->create();
    Closing::factory()->for($user2)->create();
    
    $this->actingAs($user1)
        ->get('/closings')
        ->assertSee('Only 1 closing visible');
}
```

---

**Last Updated**: January 29, 2026
**Status**: ✅ Complete API Reference
