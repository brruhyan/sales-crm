pipeline {
    agent any
    
    environment {
        CONTAINER_NAME = 'maralabs-sales-app' 
    }

    stages {
        stage('Checkout & Sync') {
            steps {
                echo "1. Pulling latest code to the Jenkins workspace..."
                checkout scm 
                echo "Code synchronized on host volume."
            }
        }
        
        stage('App Update & Cleanup') {
            steps {
                echo "2. Running container commands (npm, composer, cache clear)..."

                sh "docker exec ${CONTAINER_NAME} npm install"
                sh "docker exec ${CONTAINER_NAME} npm run build" 

                sh "docker exec ${CONTAINER_NAME} composer install --no-dev --prefer-dist"
                
                sh "docker exec ${CONTAINER_NAME} php artisan migrate --force"
                sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
                
                // 🚀 ADDED: Restart the container to force a code and memory refresh
                echo "3. Restarting container to force application code reload..."
                sh "docker restart ${CONTAINER_NAME}"
                
                echo "✅ Deployment successful. Application updated."
            }
        }
    }
    
    post {
        always {
            cleanWs() 
        }
        success {
            echo 'Deployment Pipeline completed successfully. 🎉'
        }
        failure {
            echo 'Deployment Pipeline FAILED! Check application logs inside the container.'
        }
    }
}
