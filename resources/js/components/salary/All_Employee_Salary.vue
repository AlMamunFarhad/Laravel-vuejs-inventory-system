<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-4 text-uppercase">Employee Salary Pay</h3>
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
                            <th>Salary</th>
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
                            <td>{{ employee.salary }}</td>
                            <td>
                                <router-link :to="{name: 'pay-salary', params: {id: employee.id}}" class="btn btn-sm btn-info me-2"
                                    >Pay Salary</router-link
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

    },
    created() {
        this.allEmployee();
    },
};
</script>
