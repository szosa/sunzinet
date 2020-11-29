export default class User {
    constructor(password, username, email = '') {
        this.email = email;
        this.password = password;
        this.username = username;
    }
}