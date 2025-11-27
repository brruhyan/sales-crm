pipeline {
    agent any

    environment {
        PHP_SERVICE = 'maralabs-sales-app' 
        COMPOSE_FILE = 'docker-compose.yml'
        APP_USER = 'www-data:www-data'
    }

    stages {
        stage('1. Sync Code (Hard Reset)') {
            steps {
                script {
                    echo "--- [Step 1] Synchronizing Host Code ---"

                    sh 'git fetch origin'
                    
                    sh 'git reset --hard origin/master'
                }
            }
        }
        
        // This stage replaces the original stages 2, 3, and 4
        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    echo "--- [Step 2] Updating Dependencies and Caches ---"
                    def docker_exec = "docker exec -T ${PHP_SERVICE}"
                    sh "${docker_exec} php artisan optimize:clear"
                    sh "${docker_exec} composer install --no-dev --optimize-autoloader"
                    sh "${docker_exec} php artisan migrate --force"
                    sh "${docker_exec} php artisan config:cache"
                    sh "${docker_exec} php artisan filament:clear-cache"
                    sh "${docker_exec} php artisan livewire:discover"

                    
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/storage"
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/bootstrap/cache"

                    echo "--- Deployment Complete! ---"
                }
            }
        }
    }
}
