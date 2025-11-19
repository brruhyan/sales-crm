// Test
pipeline {
    agent any
    
    environment {
        CONTAINER_NAME = 'maralabs-sales-app' 
    }

    stages {
        
        stage('Checkout & Sync') {
            steps {
                echo "1. Pulling latest code into Jenkins workspace (and host directory)..."
                checkout scm
                echo "Code synchronized on host."
            }
        }
        

        stage('App Update & Cleanup') {
            steps {
                echo "2. Running container commands (npm, composer, cache clear)..."
                sh "docker exec maralabs-sales-app npm install"
                sh "docker exec maralabs-sales-app npm run build"
                sh "docker exec -it maralabs-sales-app php artisan optimize:clear"
                echo "✅ Application update process complete."
            }
        }
    }
    
    post {
        always {
            cleanWs() 
        }
        success {
            echo 'Deployment Pipeline completed successfully.'
        }
        failure {
            echo 'Deployment Pipeline FAILED! Check application logs inside the container.'
        }
    }
}
