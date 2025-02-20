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
                name: "",
                email: "",
                salary: "",
                address: "",
                nid: "",
                photo: '',
                phone: "",
                joining_date: "",
            },
            errors: {},
        };
    },
    created() {
        let id = this.$route.params.id;
        axios
            .get("/api/employee/" + id)
            .then(({ data }) => {
                this.form = data;
                
            })
            .catch((err) => console.log(err));
    },
    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {
                notification.image_validation();
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.photo = event.target.result;
                    
                };
                reader.readAsDataURL(file);
            }
        },
        updateEmployee() {
            let id = this.$route.params.id;

            if (!this.form.photo.startsWith("data:image")) {
                this.form.photo = this.form.photo; // পুরাতন ছবি ধরে রাখো
            }

            axios
                .put("/api/employee/" + id, this.form)
                .then((res) => {
                    console.log(res.data);
                    notification.success();
                    this.$router.push("/employees");
                })
                .catch((error) => (this.errors = error.response.data.errors));
        },
    },
};
</script>

<template>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card p-4">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">Register a new Employee</h5>
                    <router-link class="btn btn-info" to="/employees"
                        >All Employee</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="updateEmployee"
                        enctype="multipart/form-data"
                    >
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
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
                                        placeholder="Enter your email"
                                        v-model="form.email"
                                    />
                                    <p class="text-danger" v-if="errors.email">
                                        {{ errors.email[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="address"
                                        placeholder="Enter Your Address"
                                        v-model="form.address"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.address"
                                    >
                                        {{ errors.address[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Salary</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="salary"
                                        placeholder="Enter Your Salary"
                                        v-model="form.salary"
                                    />
                                    <p class="text-danger" v-if="errors.salary">
                                        {{ errors.salary[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">NID</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="text"
                                        name="nid"
                                        placeholder="Enter Your NID"
                                        v-model="form.nid"
                                    />
                                    <p class="text-danger" v-if="errors.nid">
                                        {{ errors.nid[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label"
                                        >Joning Date</label
                                    >
                                    <input
                                        class="form-control form-control-lg"
                                        type="date"
                                        name="joining_date"
                                        v-model="form.joining_date"
                                    />
                                    <p
                                        class="text-danger"
                                        v-if="errors.joining_date"
                                    >
                                        {{ errors.joining_date[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="number"
                                        name="phone"
                                        placeholder="Enter Your Phone"
                                        v-model="form.phone"
                                    />
                                    <p class="text-danger" v-if="errors.phone">
                                        {{ errors.phone[0] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="image">Photo</label>
                                    <input
                                        class="form-control form-control-lg"
                                        type="file"
                                        name="image"
                                        @change="onFileSelected"
                                    />
                                    <p class="text-danger" v-if="errors.photo">
                                        {{ errors.photo[0] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <img :src="form.photo ? form.photo : ''" width="100" height="100" class="img-responsive img-fluid" alt="Employee Photo" />

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
