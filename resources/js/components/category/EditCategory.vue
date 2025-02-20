<script>
import User from "../../Helpers/User";
import notification from "../../Helpers/Notification";
import axios from "axios";

export default {
    mounted() {
        if (!User.loggedIn()) {
            console.log("User not logged in");
            this.$router.push("/");
        }
    },
    data() {
        return {
            form: {
                category_name: "",
            },
            errors: {},
        };
    },
    created() {
        let id = this.$route.params.id;
        axios
            .get("/api/category/" + id)
            .then(({ data }) => {
                this.form = data;
            })
            .catch((err) => console.log(err));
    },
    methods: {
        updateCategory() {
            let id = this.$route.params.id;
            axios
                .put("/api/category/" + id, this.form)
                .then((res) => {
                    console.log(res.data);
                    notification.success();
                    this.$router.push("/categories");
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Update Category</h5>
                    <router-link class="btn btn-info" to="/categories"
                        >Categories</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="updateCategory">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Update Category</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="category_name"
                                        placeholder="Enter your name"
                                        v-model="form.category_name"
                                    />
                                    <p class="text-danger" v-if="errors.category_name">
                                        {{ errors.category_name[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3 d-block">
                            <button type="submit" class="btn btn-lg btn-info">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
