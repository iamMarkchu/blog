<template>
    <div id="material-index">
        <ck-upload @action="handleImg($event)"></ck-upload>
        <el-button size="small" type="success" @click="handleImport()">确定</el-button>
        <el-row style="margin-bottom: 10px;">
            <el-col :span="spanNum" v-for="(o, index) in fileList" :key="index">
                <div :class="{selected: selected == o }" @click="handleSelected(o)">
                    <i class="el-icon-success" v-show="selected == o"></i>
                    <img :src="o.url" class="image" :width="imageWidth" :height="imageHeight">
                </div>
            </el-col>
        </el-row>
        <div class="page-section" style="margin-bottom: 20px;">
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
        name: "MaterialIndex",
        props: {
            isArticle: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                spanNum: 4,
                imageWidth: 300,
                imageHeight: 200,
                fileList: [],
                currentPage: 1,
                pageSize: 15,
                total: 0,
                selected: null,
            }
        },
        created() {
            if (this.isArticle)
            {
                this.spanNum = 6
                this.imageHeight = 120;
                this.imageWidth = 180;
            }
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
            handleSelected(o) {
                if (this.selected != o)
                    this.selected = o
                else
                    this.selected = null
            },
            handleImport() {
                if (this.selected == null)
                {
                    this.$message.error('请选择图片')
                    return;
                }
                console.log(this.selected)
                this.$emit("done", this.selected.url)
            }
        },
        components: {
            ckUpload
        }
    }
</script>

<style scoped>
    #material-index {
        margin-bottom: 30px;
    }
    .selected {
        opacity: .5;
        position: relative;
    }
    .selected i {
        position: absolute;
        top: 48%;
        left: 48%;
        color: green;
        font-size: 1.5em;
    }
</style>