import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let csrfToken = document.head.querySelector('meta[name="csrf-token"]')

if (csrfToken) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

axios.interceptors.response.use(null, error => {
  if (error.response.status === 401) {

  }

  return Promise.reject(error);
});

export default axios
