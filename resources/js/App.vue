<template>
    <div id="app">
        <router-link to="/"></router-link>
        <router-link to="/register"></router-link>
        <div class="wrapper">
            <Sidebar v-if="!hiddenRoutes.includes(currentRoute)" />
            <div class="main">
                <Navbar v-if="!hiddenRoutes.includes(currentRoute)" />
                <main class="content">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <router-view></router-view>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "./components/Navbar.vue";
import Sidebar from "./components/Sidebar.vue";
// import EmployeeCreate from './components/employee/create.vue';

export default {
    components: { Navbar, Sidebar },
    computed: {
        currentRoute() {
            return this.$route.path; 
        },
        hiddenRoutes() {
            return ["/", "/register", "/forgot-password"]; 
        },
    },
};
</script>
