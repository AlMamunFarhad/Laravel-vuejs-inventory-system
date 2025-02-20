<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Categories</h3>
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
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in filterSearch" :key="category.id">
                            <td>{{ category.category_name }}</td>
         
                            <td>
                                <router-link :to="{name: 'edit-category', params: {id: category.id}}" class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                                <a
                                    @click="deleteCategory(category.id)"
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
            categories: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.categories.filter((category) => {
                return category.category_name.match(this.searchTerm);
            });
        },
    },
    methods: {
        allCategory() {
            axios
                .get("/api/category/")
                .then(({ data }) => (this.categories = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

        deleteCategory(id) {
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
            axios.delete("/api/category/" + id)
                .then(() => {
                    this.categories = this.categories.filter((category) => category.id != id);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                })
                .catch(() => {
                    this.$router.push("/categories");
                });
        }
    });
},


    },
    created() {
        this.allCategory();
    },
};
</script>
