pipeline {
    agent any

    environment {
        CONTAINER_NAME = "maralabs-sales-app"
    }

    stages {
        stage('0. Environment Check') {
            steps {
                script {
                    sh "docker exec ${CONTAINER_NAME} php -v"
                }
            }
        }

        stage('1. Sync Code to Container') {
            steps {
                script {
                    sh "docker cp . ${CONTAINER_NAME}:/var/www/html"
                    sh "docker exec ${CONTAINER_NAME} chown -R www-data:www-data /var/www/html"
                }
            }
        }

        stage('2. Update Dependencies & Clear Cache') {
            steps {
                script {
                    sh "docker exec ${CONTAINER_NAME} git config --global --add safe.directory '*'"
                    sh "docker exec ${CONTAINER_NAME} composer update --no-dev --optimize-autoloader --no-scripts"
                    sh "docker exec ${CONTAINER_NAME} rm -f bootstrap/cache/services.php bootstrap/cache/packages.php bootstrap/cache/config.php"
                    sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
                    sh "docker exec ${CONTAINER_NAME} php artisan migrate --force"
                    sh "docker exec ${CONTAINER_NAME} php artisan filament:upgrade"
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