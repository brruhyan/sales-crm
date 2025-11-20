<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\CertificateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class CertificateGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_generate_a_certificate_for_a_user()
    {
        // Create a test user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'account_type' => 'individual',
            'approved' => true,
        ]);

        $certificateService = new CertificateService();
        
        // Generate certificate
        $certificatePath = $certificateService->generateCertificate($user);
        
        // Verify file was created
        $this->assertTrue(Storage::disk('public')->exists($certificatePath));
        
        // Verify file is a PDF
        $this->assertStringContainsString('.pdf', $certificatePath);
        
        // Clean up
        Storage::disk('public')->delete($certificatePath);
    }
}