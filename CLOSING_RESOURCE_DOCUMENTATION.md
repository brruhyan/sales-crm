# Closing Resource - Implementation Guide

## Overview
The Closing resource has been added to the MaraLabs Sales application. It appears in the Sales navigation group, positioned below Deals (Sort order: 30 vs Deals at 20).

## Files Created

### Models
- `app/Models/Closing.php` - Main Closing model with relationships and scopes

### Migrations
- `database/migrations/2024_01_29_000000_create_closings_table.php` - Creates closings table

### Filament Resource
- `app/Filament/Client/Resources/Closings/ClosingResource.php` - Main resource
- `app/Filament/Client/Resources/Closings/Pages/CreateClosing.php` - Create page
- `app/Filament/Client/Resources/Closings/Pages/EditClosing.php` - Edit page
- `app/Filament/Client/Resources/Closings/Pages/ListClosings.php` - List page
- `app/Filament/Client/Resources/Closings/Pages/ViewClosing.php` - View page

### Schemas
- `app/Filament/Client/Resources/Closings/Schemas/ClosingForm.php` - Form configuration
- `app/Filament/Client/Resources/Closings/Schemas/ClosingInfolist.php` - Infolist configuration
- `app/Filament/Client/Resources/Closings/Tables/ClosingsTable.php` - Table configuration

### Factories & Notifications
- `database/factories/ClosingFactory.php` - Factory for testing
- `app/Notifications/ClosingCreatedNotification.php` - Notification handler
- `app/Listeners/SendClosingCreatedNotification.php` - Event listener

## Key Features

### Deal Selection with Auto-Population
When creating or editing a Closing:
1. Select an associated Deal from the dropdown
2. The following fields automatically populate:
   - **Title**: "Closing of [Deal Title]"
   - **Contact**: Auto-filled from Deal's contact
   - **Amount**: Copied from Deal amount
   - **Currency**: Copied from Deal currency (defaults to USD)
   - **Probability**: Copied from Deal probability
   - **Expected Close Date**: Copied from Deal's expected close date

### Closing Status Options
- Open
- In Progress
- Pending Documentation
- Closed Won
- Closed Lost

### Fields Included
- **Deal Information**
  - Associated Deal (required)
  - Title (auto-populated, disabled)
  - Status (required, defaults to "Open")
  - Description
  - Currency (dropdown)
  - Amount (numeric)
  - Probability (0-100%)

- **Timeline**
  - Expected Close Date
  - Actual Close Date

- **Associations**
  - Contact (auto-populated from Deal, disabled)

- **Supporting Documents**
  - File upload for documents (stored privately)

- **Additional Notes**
  - Internal notes and comments

### Database Schema
```sql
CREATE TABLE closings (
    id BIGINT PRIMARY KEY,
    deal_id BIGINT FOREIGN KEY (references deals),
    contact_id BIGINT NULLABLE FOREIGN KEY (references contacts),
    user_id BIGINT FOREIGN KEY (references users),
    title VARCHAR(255),
    description TEXT NULLABLE,
    status VARCHAR(255) DEFAULT 'Open',
    expected_close_date DATE NULLABLE,
    actual_close_date DATE NULLABLE,
    amount DECIMAL(15,2) NULLABLE,
    currency VARCHAR(255) DEFAULT 'USD',
    probability INT DEFAULT 0,
    documents JSON NULLABLE,
    notes TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEXES: user_id, status, deal_id+user_id
)
```

### Relationships
- **Belongs To**: Deal, Contact, User
- **Has Many** (on Deal): closings

### Activity Logging
All changes to Closings are logged via Spatie Activity Log:
- Created
- Updated
- Deleted

## Navigation
- **Group**: Sales
- **Icon**: Check Circle
- **Sort Order**: 30 (below Deals which is 20)
- **Route Prefix**: `/closings`

## Usage Example

```php
// Create a new closing
$closing = Closing::create([
    'deal_id' => $deal->id,
    'title' => 'Closing of ' . $deal->title,
    'contact_id' => $deal->contact_id,
    'amount' => $deal->amount,
    'currency' => $deal->currency,
    'probability' => $deal->probability,
    'status' => 'Open',
    'user_id' => auth()->id(),
]);

// Retrieve closings for a deal
$closings = $deal->closings;

// Get won closings
$wonClosings = Closing::won()->where('user_id', auth()->id())->get();

// Get active closings
$activeClosings = Closing::active()->where('user_id', auth()->id())->get();
```

## Migration
The migration has already been run. To rollback:

```bash
php artisan migrate:rollback --step=1
```

## Testing
You can generate test data using the factory:

```php
$closing = \App\Models\Closing::factory()
    ->for(\App\Models\Deal::factory())
    ->for(\App\Models\Contact::factory())
    ->for(\App\Models\User::factory())
    ->create();
```

## Future Enhancements
- Add email notifications for status changes
- Add bulk actions (e.g., mass status updates)
- Add custom reports/dashboard
- Integrate document management
- Add timeline/activity tracking within closings
