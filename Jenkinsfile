pipeline {
    agent any
  environment{
  scannerHome = tool 'SonarScanner'
  }
    stages {
        
        stage('SonarQube analysis') {
            steps {
                 withSonarQubeEnv('sq1') {
      sh "${scannerHome}/bin/sonar-scanner"
    }
            }
        }
                stage("Abort in case of failure") {
            steps {
                timeout(time:1,unit:'MINUTES')
                {
                    waitForQualityGate abortPipeline: true 
                }
            }
        }
        
    }
}
