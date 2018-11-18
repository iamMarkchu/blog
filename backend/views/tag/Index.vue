<template>
    <div id="tag-index">
        <ck-table-page
                ref="table"
                :col-data="colData"
                :fetch-list="fetchList">
            <el-table-column slot="name" label="标签名字" align="center">
                <template slot-scope="scope">
                    <a :href="'/tags/' + scope.row.url_name">{{ scope.row.name }}</a>
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
    import { fetchList, del, revoke } from '../../api/tags'
    import CkTablePage from "../../components/CkTablePage"
    export default {
        name: "TagIndex",
        created() {
            this.colData = [
                { prop: 'id', label: '编号' },
                { slot: 'name' },
                { prop: 'display_order', label: '排序' },
                { slot: 'status' },
                { prop: 'user.name', label: '创建人' },
                { prop: 'created_at', label: '创建时间' },
                { prop: 'updated_at', label: '更新时间' },
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                fetchList: fetchList,
                colData: [],
            }
        },
        methods: {
            handleEdit(id) {
                this.$router.push('/tag/edit/'+ id)
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