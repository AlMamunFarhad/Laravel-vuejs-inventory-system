class AppStorage {
    storeToken(token) {
        localStorage.setItem("token", token);
    }

    storeUser(user) {
        return localStorage.setItem("user", user);
    }

    store(token, user) {
        this.storeToken(token);
        this.storeUser(user);
    }

    clear() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
    }

    getToken() {
        return localStorage.getItem("token");
    }

    getUser() {
        return localStorage.getItem("user");
    }
}
const appStorage = new AppStorage();
export default appStorage;
