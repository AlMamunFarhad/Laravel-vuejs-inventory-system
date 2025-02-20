<script>
import User from "../../Helpers/User";

export default {
    created() {
        if (User.loggedIn()) {
            this.$router.push({ path: "/home" });
        }
    },
    data() {
        return {
            form: {
                email: null,
                password: null,
            },
            errors: {},
        };
    },
    methods: {
        login() {
            axios
                .post("/api/auth/login", this.form)
                .then((res) => {
                    User.responseAfterToken(res);
                    Toast.fire({
                        icon: "success",
                        title: "Signed in successfully",
                    });
                    this.$router.push({ path: "/home" });
                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else {
                        Toast.fire({
                            icon: "warning",
                            title: "Email or password is invalid!",
                        });
                    }
                });
        },
    },
};
</script>
<template>
    <div>
        <div class="row justify-content-center">
            <h2 class="text-center mt-5">Login</h2>
            <div class="col-md-4 mt-4">
                <div class="card p-4">
                    <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    class="form-control form-control-lg"
                                    type="email"
                                    name="email"
                                    v-model="form.email"
                                    placeholder="Enter your email"
                                />
                                <p class="text-danger" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    class="form-control form-control-lg"
                                    type="password"
                                    name="password"
                                    v-model="form.password"
                                    placeholder="Enter your password"
                                />
                                <p class="text-danger" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </p>
                            </div>
                            <div>
                                <div class="form-check align-items-center">
                                    <input
                                        id="customControlInline"
                                        type="checkbox"
                                        class="form-check-input"
                                        value="remember-me"
                                        name="remember-me"
                                        checked
                                    />
                                    <label
                                        class="form-check-label text-small"
                                        for="customControlInline"
                                        >Remember me</label
                                    >
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <button
                                    type="submit"
                                    class="btn btn-lg btn-primary"
                                >
                                    Sign in
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <router-link to="/forgot-password"
                                    >Forgot Password?</router-link
                                >
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mb-3">
                    Don't have an account?
                    <router-link to="/register">Sign up</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

