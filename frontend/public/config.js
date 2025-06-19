const config = {
  development: {
    apiBaseUrl: 'http://localhost:8000/api',
  },
  production: {
    apiBaseUrl: 'https://api.example.com/api', // Replace with your production API URL
  },
};

// Get current environment from URL parameter, localStorage, or default to development
function getCurrentEnvironment() {
  // Check URL parameter
  const urlParams = new URLSearchParams(window.location.search);
  const envParam = urlParams.get('env');
  if (envParam && ['development', 'production'].includes(envParam)) {
    localStorage.setItem('environment', envParam);
    return envParam;
  }

  // Check localStorage
  const storedEnv = localStorage.getItem('environment');
  if (storedEnv && ['development', 'production'].includes(storedEnv)) {
    return storedEnv;
  }

  // Default to development
  return 'development';
}

// Export configuration
const currentEnv = getCurrentEnvironment();
const currentConfig = config[currentEnv];

console.log(`Running in ${currentEnv} environment`);
