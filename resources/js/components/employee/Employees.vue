<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Employees</h3>
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
                            <th>Salary</th>
                            <th>Joining Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in filterSearch" :key="employee.id">
                            <td>
                                <img
                                    :src="employee.photo"
                                    class="img-fluid img-thumbnail img-responsive"
                                    alt=""
                                    width="100"
                                    height="100"
                                />
                            </td>
                            <td>{{ employee.name }}</td>
                            <td>{{ employee.email }}</td>
                            <td>{{ employee.phone }}</td>
                            <td>{{ employee.address }}</td>
                            <td>{{ employee.salary }}</td>
                            <td>{{ employee.joining_date }}</td>
                            <td>
                                <router-link :to="{name: 'edit-employee', params: {id: employee.id}}" class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                                <a
                                    @click="deleteEmployee(employee.id)"
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
            employees: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.employees.filter((employee) => {
                return employee.phone.match(this.searchTerm);
            });
        },
    },
    methods: {
        allEmployee() {
            axios
                .get("/api/employee/")
                .then(({ data }) => (this.employees = data))
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
            axios.delete("/api/employee/" + id)
                .then(() => {
                    this.employees = this.employees.filter((employee) => employee.id != id);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                })
                .catch(() => {
                    this.$router.push("employees");
                });
        }
    });
},


    },
    created() {
        this.allEmployee();
    },
};
</script>
