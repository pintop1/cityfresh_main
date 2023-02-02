pipeline {
  agent { docker { 'php:8.1.11-alpine' } }
  stages {
    stage('build') {
      steps {
        sh 'php --version'
      }
    }
  }
}
