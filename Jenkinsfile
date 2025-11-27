pipeline {
    agent any

    environment {
        // Use the actual running container name for docker exec
        PHP_SERVICE = 'maralabs-sales-app' 
        COMPOSE_FILE = 'docker-compose.yml'
        APP_USER = 'www-data:www-data'
    }

    stages {
        stage('1. Sync Code (Hard Reset)') {
            steps {
                script {
                    echo "--- [Step 1] Synchronizing Host Code ---"

                    // Pull the latest changes
                    sh 'git fetch origin'
                    
                    // Force reset the working directory to the latest commit
                    sh 'git reset --hard origin/master'
                }
            }
        }
        
        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    echo "--- [Step 2] Updating Dependencies and Caches ---"
                    
                    // Define the docker exec command template (removed the invalid -T flag)
                    def docker_exec = "docker exec ${PHP_SERVICE}"
                    
                    // --- Laravel Commands ---
                    
                    // Clear all caches (config, route, view, etc.)
                    sh "${docker_exec} php artisan optimize:clear"
                    
                    // Install or update PHP dependencies
                    sh "${docker_exec} composer install --no-dev --optimize-autoloader"

                    // Run Database Migrations (Crucial if schema changed)
                    sh "${docker_exec} php artisan migrate --force"
                    
                    // Optimize/Rebuild configuration cache
                    sh "${docker_exec} php artisan config:cache"
                    
                    // --- Laravel/Filament Specific Caches ---
                    
                    // Optional: Clear Filament cache
                    sh "${docker_exec} php artisan filament:clear-cache"
                    
                    // Optional: Discover Livewire components
                    sh "${docker_exec} php artisan livewire:discover"

                    // --- Permissions ---
                    
                    // Ensure permissions are correct after file sync
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/storage"
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/bootstrap/cache"

                    echo "--- Deployment Complete! ---"
                }
            }
        }
    }
}
