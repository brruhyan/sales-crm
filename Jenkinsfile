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
                    // Copy fresh code from Jenkins workspace to container
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
                    
                    // FIX: Solve the "dubious ownership" error by trusting the directory
                    sh "docker exec ${CONTAINER_NAME} git config --global --add safe.directory /var/www/html"
                    
                    // Run Composer Update
                    sh "docker exec ${CONTAINER_NAME} composer update --no-dev --optimize-autoloader --no-scripts"
                    
                    echo "--- Running Laravel Maintenance Commands ---"
                    // Clear all caches
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
                    
                    // Run migrations (force for production/automated env)
                    sh "docker exec ${CONTAINER_NAME} php artisan migrate --force"
                    
                    // IMPORTANT: Required when upgrading Filament versions
                    sh "docker exec ${CONTAINER_NAME} php artisan filament:upgrade"
                    
                    // Re-optimize for performance
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize"
                }
            }
        }
    }

    post {
        success {
            echo "Deployment updated successfully for maralabs-sales!"
        }
        failure {
            echo "Deployment failed. Check Jenkins logs for details."
        }
    }
}