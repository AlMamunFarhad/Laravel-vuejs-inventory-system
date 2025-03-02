<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Customers</h3>
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in filterSearch" :key="customer.id">
                            <td>
                                <img
                                    :src="customer.photo"
                                    class="img-fluid img-thumbnail img-responsive"
                                    alt=""
                                    width="100"
                                    height="100"
                                />
                            </td>
                            <td>{{ customer.name }}</td>
                            <td>{{ customer.email }}</td>
                            <td>{{ customer.phone }}</td>
                            <td>{{ customer.address }}</td>
                            <td>
                                <router-link :to="{name: 'edit-customer', params: {id: customer.id}}" class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                                <a
                                    @click="deleteCustomer(customer.id)"
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
            customers: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.customers.filter((customer) => {
                return customer.phone.match(this.searchTerm);
            });
        },
    },
    methods: {
        allCustomer() {
            axios
                .get("/api/customer/")
                .then(({ data }) => (this.customers = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

        deleteCustomer(id) {
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
            axios.delete("/api/customer/" + id)
                .then(() => {
                    this.customers = this.customers.filter((customer) => customer.id != id);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                })
                .catch(() => {
                    this.$router.push("/customers");
                });
           }
    });
},

    },
    created() {
        this.allCustomer();
    },
};
</script>
