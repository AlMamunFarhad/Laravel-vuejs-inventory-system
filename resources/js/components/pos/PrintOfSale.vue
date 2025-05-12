<template>
    <div class="row">
        <div class="col-md-5 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Print of Sale</h3>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-7 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Products</h3>
                    <input
                        type="text"
                        style="width: 20rem"
                        class="form-control"
                        placeholder="Search..."
                        v-model="getSearchTerm"
                    />
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                             class="nav-link"
                            :class="{ active: selectedCategory === null }"
                            @click="showAllProducts"
                        >
                            All Products
                        </button>
                    </li>
                    <li
                        class="nav-item"
                        role="presentation"
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <button
                            class="nav-link"
                            :class="{
                                active: selectedCategory === category.id,
                            }"
                            :id="'category-tab-' + category.id"
                            type="button"
                            @click="productByCategory(category.id)"
                        >
                            {{ category.category_name }}
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div
                        class="tab-pane fade show active"
                        id="home-tab-pane"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                        tabindex="0"
                    >
                        <div class="card-body">
                            <div class="row">
                                <div
                                    class="col-lg-3 col-md-3 col-sm-6 col-6 m-3"
                                    v-for="getProduct in filteredProducts"
                                    :key="getProduct.id"
                                >
                                    <a href="">
                                        <img
                                            :src="getProduct.image"
                                            class="img-fluid img-thumbnail img-responsive card-img-top"
                                            alt=""
                                            width="100"
                                            height="100"
                                        />
                                        <h5 class="card-title mt-2">
                                            {{ getProduct.product_name }}
                                        </h5>
                                        <span
                                            class="badge badge-success bg-success"
                                            v-if="
                                                getProduct.product_quantity >= 1
                                            "
                                        >
                                            Available ({{
                                                getProduct.product_quantity
                                            }})
                                        </span>
                                        <span
                                            class="badge badge-danger bg-danger"
                                            v-else
                                        >
                                            Stock Out
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            form: {
                details: "",
                amount: "",
            },
            selectedCategory: null,
            products: [],
            searchTerm: "",
            categories: [],
            getProducts: [],
            getSearchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.products.filter((product) => {
                return product.product_name.match(this.searchTerm);
            });
        },

        getFilterSearch() {
            return this.getProducts.filter((getProduct) => {
                return getProduct.product_name
                    .toLowerCase()
                    .includes(this.getSearchTerm.toLowerCase());
            });
        },

        filteredProducts() {
            return this.selectedCategory === null
                ? this.products
                : this.getProducts;
        },
    },
    methods: {

        allProducts() {
            axios
                .get("/api/product/")
                .then(({ data }) => {
                    this.products = data;
                    this.getProducts = [...data]; 
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },

        allCategories() {
            axios
                .get("/api/category/")
                .then(({ data }) => (this.categories = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },
       
        productByCategory(id) {
            this.selectedCategory = id; 
            axios
                .get(`/api/getting/product/${id}`)
                .then(({ data }) => {
                    console.log("Category Products:", data);
                    this.getProducts = data.length ? [...data] : [];
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },

        showAllProducts() {
            this.selectedCategory = null;
            this.allProducts(); 
        },
    },
    created() {
        this.allProducts();
        this.allCategories();
    },
};
</script>
<style>
table th {
    text-transform: uppercase;
}
</style>
