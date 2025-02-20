<script>
export default {
    
}
</script>
<template>
    <div>
        <div class="row">
            <div class="col-md-4 mt-4">
                <div class="card p-4">
                    <h4 class="card-title">Forgot Password</h4>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label"
                                    >Existing Email Address</label
                                >
                                <input
                                    class="form-control form-control-lg"
                                    type="email"
                                    name="email"
                                    placeholder="Enter your email"
                                />
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <button
                                    type="submit"
                                    class="btn btn-lg btn-primary"
                                >
                                    Forgot Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mb-3">
                    Don't have an account?
                    <router-link to="/register">Sign up</router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<style></style>
