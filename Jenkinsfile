pipeline {
    agent any 

    stages {
        stage('Checkout') {
            steps {
                checkout scm
                echo "Successfully checked out the code from ${env.BRANCH_NAME}"
            }
        }

        stage('Build') {
            steps {
                echo 'Starting the build process...'
                sh 'ls -l'
                echo 'Build finished.'
            }
        }
    }

    post {
        always {
            echo "Pipeline finished. Status: ${currentBuild.result}"
        }
        failure {
            echo 'Build failed. Sending notification...'
        }
    }
}
