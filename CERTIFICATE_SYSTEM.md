# Certificate Generation for User Registration

## Overview
When a user is approved for registration in the system, they will automatically receive a PDF certificate via email. This certificate validates their approved status and grants them access to the system.

## How it Works

### 1. Certificate Service (`app/Services/CertificateService.php`)
- Generates PDF certificates using DomPDF
- Creates certificates in A4 landscape format
- Stores certificates in `storage/app/public/certificates/`
- Uses a professional certificate template

### 2. Certificate Template (`resources/views/certificates/registration.blade.php`)
- Professional-looking certificate design
- Includes user name, account type, generation date, and certificate ID
- Responsive design with company branding
- Decorative borders and styling

### 3. Updated Notification (`app/Notifications/UserApprovedNotification.php`)
- Now accepts a certificate path parameter
- Automatically attaches the generated PDF to the approval email
- Clean filename format: `Registration_Certificate_[UserName].pdf`

### 4. Updated Approval Action (`app/Filament/Resources/Actions/ApproveUserAction.php`)
- Generates certificate when user is approved
- Sends notification with certificate attachment
- Provides feedback to admin about certificate generation

## Features

### Certificate Contents
- **User Information**: Full name and account type
- **Certificate ID**: Unique identifier (format: CERT-######)
- **Issue Date**: Date when the certificate was generated
- **Professional Design**: Company-branded template with decorative elements
- **Security**: Unique filename with timestamp

### Email Integration
- Certificate automatically attached to approval email
- Professional filename format
- PDF format for universal compatibility
- Email includes message about attached certificate

## Testing

### Manual Testing
Use the artisan command to test certificate generation:

```bash
# Test with existing user
php artisan certificate:test 1

# Test with auto-created test user
php artisan certificate:test
```

### Automated Testing
Run the feature test:

```bash
php artisan test --filter CertificateGenerationTest
```

## File Locations

### Generated Certificates
- **Storage Path**: `storage/app/public/certificates/`
- **Naming Convention**: `registration_certificate_[user_id]_[timestamp].pdf`
- **Public URL**: `/storage/certificates/[filename]`

### Template Files
- **Service**: `app/Services/CertificateService.php`
- **Template**: `resources/views/certificates/registration.blade.php`
- **Notification**: `app/Notifications/UserApprovedNotification.php`
- **Action**: `app/Filament/Resources/Actions/ApproveUserAction.php`

## Configuration

### DomPDF Settings
Configuration file: `config/dompdf.php`

Key settings:
- Paper size: A4 landscape
- Font: Sans-serif
- HTML5 parser: Enabled
- Remote resources: Enabled (for external fonts/images)

### Storage Configuration
Ensure the certificates directory exists and is writable:
```bash
# Create directory if it doesn't exist
mkdir -p storage/app/public/certificates
```

## Customization

### Certificate Design
To customize the certificate appearance, edit:
`resources/views/certificates/registration.blade.php`

### Certificate Content
To modify what information appears on the certificate, update the `generateCertificate` method in:
`app/Services/CertificateService.php`

### Email Attachment
To change how the certificate is attached or named in emails, modify:
`app/Notifications/UserApprovedNotification.php`

## Troubleshooting

### Common Issues

1. **PDF not generating**: Check DomPDF installation and configuration
2. **Email not sending**: Verify mail configuration in `.env`
3. **File not found**: Ensure storage directory exists and is writable
4. **Permission issues**: Check file permissions on storage directory

### Debug Commands
```bash
# Test certificate generation
php artisan certificate:test

# Check mail configuration
php artisan config:show mail

# Clear config cache
php artisan config:clear
```

## Security Considerations

1. **File Storage**: Certificates are stored in public storage (accessible via URL)
2. **Unique Filenames**: Timestamp prevents filename collisions
3. **Certificate ID**: Unique identifier for verification
4. **Access Control**: Only approved users receive certificates

## Future Enhancements

Potential improvements:
1. Digital signatures for certificate verification
2. QR codes linking to verification system
3. Certificate revocation system
4. Multiple certificate templates
5. Batch certificate generation
6. Certificate analytics and tracking