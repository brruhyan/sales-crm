pipeline {
    agent any
    
    environment {
        CONTAINER_NAME = 'maralabs-sales-app'
    }

    stages {
        stage('Checkout & Sync') {
            steps {
                echo "Pulling latest code to server filesystem"
                sh """
                    cd /root/maralabs-sales
                    git reset --hard
                    git pull origin master
                """
            }
        }
    }
}
