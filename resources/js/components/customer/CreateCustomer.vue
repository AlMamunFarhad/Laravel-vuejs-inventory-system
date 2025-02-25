
<script>
import User from "../../Helpers/User";
import notification from "../../Helpers/Notification";

export default {
    mounted() {
        if (!User.loggedIn()) {  // ডিবাগিংয়ের জন্য
            this.$router.push("/");
        }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                address: '',
                photo: '',
                phone: '',
            },
            errors: {},
        };
    },
    methods: {
        onFileSelected(event) {
            let file = event.target.files[0];
            if (file.size > 1048770) {  
                notification.image_validation();  
            } else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result
                    console.log(event.target.result)
                }
                reader.readAsDataURL(file);
            }
        },
        insertCustomer() {
            axios.post('/api/customer', this.form)
            .then(res => {
                notification.success();
                this.$router.push("customers")
                
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
                    <h5 class="card-title">Register a new Customer</h5>
                    <router-link class="btn btn-info" to="/employees"
                        >Customers</router-link
                    >
                </div>
                <div class="card-body">
                    <form
                        @submit.prevent="insertCustomer"
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
                                <img
                                    :src="form.photo"
                                    width="100"
                                    height="100"
                                    class="img-responsive img-fluid"
                                    alt=""
                                />
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
