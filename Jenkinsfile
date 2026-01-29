pipeline {
    agent any

    environment {
        CONTAINER_NAME = "maralabs-sales-app"
    }

    stages {
        stage('0. Environment Check') {
            steps {
                script {
                    echo "--- [Step 0] Checking PHP Version in Container ---"
                    sh "docker exec ${CONTAINER_NAME} php -v"
                }
            }
        }

        stage('1. Sync Code to Container') {
            steps {
                script {
                    echo "--- [Step 1] Synchronizing Code and Copying to Container ---"
                    sh "docker cp . ${CONTAINER_NAME}:/var/www/html"
                    
                    echo "--- Setting Initial File Permissions ---"
                    sh "docker exec ${CONTAINER_NAME} chown -R www-data:www-data /var/www/html"
                }
            }
        }

        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    echo "--- [Step 2] Updating Dependencies ---"
                    
                    // Trust all directories to prevent 'dubious ownership' errors
                    sh "docker exec ${CONTAINER_NAME} git config --global --add safe.directory '*'"
                    
                    // Update packages
                    sh "docker exec ${CONTAINER_NAME} composer update --no-dev --optimize-autoloader --no-scripts"
                    
                    echo "--- [Step 2.1] Emergency Cache Cleanup ---"
                    // Manually remove cache files because 'php artisan' is currently 
                    // crashing due to the missing PailServiceProvider.
                    sh "docker exec ${CONTAINER_NAME} rm -f bootstrap/cache/services.php bootstrap/cache/packages.php bootstrap/cache/config.php"
                    
                    echo "--- [Step 2.2] Running Laravel Maintenance ---"
                    // This should now work without the 'Class not found' error
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
                    
                    // Database and Assets
                    sh "docker exec ${CONTAINER_NAME} php artisan migrate --force"
                    sh "docker exec ${CONTAINER_NAME} php artisan filament:upgrade"
                    
                    // Final optimization for production
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize"
                }
            }
        }
    }

    post {
        success {
            echo "--- Deployment updated successfully for maralabs-sales! ---"
        }
        failure {
            echo "--- Deployment failed. Check Jenkins console output for details. ---"
        }
    }
}