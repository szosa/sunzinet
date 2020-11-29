<template>
    <b-tr>
        <b-td>
            <template v-if="!editMode">{{file.name}}</template>
            <b-form inline v-else>
                <b-input v-model="file.name"></b-input>
                <b-button @click="saveName">Zapisz</b-button>
            </b-form>
        </b-td>
        <b-td>{{file.size}}</b-td>
        <b-td>
            <b-button type="button" variant="info" @click="toggleEditMode">Zmień nazwę
                <b-icon-pencil-square></b-icon-pencil-square>
            </b-button>
            <b-button type="button" variant="danger" @click="deleteFile">Usuń
                <b-icon-trash></b-icon-trash>
            </b-button>
            <b-button type="button" variant="success" @click="downloadFile">Pobierz
                <b-icon-download></b-icon-download>
            </b-button>

        </b-td>
    </b-tr>
</template>

<script>
    import authHeader from "../services/authorization-header.service";

    export default {
        name: "TableRow",
        props: {
            file: Object
        },
        data() {
            return {
                editMode: false
            }
        },
        methods: {
            toggleEditMode() {
                this.editMode = !this.editMode;
            },
            saveName() {
                this.$http.put('/change-file-name/' + this.file.id, {
                    newName: this.file.name,
                }, {headers: authHeader()}).then(() => {
                    this.editMode = false
                })
            },
            deleteFile() {
                this.$http.delete('/delete-file/' + this.file.id, {
                    headers: authHeader()
                }).then(() => {
                    this.$emit('removeFile', this.file);
                })
            },
            downloadFile() {
                this.$http.get('/download/' + this.file.id, {
                    headers: authHeader(),
                    responseType: 'arraybuffer'
                }).then(res => {
                    let blob = new Blob([res.data], {type: 'application/*'});
                    let link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = this.file.name;
                    link.click();
                })
            }
        }
    }
</script>

<style scoped>

</style>