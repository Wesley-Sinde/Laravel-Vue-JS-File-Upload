
<template>
    <div class="container" style="margin-top: 50px;">
        <div class="text-center">
            <h4>File Upload with VueJS and Laravel By Wesley-sinde</h4><br>
            <div style="max-width: 500px; margin: 0 auto;">
                <div v-if="success !== ''" class="alert alert-success" role="alert">
                    {{success}}
                </div>
                <form @submit="submitForm" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="filename" class="custom-file-input" id="inputFileUpload"
                                   v-on:change="onFileChange">
                            <label class="custom-file-label" for="inputFileUpload">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <input type="submit" class="btn btn-primary" value="Upload">
                        </div>
                    </div>
                    <br>
                    <p class="text-danger font-weight-bold">{{filename}}</p>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component successfully mounted.')
        },
        data() {
            return {
                filename: '',
                file: '',
                success: ''
            };
        },
        methods: {
            onFileChange(e) {
                //console.log(e.target.files[0]);
                this.filename = "Selected File: " + e.target.files[0].name;
                this.file = e.target.files[0];
            },
            submitForm(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }
                // form data
                let formData = new FormData();
                formData.append('file', this.file);
                // send upload request
                axios.post('/store_file', formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                        currentObj.filename = "";
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            }
        }
    }
</script>