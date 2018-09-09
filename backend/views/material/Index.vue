<template>
    <div id="material-index">
        <ck-upload @action="handleImg($event)"></ck-upload>
        <el-row>
            <el-col :span="4" :key="item.id" v-for="item in fileList">
                <el-card :body-style="{ padding: '0px', margin: '0 20px 30px 0', 'text-align': 'center' }">
                    <img :src="item.url" class="image">
                    <div style="padding: 14px;">
                        <span>好吃的汉堡</span>
                        <div class="bottom clearfix">
                            <time class="time">{{ currentDate }}</time>
                            <el-button type="text" class="button">操作按钮</el-button>
                        </div>
                    </div>
                </el-card>
            </el-col>
        </el-row>
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
    </div>
</template>

<script>
    import ckUpload from "../../components/CkUpload"
    import { fetchList, del } from "../../api/materials"
    export default {
        name: "Index",
        data() {
            return {
                fileList: [],
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
                    this.fileList = response.data.data.data
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
            handleImg(img) {
                this.fetchData()
            },
        },
        components: {
            ckUpload
        }
    }
</script>

<style scoped>

</style>