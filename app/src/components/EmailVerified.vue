<template>
    <b-col md="6" offset-md="3">
        <b-alert variant="success" show>Email został zewryfikowany poprawnie, klinkij
            <router-link to="/">TUTAJ</router-link>
            aby się zalogować
        </b-alert>
    </b-col>
</template>

<script>
    export default {
        name: "EmailVerified"
    }
</script>

<style scoped>

</style>