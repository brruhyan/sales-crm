<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 40px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .certificate {
            background: white;
            border: 8px solid #2c3e50;
            border-radius: 15px;
            padding: 60px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin: 0 auto;
            max-width: 800px;
            position: relative;
        }

        .certificate::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #3498db;
            border-radius: 8px;
        }

        .header {
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .logo {
            font-size: 48px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .company-name {
            font-size: 24px;
            color: #3498db;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #2c3e50;
            margin: 30px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .certificate-subtitle {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 40px;
            font-style: italic;
        }

        .recipient-section {
            margin: 50px 0;
            position: relative;
            z-index: 1;
        }

        .presented-to {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .recipient-name {
            font-size: 36px;
            font-weight: bold;
            color: #e74c3c;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            display: inline-block;
        }

        .certificate-text {
            font-size: 16px;
            line-height: 1.8;
            color: #2c3e50;
            margin: 30px 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .account-type {
            font-weight: bold;
            color: #3498db;
            text-transform: capitalize;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: end;
            position: relative;
            z-index: 1;
        }

        .date-section,
        .certificate-id {
            text-align: left;
        }

        .signature-section {
            text-align: right;
        }

        .date,
        .cert-id {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .date-value,
        .cert-id-value {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }

        .signature-line {
            border-bottom: 2px solid #2c3e50;
            width: 200px;
            margin: 20px 0 10px 0;
            margin-left: auto;
        }

        .signature-title {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .decorative-border {
            position: absolute;
            top: 40px;
            left: 40px;
            right: 40px;
            bottom: 40px;
            background-image:
                repeating-linear-gradient(0deg,
                    transparent,
                    transparent 10px,
                    rgba(52, 152, 219, 0.1) 10px,
                    rgba(52, 152, 219, 0.1) 11px);
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="decorative-border"></div>

        <div class="header">
            <div class="logo">MaraLabs</div>
            <div class="company-name">Sales Management System</div>
        </div>

        <div class="certificate-title">Certificate of Registration</div>
        <div class="certificate-subtitle">This is to certify that</div>

        <div class="recipient-section">
            <div class="presented-to">This certificate is presented to</div>
            <div class="recipient-name">{{ $user->name }}</div>
        </div>

        <div class="certificate-text">
            has successfully completed the registration process as a
            <span class="account-type">{{ $user->account_type }}</span>
            member of the MaraLabs Sales Management System.
            This certificate validates their approved status and grants them
            full access to all system features and capabilities.
        </div>

        <div class="footer">
            <div class="date-section">
                <div class="date">Date Issued:</div>
                <div class="date-value">{{ $generated_date }}</div>
            </div>

            <div class="certificate-id">
                <div class="cert-id">Certificate ID:</div>
                <div class="cert-id-value">{{ $certificate_id }}</div>
            </div>

            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-title">System Administrator</div>
            </div>
        </div>
    </div>
</body>

</html>