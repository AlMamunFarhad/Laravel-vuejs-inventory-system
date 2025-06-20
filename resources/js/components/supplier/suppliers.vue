<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Suppliers</h3>
                    <input
                        type="text"
                        style="width: 20rem"
                        class="form-control"
                        placeholder="Search"
                        v-model="searchTerm"
                    />
                </div>
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Shop Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="supplier in filterSearch" :key="supplier.id">
                            <td>
                                <img
                                    :src="supplier.photo"
                                    class="img-fluid img-thumbnail img-responsive"
                                    alt=""
                                    width="100"
                                    height="100"
                                />
                            </td>
                            <td>{{ supplier.name }}</td>
                            <td>{{ supplier.email }}</td>
                            <td>{{ supplier.phone }}</td>
                            <td>{{ supplier.address }}</td>
                            <td>{{ supplier.shop_name }}</td>
                            <td>
                                <router-link :to="{name: 'edit-supplier', params: {id: supplier.id}}" class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                                <a
                                    @click="deleteEmployee(supplier.id)"
                                    class="btn btn-sm btn-danger"
                                    >Delete</a
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
            suppliers: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.suppliers.filter((supplier) => {
                return supplier.phone.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSupplier() {
            axios
                .get("/api/supplier/")
                .then(({ data }) => (this.suppliers = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

        deleteEmployee(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete("/api/supplier/" + id)
                .then(() => {
                    this.suppliers = this.suppliers.filter((supplier) => supplier.id != id);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                })
                .catch(() => {
                    this.$router.push("suppliers");
                });
        }
    });
},


    },
    created() {
        this.allSupplier();
    },
};
</script>
