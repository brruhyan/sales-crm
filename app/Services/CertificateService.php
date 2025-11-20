<?php

namespace App\Services;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    /**
     * Generate a registration certificate for the user
     */
    public function generateCertificate(User $user): string
    {
        $certificateData = [
            'user' => $user,
            'generated_date' => now()->format('F j, Y'),
            'certificate_id' => 'CERT-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
        ];

        $pdf = Pdf::loadView('certificates.registration', $certificateData)
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $filename = 'certificates/registration_certificate_' . $user->id . '_' . time() . '.pdf';
        
        Storage::disk('public')->put($filename, $pdf->output());
        
        return $filename;
    }

    /**
     * Get the full path to the certificate file
     */
    public function getCertificatePath(string $filename): string
    {
        return Storage::disk('public')->path($filename);
    }
}