<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Stocks</h3>

                    <div class="">
                        <div class="d-flex justify-content-end">
                            <router-link
                                to="/products"
                                class="btn btn-info mb-3"
                                >Products</router-link
                            >
                        </div>
                        <input
                            type="text"
                            style="width: 20rem"
                            class="form-control"
                            placeholder="Search"
                            v-model="searchTerm"
                        />
                    </div>
                </div>
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Buying Price</th>
                            <th>Product Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filterSearch" :key="product.id">
                            <td>
                                <img
                                    :src="product.image"
                                    class="img-fluid img-thumbnail img-responsive"
                                    alt=""
                                    width="100"
                                    height="100"
                                />
                            </td>
                            <td>{{ product.category_name }}</td>
                            <td>{{ product.product_name }}</td>
                            <td>{{ product.product_code }}</td>
                            <td>{{ product.buying_price }}</td>
                            <td>{{ product.product_quantity }}</td>
                            <td>
                                <span v-if="product.product_quantity > 0" class="badge bg-success">Available</span>
                                <span v-else class="badge bg-danger">Out of Stock</span>
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'edit-stock',
                                        params: { id: product.id },
                                    }"
                                    class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import User from "../../Helpers/User";

export default {
    mounted() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
    },
    data() {
        return {
            products: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.products.filter((product) => {
                return product.product_code.match(this.searchTerm);
            });
        },
    },
    methods: {
        allProducts() {
            axios
                .get("/api/product/")
                .then(({ data }) => (this.products = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
    created() {
        this.allProducts();
    },
};
</script>
<style>
table th {
    text-transform: uppercase;
}
</style>
