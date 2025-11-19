pipeline {
    
    triggers {
        githubPush() 
    }
    
    agent {
        docker {
            image 'node:20-alpine' 
            args '-v /var/run/docker.sock:/var/run/docker.sock'
        }
    }
    
    environment {
        CONTAINER_NAME = 'maralabs-sales_app' 
    }

    stages {
        
        stage('Initialize & Sync') {
            steps {
                echo "1. Installing Docker client in agent and pulling latest code..."
                
                sh 'apk add --no-cache curl'
                sh 'curl -L https://download.docker.com/linux/static/stable/x86_64/docker-26.1.1.tgz | tar -xz'
                sh 'mv docker/docker /usr/local/bin/'
                sh 'rm -r docker'
                echo "Docker client installed successfully."
                
                checkout scm 
                echo "Code synchronized on host."
            }
        }
        
        stage('App Update & Cleanup') {
            steps {
                echo "2. Running container commands (npm, composer, cache clear)..."
                
                sh "docker exec ${CONTAINER_NAME} npm install"
                sh "docker exec ${CONTAINER_NAME} npm run build"
                sh "docker exec ${CONTAINER_NAME} php artisan optimize:clear"
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
