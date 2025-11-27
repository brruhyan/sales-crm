pipeline {
    agent any
//Test
    environment {
        // Use the actual running container name for docker exec
        PHP_SERVICE = 'maralabs-sales-app' 
        COMPOSE_FILE = 'docker-compose.yml'
        APP_USER = 'www-data:www-data'
    }

    stages {
        stage('1. Sync Code to Container') {
            steps {
                script {
                    echo "--- [Step 1] Synchronizing Code and Copying to Container ---"

                    sh "docker cp . ${PHP_SERVICE}:/var/www/html"

                    echo "--- Setting Initial File Permissions inside Container ---"
                    sh "docker exec ${PHP_SERVICE} chown -R ${APP_USER} /var/www/html"
                }
            }
        }
        
        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    echo "--- [Step 2] Updating Dependencies and Caches ---"
                    
                    def docker_exec = "docker exec ${PHP_SERVICE}"
                    
                    // --- Laravel Commands (Order Corrected) ---
                    
                    // FIX: Install/Update PHP dependencies FIRST so classes are available
                    sh "${docker_exec} composer install --no-dev --optimize-autoloader"

                    // Run frontend build
                    sh "${docker_exec} npm run build"

                    // Now clear all caches (this will no longer fail)
                    sh "${docker_exec} php artisan optimize:clear"

                    // Run Database Migrations
                    sh "${docker_exec} php artisan migrate --force"
                    
                    // Optimize/Rebuild configuration cache
                    sh "${docker_exec} php artisan config:cache"
                    sh "${docker_exec} php artisan optimize"
                    
                    // --- Laravel/Filament Specific Caches ---
                    
                    // Optional: Clear Filament cache
                    sh "${docker_exec} php artisan filament:clear-cache"
                
                    // --- Permissions (final cleanup for runtime folders) ---
                    
                    // Ensure storage and cache folders have write permissions after Composer/Artisan commands
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/storage"
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/bootstrap/cache"

                    echo "--- Deployment Complete! ---"
                }
            }
        }
    }
}