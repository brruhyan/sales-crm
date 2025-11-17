<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    public const OPTIONS = [
        'Emergency Response and Monitoring System' => 'Emergency Response and Monitoring System',
        'Learning Management System' => 'Learning Management System',
        'School Information and Management System' => 'School Information and Management System',
        'Hospital Management System' => 'Hospital Management System',
        'Human Resource Information System' => 'Human Resource Information System',
        'Accounting System' => 'Accounting System',
        'Enterprise Resource Planning System' => 'Enterprise Resource Planning System',
        'Project Management System' => 'Project Management System',
        'Document Management System' => 'Document Management System',
        'AI Virtual Assistant (Kapitas)' => 'AI Virtual Assistant (Kapitas)',
        'LGU Automation System' => 'LGU Automation System',
        'Vulnerability Assessment and Penetration Testing' => 'Vulnerability Assessment and Penetration Testing',
        'Web Application Firewall' => 'Web Application Firewall',
        'Next Generation Firewall' => 'Next Generation Firewall',
        'Anti-DDoS Solution' => 'Anti-DDoS Solution',
        'Data Leak Prevention' => 'Data Leak Prevention',
        'Security Operations Center' => 'Security Operations Center',
        'Blockchain' => 'Blockchain',
        'Network Encryption' => 'Network Encryption',
        'Digital Forensics' => 'Digital Forensics',
        'Data Aggregation Tool' => 'Data Aggregation Tool',
        'Command Center' => 'Command Center',
        'Data Center' => 'Data Center',
        'Network Monitoring System' => 'Network Monitoring System',
        'Technical Consulting' => 'Technical Consulting',
        'Others' => 'Others',
    ];
}
