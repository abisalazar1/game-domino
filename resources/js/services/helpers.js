
class Helpers {
    unbind(data) {
      return JSON.parse(JSON.stringify(data));
    }
    storage(filePath){
      return `${process.env.MIX_ASSETS_PATH}${filePath}`;
    }
  }
  
  const helpers = {
    install: (Vue, options) => {
      Vue.prototype.$helpers = new Helpers;
    }
  }
  
  export default helpers;