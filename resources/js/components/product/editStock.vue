<script>
import User from "../../Helpers/User";
import notification from "../../Helpers/Notification";

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
                product_quantity: "",
            },
            errors: {},
        };
    },
    methods: {
        updateStock() {
            let id = this.$route.params.id;
            axios
                .put("/api/update/stock/" + id, this.form)
                .then((res) => {
                    notification.success();
                    this.$router.push("/stock");
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
    created() {
        let id = this.$route.params.id;
        axios
            .get(`/api/product/${id}`)
            .then(({ data }) => {
                return (this.form = data);
            })
            .catch((error) => (this.errors = error.response.data.errors));

    },
};
</script>
<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Update Stock</h5>
                    <router-link class="btn btn-info" to="/stock"
                        >Stocks</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="updateStock">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="product_quantity"
                                        >Product quantity</label
                                    >
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="product_quantity"
                                        v-model="form.product_quantity"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.product_quantity"
                                    >
                                        {{ errors.product_quantity[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3 d-block">
                            <button type="submit" class="btn btn-lg btn-info">
                                Update Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
