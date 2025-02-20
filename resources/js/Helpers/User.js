import Token from './Token';
import AppStorage from './AppStorage';

class User {

  responseAfterToken(res) {
    const access_token = res.data.access_token;
    const username = res.data.user;
    
    if (Token.isValid(access_token)) {
      AppStorage.store(access_token, username);
    }
  }

  hasToken() {
    const storedToken = localStorage.getItem('token');
    return storedToken ? Token.isValid(storedToken) : false;
  }

  loggedIn() {
    return this.hasToken();
  }

  logout() {
    AppStorage.clear();
    window.location = '/';
  }

  name() {
    if (this.loggedIn()) {
      return localStorage.getItem('user');
    }
    return "Guest";
  }

  id() {
    if (this.loggedIn()) {
      const token = localStorage.getItem('token');
      const payload = Token.payload(token);
      return payload ? payload.sub : null;
    }
    return null;
  }
}
const user = new User();
export default user;
