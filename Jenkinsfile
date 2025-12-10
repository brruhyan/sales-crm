pipeline {
    agent any
    environment {
        PHP_SERVICE = 'maralabs-sales-app' 
        COMPOSE_FILE = 'docker-compose.yml'
        APP_USER = 'www-data:www-data'
    }

    stages {
        stage('0. Environment Check') {
            steps {
                script {
                    echo "--- [Step 0] Checking PHP Version in Container ---"
                    sh "docker exec ${PHP_SERVICE} php -v"
                }
            }
        }
        
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
                    
                    sh "${docker_exec} composer update --no-dev --optimize-autoloader"

                    sh "${docker_exec} npm run build"

                    sh "${docker_exec} php artisan optimize:clear"

                    sh "${docker_exec} php artisan migrate --force"
                    
                    sh "${docker_exec} php artisan config:cache"
                    sh "${docker_exec} php artisan optimize"
                    
                    sh "${docker_exec} php artisan filament:clear-cache"
                
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/storage"
                    sh "${docker_exec} chown -R ${APP_USER} /var/www/html/bootstrap/cache"

                    echo "--- Deployment Complete! ---"
                }
            }
        }
    }
}
