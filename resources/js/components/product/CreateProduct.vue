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
                product_name: '',
                product_code: '',
                category_id: '',
                supplier_id: '',
                root: '',
                buying_price: '',
                selling_price: '',
                buying_date: '',
                product_quantity: '',
                image: '',
            },
            errors: {},
            categories: {},
            suppliers: {},
        };
    },
    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {  
                notification.image_validation();  
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result
                    console.log(event.target.result)
                }
                reader.readAsDataURL(file);
            }
        },
        insertEmployee() {
            axios.post('/api/product', this.form)
            .then(res => {
                notification.success();
                this.$router.push("/products");
                
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    },
    created(){
            axios.get('/api/category/')
            .then(({data}) => console.log(data))
            .catch((error) => (this.errors = error.response.data.errors));
        },
        created(){
            axios.get('/api/supplier/')
            .then(({data}) => (this.suppliers = data))
            .catch((error) => (this.errors = error.response.data.errors));
        },
};
</script>


<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Add a new Product</h5>
                    <router-link class="btn btn-info" to="/products"
                        >Products</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="insertProduct"
                        enctype="multipart/form-data"
                    >
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Product name</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="product_name"
                                        placeholder="Enter your product name..."
                                        v-model="form.product_name"
                                    />
                                    <p class="text-danger" v-if="errors.product_name">
                                        {{ errors.product_name[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Product code</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="product_code"
                                        placeholder="Enter your product code..."
                                        v-model="form.product_code"
                                    />
                                    <p class="text-danger" v-if="errors.product_code">
                                        {{ errors.product_code[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Categories</label>
                                <select class="form-select form-control-lg form-control" v-model="form.category_id">
                                    <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.category_name }}</option>
                                    <option value="">1</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Suppliers</label>
                                <select class="form-select form-control-lg form-control" v-model="form.supplier_id">
                                    <option :value="supplier.id" v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Root</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="root"
                                        placeholder="Enter Your Root"
                                        v-model="form.root"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.root"
                                    >
                                        {{ errors.root[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Buying price</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="buying_price"
                                        placeholder="Enter Your Buying price"
                                        v-model="form.buying_price"
                                    />
                                    <p class="text-danger" v-if="errors.buying_price">
                                        {{ errors.buying_price[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Selling price</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="selling_price"
                                        placeholder="Enter Your Selling price"
                                        v-model="form.selling_price"
                                    />
                                    <p class="text-danger" v-if="errors.selling_price">
                                        {{ errors.selling_price[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Buying date</label
                                    >
                                    <input
                                        class="form-control form-control-lg"
                                        type="date"
                                        name="buying_date"
                                        v-model="form.buying_date"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.buying_date"
                                    >
                                        {{ errors.buying_date[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="product_quantity">Product quantity</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="product_quantity"
                                        v-model="form.product_quantity"
                                    />
                                    <p class="text-danger" v-if="errors.product_quantity">
                                        {{ errors.product_quantity[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="image">Photo</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="file"
                                        name="image"
                                        @change="onFileSelected"
                                    />
                                    <p class="text-danger" v-if="errors.photo">
                                        {{ errors.photo[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <img
                                    :src="form.photo"
                                    width="100"
                                    height="100"
                                    class="img-responsive img-fluid"
                                    alt=""
                                />
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
