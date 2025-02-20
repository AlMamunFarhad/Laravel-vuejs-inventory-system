<script>
import User from "../../Helpers/User";

export default {
    created() {
        if (User.loggedIn()) {
            this.$router.push("home");
        }
    },
    data() {
        return {
            form: {
				name: null,
                email: null,
                password: null,
				password_confirmation: null
            },
            errors: {},
        };
    },
    methods: {
        signup() {
            axios
                .post("/api/auth/signup", this.form)
                .then((res) => {
                    User.responseAfterToken(res);
                    Toast.fire({
                        icon: "success",
                        title: "Signed up successfully",
                    });
                    this.$router.push("home");
                })
                .catch((error) => this.errors = error.response.data.errors);
        },
    },
};
</script>
<template>
    <div>
        <div class="row justify-content-center">
			<h2 class="text-center mt-5">Register</h2>
        <div class="col-md-4 mt-4">
        <div class="card p-4">
            <h5 class="card-title">Register a new Account</h5>
							<div class="card-body">
									<form @submit.prevent="signup">
										<div class="mb-3">
											<label class="form-label">Full name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name" v-model="form.name"/>
											<p class="text-danger" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </p>
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" v-model="form.email"/>
											<p class="text-danger" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </p>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" v-model="form.password"/>
											<p class="text-danger" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </p>
										</div>
										<div class="mb-3">
											<label class="form-label">Confirm Password</label>
											<input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Confirm password" v-model="form.password_confirmation"/>
											<p class="text-danger" v-if="errors.password_confirmation">
                                    {{ errors.password_confirmation[0] }}
                                </p>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Sign up</button>
										</div>
									</form>
								
							</div>
						</div>
						<div class="text-center mb-3">
							Already have account? <router-link to="/">Log In</router-link>
						</div>
                    </div>
                    </div>
                </div>
</template>
