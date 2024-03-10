import axios from 'axios';
// axios.defaults.baseURL = process.env.VUE_APP_API_URL;
// axios.defaults.baseURL = 'https://hthe.site/'
// axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
// axios.defaults.headers.common['Access-Control-Allow-Methods'] = '*';
// Content-Type, X-Auth-Token, Origin, Authorization
export default (app) => {
  app.axios = axios;
  app.$http = axios;

  app.config.globalProperties.axios = axios;
  app.config.globalProperties.$http = axios;

  const token = localStorage.getItem('token')
  // let headers = ''
  if (token) {
    axios.defaults.headers.common['Authorization'] = token
  }

}