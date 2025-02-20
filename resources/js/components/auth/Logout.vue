<script>
export default {
    mounted() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");

        Toast.fire({
            icon: "success",
            title: "Signed out successfully",
        });
        this.$router.push("/");
    }
}

 </script>




<template>
    <div></div>
</template>
