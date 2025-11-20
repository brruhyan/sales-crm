<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\CertificateService;

class TestCertificateGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificate:test {user_id? : The ID of the user to generate certificate for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test certificate generation for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
        } else {
            // Create a test user if no ID provided
            $user = User::first() ?? User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'account_type' => 'individual',
                'approved' => true,
            ]);
            $this->info("Using user: {$user->name} (ID: {$user->id})");
        }

        $this->info("Generating certificate for: {$user->name}");
        
        $certificateService = new CertificateService();
        
        try {
            $certificatePath = $certificateService->generateCertificate($user);
            $fullPath = $certificateService->getCertificatePath($certificatePath);
            
            $this->info("Certificate generated successfully!");
            $this->line("File path: {$certificatePath}");
            $this->line("Full path: {$fullPath}");
            
            if (file_exists($fullPath)) {
                $fileSize = filesize($fullPath);
                $this->info("File size: " . number_format($fileSize) . " bytes");
            }
            
        } catch (\Exception $e) {
            $this->error("Failed to generate certificate: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
