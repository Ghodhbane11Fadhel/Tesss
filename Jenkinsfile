pipeline {
    agent any
  environment{
  scannerHome = tool 'SonarScanner'
  }
    stages {
        
        stage('build && SonarQube analysis') {
            steps {
                 withSonarQubeEnv('sq1') {
      sh "${scannerHome}/bin/sonar-scanner"
    }
            }
        }
                stage("Quality gate") {
            steps {
                timeout(time:2,unit:'MINUTES')
                waitForQualityGate abortPipeline: true
            }
        }
        
    }
}
