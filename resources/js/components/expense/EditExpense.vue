<script>
import User from "../../Helpers/User";
import notification from "../../Helpers/Notification";
import axios from "axios";

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
                amount: '',
                details: '',
                expense_date: '',
            },
            errors: {},
        };
    },
    created() {
        let id = this.$route.params.id;
        axios
            .get("/api/expense/" + id)
            .then(({ data }) => {
                this.form = data;
            })
            .catch((err) => console.log(err));
    },
    methods: {
        updateExpense() {
            let id = this.$route.params.id;
            axios.put(`/api/expense/${id}`, this.form)
            .then(res => {
                notification.success();
                this.$router.push("/expenses");
                
            })
            .catch(error => this.errors = error.response.data.errors)
        },
    },
};
</script>
<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Update Expense</h5>
                    <router-link class="btn btn-info" to="/expenses"
                        >Expenses</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="updateExpense">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="amount"
                                        placeholder="Enter your amount"
                                        v-model="form.amount"
                                    />
                                    <p class="text-danger" v-if="errors.amount">
                                        {{ errors.amount[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Details</label>
                                    <textarea
                                        class="form-control form-control-lg"
                                        type="textarea"
                                        name="details"
                                        placeholder="Enter your Details"
                                        v-model="form.details"
                                    />
                                    <p class="text-danger" v-if="errors.details">
                                        {{ errors.details[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Expense Date</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="date"
                                        name="expense_date"
                                        placeholder="Enter your Expense Date"
                                        v-model="form.expense_date"
                                    />
                                    <p class="text-danger" v-if="errors.expense_date">
                                        {{ errors.expense_date[0] }}
                                    </p>
                                </div>
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
