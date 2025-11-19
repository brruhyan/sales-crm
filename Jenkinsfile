pipeline {
    agent any 

    stages {
        stage('Checkout') {
            steps {
                sh 'git fetch origin'
                sh 'git reset --hard origin/master'
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
