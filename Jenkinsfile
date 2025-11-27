pipeline {
    agent any
    // Test Push
    environment {
        PHP_SERVICE = 'app' 
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
        
        stage('2. Restart Container (Flush RAM)') {
            steps {
                script {
                    echo "--- [Step 2] Restarting PHP Container ---"

                    sh "docker-compose -f ${COMPOSE_FILE} stop ${PHP_SERVICE}"
                    sh "docker-compose -f ${COMPOSE_FILE} rm -f ${PHP_SERVICE}"
                    sh "docker-compose -f ${COMPOSE_FILE} up -d ${PHP_SERVICE}"
                }
            }
        }

        stage('3. Dependencies & Database') {
            steps {
                script {
                    echo "--- [Step 3] Composer & Migrations ---"
                    // NOTE: We use '-T' here to disable TTY allocation.
                    // This prevents the "the input device is not a TTY" error in Jenkins.
                    
                    // Install PHP dependencies
                    sh "docker-compose -f ${COMPOSE_FILE} exec -T ${PHP_SERVICE} composer install --no-dev --optimize-autoloader"
                    
                    // Run Database Migrations (Fixes 500 errors on new tables)
                    sh "docker-compose -f ${COMPOSE_FILE} exec -T ${PHP_SERVICE} php artisan migrate --force"
                }
            }
        }

        stage('4. Permissions & Caches') {
            steps {
                script {
                    echo "--- [Step 4] Permissions & Caching ---"
                    
                    sh "docker-compose -f ${COMPOSE_FILE} exec -T ${PHP_SERVICE} chown -R ${APP_USER} /var/www/html/storage"
                    sh "docker-compose -f ${COMPOSE_FILE} exec -T ${PHP_SERVICE} chown -R ${APP_USER} /var/www/html/bootstrap/cache"

                    def artisan = "docker-compose -f ${COMPOSE_FILE} exec -T ${PHP_SERVICE} php artisan"

                    sh "${artisan} optimize:clear"
                    
                    sh "${artisan} filament:clear-cache"
                    sh "${artisan} livewire:discover"
                    
                    echo "--- Deployment Complete! ---"
                }
            }
        }
    }
}
