<template>
    <div class="row">
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill p-4">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title mb-0 fs-2">Expenses</h3>
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
                            <th>Amount</th>
                            <th>Details</th>
                            <th>Expense Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="expense in filterSearch" :key="expense.id">
                            <td>{{ expense.amount }}</td>
                            <td>{{ expense.details }}</td>
                            <td>{{ expense.expense_date }}</td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'edit-expense',
                                        params: { id: expense.id },
                                    }"
                                    class="btn btn-sm btn-warning me-2"
                                    >Edit</router-link
                                >
                                <a
                                    @click="deleteExpense(expense.id)"
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
            expenses: [],
            searchTerm: "",
        };
    },
    computed: {
        filterSearch() {
            return this.expenses.filter((expense) => {
                return expense.expense_date.match(this.searchTerm);
            });
        },
    },
    methods: {
        allExpense() {
            axios
                .get("/api/expense")
                .then(({ data }) => (this.expenses = data))
                .catch((error) => (this.errors = error.response.data.errors));
        },

        deleteExpense(id) {
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
                    axios
                        .delete("/api/expense/" + id)
                        .then(() => {
                            this.expenses = this.expenses.filter(
                                (expense) => expense.id != id
                            );
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                        })
                        .catch(() => {
                            this.$router.push("/expenses");
                        });
                }
            });
        },
    },
    created() {
        this.allExpense();
    },
};
</script>
