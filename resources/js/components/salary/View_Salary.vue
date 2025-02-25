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
                            <th>Name</th>
                            <th>Month</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="salary in filterSearch" :key="salary.id">
                            <td>{{ salary.name }}</td>
                            <td>{{ salary.salary_month }}</td>
                            <td>{{ salary.amount }}</td>
                            <td>{{ salary.salary_date }}</td>
                            <td>
                                <router-link :to="{name: 'edit-salary', params: {id: salary.id}}" class="btn btn-sm btn-info me-2"
                                    >Edit Salary</router-link
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
            viewSalaries: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.viewSalaries.filter((viewSalary) => {
                return viewSalary.salary_month.match(this.searchTerm);
            });
        },
    },
    methods: {
        viewSalary() {
            let id = this.$route.params.id;
            axios
                .get(`/api/salary/view/${id}`)
                .then(({ data }) => (this.viewSalaries = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

    },
    created() {
        this.viewSalary();
    },
};
</script>
