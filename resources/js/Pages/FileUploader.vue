<template>
    <app-layout>
        <template #header>
            <h1>File Uploader</h1>
        </template>

        <div>
            <dropzone
                id="file-dropzone"
                @drop="handleFileDrop"
                :options="dropzoneOptions"
            >
                <div class="dz-message" data-dz-message>
                    <span>Drop files here or click to upload.</span>
                </div>
            </dropzone>
            <div v-if="uploadProgress !== null">
                <progress :value="uploadProgress" max="100"></progress>
                <p>Uploading... {{ uploadProgress }}%</p>
            </div>
        </div>
    </app-layout>
</template>

<script>
import vueDropzone from "dropzone-vue3";
export default {
    components: {
        vueDropzone,
    },
    data() {
        return {
            uploadProgress: null,
            dropzoneOptions: {
                url: "upload-file",
                maxFilesize: 10240, // 10GB
                timeout: 0,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                init: function () {
                    this.on("totaluploadprogress", (progress) => {
                        this.uploadProgress = progress;
                    });
                },
            },
        };
    },
    methods: {
        handleFileDrop(file) {
            console.log("File dropped:", file);
        },
    },
};
</script>
