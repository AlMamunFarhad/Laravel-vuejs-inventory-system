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
              name: '',
              email: '',
              salary: '',
              att_month: '',
            },
            errors: {},
            employees: {},
        };
    },
    methods: {
        paySalary() {
            let id =this.$route.params.id;
            axios.post('/api/salary/paid/'+ id, this.form)
            .then(res => {
                notification.success();
                this.$router.push("/given-salary");
            }).catch(error => this.errors = error.response.data.errors)
        },
    },
    
    created() {
        let id = this.$route.params.id;
        axios
            .get(`/api/employee/${id}`)
            .then(({ data }) => {
                return (this.form = data);
            })
            .catch((error) => (this.errors = error.response.data.errors));
    },
};
</script>
<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Update Salary</h5>
                    <router-link class="btn btn-info" to="/given-salary"
                        >Salaries</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="paySalary">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="name"
                                        placeholder="Enter your name"
                                        v-model="form.name"
                                    />
                                    <p class="text-danger" v-if="errors.name">
                                        {{ errors.name[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="email"
                                        name="email"
                                        placeholder="Enter Your email"
                                        v-model="form.email"
                                    />
                                    <p class="text-danger" v-if="errors.email">
                                        {{ errors.email[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Pay Salary to Month</label>
                                    <select name="employee_id" v-model="form.att_month" id="" class="form-control form-control-lg">
                                      <option value="January">January</option>
                                      <option value="Fabruary">Fabruary</option>
                                      <option value="March">March</option>
                                      <option value="April">April</option>
                                      <option value="May">May</option>
                                      <option value="June">June</option>
                                      <option value="July">July</option>
                                      <option value="August">August</option>
                                      <option value="September">September</option>
                                      <option value="October">October</option>
                                      <option value="November">November</option>
                                      <option value="December">December</option>
                                    </select>
                                    <p class="text-danger" v-if="errors.att_month">
                                        {{ errors.att_month[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Salary</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="salary"
                                        placeholder="Enter Your salary year"
                                        v-model="form.salary"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.salary"
                                    >
                                        {{ errors.salary[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3 d-block">
                            <button type="submit" class="btn btn-lg btn-info">
                                Pay Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
