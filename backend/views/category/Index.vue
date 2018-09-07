<template>
    <div id="category-index">
        <ck-table-page
                ref="table"
                :col-data="colData"
                :fetch-list="fetchList">
            <el-table-column slot="name" label="标签名字" align="center">
                <template slot-scope="scope">
                    <a :href="'http://blog.test/' + scope.row.url_name">{{ scope.row.name }}</a>
                </template>
            </el-table-column>
            <el-table-column slot="status" label="状态" align="center">
                <template slot-scope="scope">
                    <el-tag type="success" v-if="scope.row.status == 1">active</el-tag>
                    <el-tag type="danger" v-else-if="scope.row.status == 2">deleted</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="operation" label="操作">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row.id)">编辑</el-button>
                    <el-button type="info" size="mini" v-show="scope.row.status == 2" @click="handleRevoke(scope.row)">恢复</el-button>
                    <el-button type="danger" size="mini" v-show="scope.row.status == 1" @click="handleDelete(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </ck-table-page>
    </div>
</template>

<script>
    import { FRONT_FULL_URL_WITHOUT_SLASH } from "../../api/upload"
    import CkTablePage from "../../components/CkTablePage"
    import { fetchList, del, revoke } from "../../api/categories"
    let categoryData = [
        {
            id: 0,
            category_name: '类别列表',
            children: [],
        }
    ]
    export default {
        name: "Category-Index",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { slot: 'name' },
                { prop: 'parent_category.name', label: '父类别名称' },
                { prop: 'display_order', label: '排序' },
                { slot: 'status' },
                { prop: 'user.name', label: '创建者' },
                { prop: 'created_at', label: '创建时间' },
                { prop: 'updated_at', label: '更新时间' },
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                colData: [],
                fetchList: fetchList,
                treeData: categoryData,
                defaultProps: {
                    label: 'category_name',
                    children: 'children',
                },
            }
        },
        methods: {
            handleAdd() {
                this.$router.push('/category/add')
            },
            handleEdit(id) {
                this.$router.push('/category/edit/'+ id)
            },
            getFullRequestPath(requestPath) {
                return FRONT_FULL_URL_WITHOUT_SLASH + requestPath
            },
            handleDelete(row) {
                let that = this
                this.$confirm('确认删除？').then(_ => {
                    del(row.id).then((response) => {
                        that.$refs.table.fetchData()
                    })
                }).catch(_ => {})
            },
            handleRevoke(row) {
                let that = this
                this.$confirm('确认恢复？').then(_ => {
                    revoke(row.id).then((response) => {
                        that.$refs.table.fetchData()
                    })
                }).catch(_ => {})
            },
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>

</style>