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
                    // Ensure the web server user owns the files
                    sh "docker exec ${CONTAINER_NAME} chown -R www-data:www-data /var/www/html"
                }
            }
        }

        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    echo "--- [Step 2] Updating Dependencies ---"
                    
                    // FIX: The wildcard '*' tells Git to trust ALL directories. 
                    // This prevents the 'dubious ownership' error in vendor subfolders.
                    sh "docker exec ${CONTAINER_NAME} git config --global --add safe.directory '*'"
                    
                    // Run Composer Update
                    sh "docker exec ${CONTAINER_NAME} composer update --no-dev --optimize-autoloader --no-scripts"
                    
                    echo "--- Running Laravel Maintenance Commands ---"
                    // Clear all caches to avoid stale config/routes
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
                    
                    // Run database migrations
                    sh "docker exec ${CONTAINER_NAME} php artisan migrate --force"
                    
                    // IMPORTANT: Re-publishes Filament assets (essential for v4.3 -> v4.6 update)
                    sh "docker exec ${CONTAINER_NAME} php artisan filament:upgrade"
                    
                    // Re-optimize for production performance
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