<template>
    <div id="image-single">
        <el-upload
                :name="name"
                :action="action"
                :headers="headers"
                :show-file-list="false"
                :file-list="fileList"
                :on-preview="onPreview"
                :on-success="onSuccess"
                :on-remove="onRemove"
                :disabled="disabled"
                :on-exceed="onExceed"
                :limit="1">
            <el-button size="small" type="primary">点击上传</el-button>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
    </div>
</template>

<script>
    import { ASSETS_URL, UPLOAD_URL, HEADERS } from '../api/upload'
    export default {
        name: "image-single",
        props: ["image"],
        created() {
            this.initImage()
        },
        watch: {
            image() {
                this.initImage()
            }
        },
        data() {
            return {
                name: 'file',
                action: UPLOAD_URL,
                headers: HEADERS,
                disabled: false,
                dialogVisible: false,
                dialogImageUrl: '',
                file: '',
                fileList: [],
            }
        },
        methods: {
            onPreview(file) {
                this.dialogImageUrl = file.url
                this.dialogVisible = true
            },
            onSuccess(response, file, fileList) {
                this.$message("上传成功")
                this.$emit('action', response)
            },
            onExceed(files, fileList) {
                this.$message.error('只能上传一张图片，请删除后再试')
            },
            onRemove(file, fileList) {
                this.$emit('action', '')
            },
            initImage() {

            }
        }
    }
</script>

<style scoped>

</style>