<template>
    <div id="article-detail">
        <el-form ref="form" :model="form" label-width="80px">
            <el-row>
                <el-col :span="16">
                    <el-form-item label="标题" prop="title">
                        <el-input v-model="form.title"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6">
                    <el-form-item label="标签">
                        <ck-tag ref="tag" :default-tags="form.tags" @change="form.tags = $event"></ck-tag>
                    </el-form-item>
                </el-col>
                <el-col :span="6">
                    <el-form-item label="来源">
                        <el-select v-model="form.source" placeholder="请选择">
                            <el-option
                                v-for="item in sourceOptions"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="6">
                    <el-form-item label="排序">
                        <el-col :span="2">
                            <el-input-number v-model="form.display_order" :step="5"></el-input-number>
                        </el-col>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12">
                    <el-form-item label="类别">
                        <el-cascader
                            placeholder="搜索类别"
                            :options="categoryData"
                            v-model="form.categories"
                            filterable
                            clearable
                            change-on-select
                        ></el-cascader>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12">
                    <el-form-item label="封面图">
                        <img :src="form.cover" alt="" v-if="form.cover != ''">
                        <el-tag type="info" v-else>暂无</el-tag>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="操作栏">
                <el-button type="primary" @click="materialManagerShow = true">素材库</el-button>
                <el-button type="primary" @click="githubManagerShow = true">从github中导入</el-button>
                <el-button type="primary" @click="tagAdderShow = true">新增标签</el-button>
                <el-button type="primary" @click="categoryAdderShow = true">新增类别</el-button>
            </el-form-item>
            <el-row>
                <el-col :span="20">
                    <el-form-item label="正文">
                        <el-input
                            type="textarea"
                            rows="70"
                            placeholder="请输入内容"
                            v-model="form.content">
                        </el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item>
                <el-button type="primary" @click="onSubmit('form')">确定</el-button>
                <el-button @click="$router.go(-1)">取消</el-button>
            </el-form-item>
        </el-form>
        <el-dialog title="素材管理" :visible.sync="materialManagerShow" append-to-body>
            <material-index :is-article="true" @done="handleImageImport($event)"></material-index>
        </el-dialog>
        <el-dialog title="新增标签" :visible.sync="tagAdderShow" append-to-body>
            <tag-add :is-article="true" @finish="handleTagAdd($event)" @cancel="tagAdderShow=false"></tag-add>
        </el-dialog>
        <el-dialog title="新增类别" :visible.sync="categoryAdderShow" append-to-body>
            <category-add :is-article="true" @finish="handleCategoryAdd($event)" @cancel="categoryAdderShow=false"></category-add>
        </el-dialog>
        <el-dialog title="github管理" :visible.sync="githubManagerShow" @open="openGithubManager" append-to-body>
            <ol>
                <li v-for="item in githubArticleList" :key="item.path" @click="handleImport(item)"> {{ item.path }}</li>
            </ol>
        </el-dialog>

    </div>
</template>

<script>
    import CkTag from "../../../components/CkTag"
    import { tree } from "../../../api/categories";
    import { fetchList } from "../../../api/github";
    import { add, edit, update } from "../../../api/articles";
    import materialIndex from "../../../views/material/Index"
    import tagAdd from "../../../views/tag/components/tagDetail"
    import categoryAdd from "../../../views/category/components/categoryDetail"
    import axios from 'axios'

    const form = {
        title: "",
        content: "",
        cover: "",
        display_order: 99,
        source: '1',
        tags: [],
        categories: [],
    }

    const sourceOptions = [
        {key: '1', value: '1', label: '原创'},
        {key: '2', value: '2', label: '转载'}
    ]
    const validRules = {
        title: [
            {required: true, message: '请输入标题', trigger: 'blur'},
            {min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur'},
        ],
        display_order: [
            {type: 'number', message: '必须为整数', trigger: 'change'}
        ]
    }
    export default {
        name: "ArticleDetail",
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                form: Object.assign({}, form),
                sourceOptions,
                categoryData: [],
                categorySelected: [],
                materialManagerShow: false,
                tagAdderShow: false,
                categoryAdderShow: false,
                githubManagerShow: false,
                githubArticleList: [],
                selectCover: false,
            }
        },
        created() {
            // recursive.split(",").map(x => parseInt(x))
            this.categoryTree()
            if (this.isEdit)
            {
                let id = this.$route.params.id
                edit(id).then((response) => {
                    this.form = response.data.data
                    this.form.tags = response.data.data.tags.map((item) => { return item.id })
                    this.form.categories = response.data.data.categories.map((item) => { return item.id })
                })
            } else {
                //
            }
        },
        methods: {
            categoryTree() {
                tree().then((response) => {
                    this.categoryData = response.data.data
                })
            },
            onSubmit(formName) {
                console.log(this.$refs[formName])
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.isEdit)
                        {
                            console.log(this.form)
                            update(this.form, this.form.id)
                                .then((repsonse) => {
                                    this.$message("修改成功!")
                                    this.$router.go(-1)
                                })
                        } else {
                            add(this.form)
                                .then((response) => {
                                    this.$message("创建成功!")
                                    this.$router.go(-1)
                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
            openGithubManager() {
                fetchList().then((response) => {
                    console.log(response.data)
                    this.githubArticleList = response.data.data
                })
            },
            handleImport(item) {
                axios.get(item.url)
                    .then((response) => {
                        console.log(response.data)
                        this.form.title = item.path.split(".")[0]
                        this.form.content = decodeURIComponent(escape(window.atob(response.data.content)))
                        this.githubManagerShow = false
                    })
            },
            handleImageImport(url) {
                console.log(url)
                if (this.form.content != "")
                    this.form.content += "\n"
                this.form.content += "![image]("+ url + ")"
                this.materialManagerShow = false
            },
            handleTagAdd(tag) {
                this.$refs.tag.fetchData()
                this.form.tags.push(tag.id)
                this.tagAdderShow = false
            },
            handleCategoryAdd(category) {
                this.categoryTree()
                let categories = category.recursive.split(",")
                if (categories == [""])
                    categories = []
                categories = categories.map((val) => { return parseInt(val) })
                categories.push(category.id)
                this.form.categories = categories
                this.categoryAdderShow = false
            }
        },
        components: {
            CkTag, materialIndex,tagAdd,categoryAdd
        }
    }
</script>

<style scoped>

</style>