<template>
    <div id="material-index">
        <el-upload
                action="/admin/materials/upload"
                :headers="headers"
                list-type="picture-card"
                :file-list="fileList"
                :on-preview="handlePictureCardPreview"
                :on-success="handleSuccess"
                :before-remove="handleRemove">
            <i class="el-icon-plus"></i>
        </el-upload>
        <div class="page-section">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </div>
        <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
    </div>
</template>

<script>
    import { fetchList, del } from "../../api/materials"
    import { HEADERS } from "../../api/upload"
    export default {
        name: "Index",
        data() {
            return {
                headers: HEADERS,
                fileList: [],
                dialogImageUrl: "",
                dialogVisible: false,
                currentPage: 1,
                pageSize: 15,
                total: 0,
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                let query = Object.assign({page: this.currentPage, pageSize: this.pageSize, status: 1}, this.query)
                fetchList(query).then((response) => {
                    this.fileList = response.data.data.data.map((item) => {
                        return { id: item.id, name: item.title, url: item.url}
                    })
                    this.currentPage = response.data.data.current_page
                    this.total = response.data.data.total
                })
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList) {
                this.fetchData()
            },
            handleRemove(file, fileList) {
                let that = this
                this.$confirm('确认删除？').then(_ => {
                    del(file.id).then((response) => {
                        that.fetchData()
                    })
                    return true
                }).catch(_ => {})
                return false
            },
            handleSizeChange(val) {
                this.pageSize = val
                this.fetchData();
            },
            handleCurrentChange(val) {
                this.currentPage = val
                this.fetchData();
            },
        }
    }
</script>

<style scoped>

</style>