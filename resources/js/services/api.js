import axios from 'axios';
import Cookie from 'js-cookie';

export class ApiClass {

  constructor(vueInstance) {
    this.http = axios.create({
      baseURL: process.env.MIX_API_URL
    });

    this.vue = new vueInstance;

    this.http.defaults.headers.common = {
      ...this.http.defaults.headers.common,
      ...{
        'Authorization': this.getToken(),
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Credentials': true,
      }
    }
  }

  getToken() {
    const token = Cookie.get('token');
    return token ? `Bearer ${token}` : '';
  }

  setToken({ access_token }) {
    Cookie.set("token", access_token, {
      path: "/",
      domain: process.env.MIX_APP_URL.replace(/(http|https):\/\//i, ""),
      expires: 7,
      sameSite: "lax",
      secure: process.env.MIX_SECURE_COOKIE
    });

    this.updateToken();
  }

  handleError({ data, status, statusText }) {
    const { error } = data;
    return Promise.reject({
      data,
      status
    });
  }

  handleSuccess(data) {
    return Promise.resolve(data);
  }

  setHeaders(headers) {
    this.http.defaults.headers.common = {
      ...this.http.defaults.headers.common,
      ...headers
    }
    return this;
  }

  updateToken() {
    this.http.defaults.headers.common = {
      ...this.http.defaults.headers.common,
      ...{
        'Authorization': this.getToken(),
      }
    }
  }

  removeToken() {
    this.http.defaults.headers.common = {
      ...this.http.defaults.headers.common,
      ...{
        'Authorization': null,
      }
    }
  }

  async get(route, params, config) {
    try {
      const { data } = await this.http.get(route, {
        params
      }, config);

      return this.handleSuccess(data);
    } catch ({ response }) {
      return this.handleError(response);
    }
  }

  async post(route, payload, config) {

    try {
      const { data } = await this.http.post(route, payload, config);

      return this.handleSuccess(data);
    } catch ({ response }) {
      return this.handleError(response);
    }
  }

  async put(route, payload, config) {
    try {
      const { data } = await this.http.put(route, payload, config);

      return this.handleSuccess(data);
    } catch ({ response }) {
      return this.handleError(response);
    }
  }

  async delete(route, payload) {
    try {
      const { data } = await this.http.delete(route, {
        data: payload
      });

      return this.handleSuccess(data);
    } catch ({ response }) {
      return this.handleError(response);
    }
  }

}


const Api = {
  install: (Vue, options) => {
    Vue.prototype.$api = new ApiClass(Vue);
  }
}

export default Api;