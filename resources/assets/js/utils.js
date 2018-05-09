
/**
 * Configure axios defaults
 * settings taken from default Laravel bootstrap and vue-auth
 */
export function configureAxios(axios) {
    axios.defaults.baseURL = 'http://fio-weather.test/api';
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = getCSRFToken();
}
/**
 * Register the CSRF Token as a common header with Axios so that all outgoing
 * HTTP requests automatically have it attached. This is just a simple convenience
 * so we don't have to attach every token manually.
 */
export function getCSRFToken() {
    let el = document.head.querySelector('meta[name="csrf-token"]');
    return el ? el.content : null;
}
