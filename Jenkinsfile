// Tes
pipeline {
    agent any

    triggers {
        githubPush() 
    }
    
    environment {
        CONTAINER_NAME = 'maralabs-sales_app' 
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
                // Using sh commands to execute inside the running Docker container
                sh "docker exec ${CONTAINER_NAME} npm install"
                sh "docker exec ${CONTAINER_NAME} npm run build"
                sh "docker exec -it ${CONTAINER_NAME} php artisan optimize:clear"
                echo "✅ Application update process complete."
            }
        }
    }
    
    post {
        always {
            // Cleans up the workspace after every build
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
