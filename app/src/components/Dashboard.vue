<template>
    <b-col md="6" offset-md="3">
        <UploadFile @addFile="addFile"></UploadFile>
        <b-table-simple>
            <b-thead>
                <b-tr>
                    <b-th>
                        Nazwa pliku
                    </b-th>
                    <b-th>
                        Rozmiar
                    </b-th>
                    <b-th>
                        Akcje
                    </b-th>
                </b-tr>
            </b-thead>
            <b-tbody>
                <TableRow v-for="file in files" :file="file" :key="file.id" @removeFile="removeFile"></TableRow>
            </b-tbody>
        </b-table-simple>
    </b-col>
</template>

<script>
    import authHeader from "../services/authorization-header.service";
    import UploadFile from "./UploadFile";
    import TableRow from "./TableRow";

    export default {
        name: "Dashboard",
        components: {
            UploadFile,
            TableRow
        },
        data() {
            return {
                files: null
            }
        },
        mounted() {
            this.$http.get('/get-user-files', {headers: authHeader()})
                .then((res) => {
                    this.files = res.data
                });
        },
        methods: {
            removeFile(file) {
                for (let i = 0; i < this.files.length; i++) {
                    if (this.files[i].id === file.id) {
                        this.files.splice(i, 1);
                    }
                }
            },
            addFile(file) {
                this.files.unshift(file);
            }
        }

    }
</script>

<style scoped>

</style>