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
                        <ck-tag :default-tags="form.tags" @change="form.tags = $event"></ck-tag>
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
                                @change="handleCategoryChange()"
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
            <el-form-item label="">
                <el-button type="success" @click="materialManagerShow = true">素材库</el-button>
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
                <el-button type="primary" @click="onSubmit('form')">{{ $route.name }}</el-button>
                <el-button @click="$router.go(-1)">取消</el-button>
            </el-form-item>
        </el-form>
        <el-dialog title="素材管理" :visible.sync="materialManagerShow" style="padding: 20px;" append-to-body>
            <material-index></material-index>
        </el-dialog>

    </div>
</template>

<script>
    import CkTag from "../../../components/CkTag"
    import { tree } from "../../../api/categories";
    import materialIndex from "../../../views/material/Index"
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
        { key: '1', value: '1', label: '原创' },
        { key: '2', value: '2', label: '转载' }
    ]
    const validRules = {
        title: [
            { required: true, message: '请输入标题', trigger: 'blur' },
            { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
        ],
        display_order: [
            { type: 'number', message: '必须为整数', trigger: 'change' }
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
                selectCover: false,
            }
        },
        created() {
            tree().then((response) => {
                this.categoryData = response.data.data
            })
        },
        methods: {

        },
        components: {
            CkTag, materialIndex
        }
    }
</script>

<style scoped>

</style>