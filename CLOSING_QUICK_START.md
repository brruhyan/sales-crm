# Closing Resource - Quick Start Guide

## 🚀 Getting Started

### Accessing the Closing Resource
1. Log in to the application
2. Navigate to **Sales** in the sidebar
3. Click **Closings** (below Deals)

### Creating Your First Closing

1. Click the **Create** button
2. **Select a Deal** (required)
   - Choose from available deals with status: Proposal Sent, Negotiation, or Closed Won
   - The form will automatically populate related fields
3. **Review Auto-Populated Fields**
   - Title
   - Contact
   - Amount
   - Currency
   - Probability
   - Expected Close Date
4. **Set the Status** (defaults to "Open")
5. **Add Description** (optional but recommended)
6. **Add Notes** (optional)
7. **Upload Documents** (optional)
8. **Save**

### Managing Closings

#### View All Closings
- Go to Closings → Index page shows all your closings
- Sort by any column header
- Filter by Status or Associated Deal
- Search by title or description

#### Edit a Closing
- Click the **Edit** button (pencil icon)
- Modify any field
- Save changes

#### View Details
- Click the **View** button (eye icon)
- See all closing information in read-only format
- Check the associated deal and contact

### Key Features Explained

#### Auto-Population
When you select a Deal, these fields are automatically filled:
- **Title**: "Closing of {Deal Title}"
- **Contact**: The contact from the Deal
- **Amount**: The deal amount
- **Currency**: The deal currency
- **Probability**: The deal probability
- **Expected Close Date**: The deal's expected close date

You can override any auto-populated field before saving.

#### Status Workflow
Choose the appropriate status for your closing:
- **Open** - Just created, not started
- **In Progress** - Currently being processed
- **Pending Documentation** - Waiting for paperwork
- **Closed Won** - Successfully completed ✓
- **Closed Lost** - Did not close ✗

#### Tracking Documents
- Upload relevant closing documents
- Documents are stored securely
- Access them anytime from the Closing record

### Filtering & Searching

#### By Status
- Filter closings by their current status
- Useful for tracking specific stages

#### By Deal
- Filter all closings for a specific deal
- See related closings at a glance

#### By Text
- Search by Closing title
- Search by Description

### Common Workflows

#### Workflow 1: From Deal to Closing
1. Create a Deal in the Deals section
2. Get the deal approved (status: Proposal Sent)
3. Create a Closing from Sales → Closings
4. Select the Deal → auto-populates
5. Update status as closing progresses

#### Workflow 2: Multiple Closings per Deal
1. A single Deal can have multiple Closings
2. Useful for tracking sub-phases of the closing process
3. Keep notes on each closing phase

#### Workflow 3: Won Deal Tracking
1. Mark Closing status as "Closed Won"
2. Set Actual Close Date
3. Upload final documentation
4. The system tracks all won closings

### Tips & Best Practices

✅ **Do:**
- Always select a Deal as reference
- Update status as you progress through closing
- Add clear descriptions and notes
- Upload important documents
- Set realistic probability percentages

❌ **Don't:**
- Leave notes empty for important details
- Forget to update status
- Store documents only locally (use the upload feature)
- Create a Closing for a non-qualified Deal

### Data Security

- All Closings are user-scoped (only see your own)
- Documents are stored privately
- Activity logging tracks all changes
- Delete operations are permanent

### Troubleshooting

**Q: Why don't auto-populated fields appear?**
- A: Make sure the Deal has the required information
- Try selecting the Deal again to trigger auto-population

**Q: Can I change the auto-populated fields?**
- A: Yes, all fields can be modified after selection

**Q: Can I have multiple Closings for one Deal?**
- A: Yes, this is fully supported

**Q: Where are my documents stored?**
- A: Documents are stored in `/storage/app/closings`

### Keyboard Shortcuts
- `Enter` - Save form
- `Esc` - Cancel

### Related Resources
- **Deals** - Create and track deals
- **Leads** - Source your opportunities
- **Contacts** - Manage client information
- **Projects** - Track delivery

---

**Need Help?** 
Check the full documentation at `CLOSING_RESOURCE_DOCUMENTATION.md`

**Report Issues?**
Contact your system administrator or development team
