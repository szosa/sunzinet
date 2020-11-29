import Vue from 'vue'

class AuthorizationService {
    login(user) {
        return Vue.prototype.$http
            .post('login', {
                username: user.username,
                password: user.password
            })
            .then(response => {
                if (response.data.access_token) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                }
                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        return Vue.prototype.$http.post('register', {
            username: user.username,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthorizationService();