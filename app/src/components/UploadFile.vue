<template>
    <form method="POST" enctype="multipart/form-data">
        <b-button type="button" variant="success" @click="submitFile" :disabled="selectedFile" v-model="file">Wyślij
        </b-button>
        <input type="file" @change="selectFile">
    </form>
</template>

<script>
    import authHeader from "../services/authorization-header.service";

    export default {
        name: "UploadFile",
        data() {
            return {
                file: null
            }
        },
        methods: {
            selectFile(event) {
                this.file = event.target.files[0];
            },
            submitFile() {
                const formData = new FormData();
                formData.append('file', this.file);
                this.$http
                    .post('upload-file', formData, {headers: authHeader(), 'accept': 'application/json',})
                    .then((res) => {
                        this.$emit('addFile', res.data)
                    })
            }
        },
        computed: {
            selectedFile() {
                return this.file === null;
            }
        }
    }
</script>

<style scoped>

</style>