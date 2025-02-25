<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-4 text-uppercase">Pay Salaries</h3>
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
                            <th>Salary Month</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="salary in filterSearch" :key="salary.salary_month">
                            <td>
                                {{ salary.salary_month }}
                            </td>
                            <td>
                                <router-link :to="{name: 'view-salary', params: {id: salary.salary_month}}" class="btn btn-sm btn-info me-2"
                                    >View Salary</router-link
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
            salaries: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.salaries.filter((salary) => {
                return salary.salary_month.match(this.searchTerm);
            });
        },
    },
    methods: {
        allSalaries() {
            axios
                .get("/api/salary")
                .then(({ data }) => (this.salaries = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

    },
    created() {
        this.allSalaries();
    },
};
</script>
