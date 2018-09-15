<template>
    <div id="article-index">
        <div class="filter-section">
            <el-form :inline="true" :model="query" class="demo-form-inline">
                <el-form-item>
                    <el-input v-model="query.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="query.source" :clearable='true' placeholder="来源">
                        <el-option
                            v-for="item in sourceOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <el-select v-model="query.status" :clearable='true' placeholder="状态">
                        <el-option
                            v-for="item in statusOptions"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <!--<el-form-item>-->
                <!--<el-select v-model="orderBy" :clearable='true' placeholder="排序">-->
                <!--<el-option-->
                <!--v-for="item in orderOptions"-->
                <!--:key="item.value"-->
                <!--:label="item.label"-->
                <!--:value="item.value">-->
                <!--</el-option>-->
                <!--</el-select>-->
                <!--</el-form-item>-->
                <el-form-item>
                    <el-button type="primary" @click="handleSearch">搜索</el-button>
                    <el-button type="primary" @click="handleAdd">创建</el-button>
                </el-form-item>
            </el-form>
        </div>
        <ck-table-page
                ref="table"
                :col-data="colData"
                :fetch-list="fetchList"
                :query="query">
            <el-table-column slot="title" align="center" label="类别" min-width="150">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.categories" v-for="item in scope.row.categories" :key="item.id" class="table-tag">{{item.name}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="title" align="center" label="标签" min-width="150">
                <template slot-scope="scope">
                    <el-tag type="success" v-if="scope.row.tags" v-for="item in scope.row.tags" :key="item.id" class="table-tag">{{item.name}}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="title" align="center" label="标题" min-width="150">
                <template slot-scope="scope">
                    <span class="title" @click="handleViewArticle(scope.row)">《{{scope.row.title}}》</span>
                </template>
            </el-table-column>
            <el-table-column slot="status" label="状态" align="center">
                <template slot-scope="scope">
                    <el-tag :type="showStatus(scope.row.status, 'tag')">{{ showStatus(scope.row.status, "text") }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="source" label="来源" align="center">
                <template slot-scope="scope">
                    <el-tag :type="showSource(scope.row.source, 'tag')">{{ showSource(scope.row.source, 'text') }}</el-tag>
                </template>
            </el-table-column>
            <el-table-column slot="created_updated" label="修改时间" align="center" >
                <template slot-scope="scope">
                    <p>{{ scope.row.updated_at }}</p>
                </template>
            </el-table-column>
            <el-table-column slot="count" label="点击数|点赞数" align="center" >
                <template slot-scope="scope">
                    <p>{{scope.row.click_count}} | {{ scope.row.vote_count }}</p>
                </template>
            </el-table-column>
            <el-table-column slot="operation" label="操作" align="center" width="220">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row.id)">编辑</el-button>
                    <el-button type="success" size="mini" @click="handleChangeStatus(scope.row, 1)" v-show="scope.row.status == 3">发布</el-button>
                    <el-button size="mini" @click="handleChangeStatus(scope.row, 2)" v-show="scope.row.status == 2">恢复</el-button>
                    <el-button type="danger" size="mini" @click="handleChangeStatus(scope.row, 3)" v-show="scope.row.status == 1">删除</el-button>
                </template>
            </el-table-column>
        </ck-table-page>
    </div>
</template>

<script>
    import { fetchList, del, revoke, publish } from '../../api/articles'
    import CkTablePage from "../../components/CkTablePage"

    const query = {
        title: '',
        source: '',
        status: '1',
    }
    const sourceOptions = [
        { key: '1', value: '1', label: '原创' },
        { key: '2', value: '2', label: '转载' }
    ]
    const statusOptions = [
        { key: '1', value: '1', label: '有效' },
        { key: '3', value: '3', label: '待发布' },
        { key: '2', value: '2', label: '已删除' },
    ]
    export default {
        name: "ArticleIndex",
        created() {
            this.colData = [
                { prop: 'id', label: 'ID' },
                { slot: 'categories' },
                { slot: 'tags' },
                { slot: 'title' },
                { prop: 'user.name', label: '作者' },
                { slot: 'status'},
                { slot: 'source'},
                { slot: 'count'},
                { prop: 'display_order', label: '排序' },
                { slot: 'created_updated'},
                { slot: 'operation' }
            ]
        },
        data() {
            return {
                query,
                sourceOptions,
                statusOptions,
                colData: [],
                fetchList: fetchList,
            }
        },
        methods: {
            handleSearch() {
                this.$refs.table.fetchData()
            },
            handleAdd() {
                this.$router.push('/article/add')
            },
            handleViewArticle(row) {
                this.$message(row.url_name)
            },
            showStatus(status, type) {
                let statusNum = parseInt(status) - 1
                const statusMap = [
                    ["success", "正常"],
                    ["danger", "已删除"],
                    ["info", "待发布"],
                ]
                if (type == "tag")
                {
                    return statusMap[statusNum][0]
                } else if (type =="text"){
                    return statusMap[statusNum][1]
                }
            },
            showSource(source, type) {
                let sourceNum = parseInt(source) - 1
                const sourceMap = [
                    ["success", "原创"],
                    ["info", "转载"],
                ]
                if (type == "tag")
                {
                    return sourceMap[sourceNum][0]
                } else if (type =="text"){
                    return sourceMap[sourceNum][1]
                }
            },
            handleChangeStatus(row, type) {
                if (type == 1){
                    // 发布
                    this.$confirm('确认发布？')
                        .then(_ => {
                            publish(row.id).then((response) => {
                                this.$message("发布成功")
                                this.handleSearch()
                            })
                        })
                        .catch(_ => {})

                } else if (type == 2) {
                    // 恢复
                    this.$confirm('确认恢复？')
                        .then(_ => {
                            revoke(row.id).then((response) => {
                                this.$message("恢复成功")
                                this.handleSearch()
                            })
                        })
                        .catch(_ => {})
                } else if (type == 3) {
                    // 删除
                    this.$confirm('确认删除？')
                        .then(_ => {
                            del(row.id).then((response) => {
                                this.$message("删除成功")
                                this.handleSearch()
                            })
                        })
                        .catch(_ => {})
                }
            }
        },
        components: {
            CkTablePage
        }
    }
</script>

<style scoped>
    .table-tag {
        margin-right: 5px;
        margin-bottom: 5px;
    }
</style>