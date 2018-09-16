<template>
    <div id="tag-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="名称" prop="name">
                <el-col :span="8">
                    <el-input v-model="form.name"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="排序">
                <el-col :span="2">
                    <el-input-number v-model="form.display_order" :step="5"></el-input-number>
                </el-col>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit('form')">确定</el-button>
                <el-button @click="onCancel()">取消</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import helper from "../../../utils/helper"
    import { fetch, add, update } from "../../../api/tags"

    const form = {
        name: '',
        display_order: 99,
    }

    const validRules = {
        name: [
            { required: true, message: '请输入类别名字', trigger: 'blur' },
            { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
        ],
        display_order: [
            { type: 'number', message: '必须为整数', trigger: 'change' }
        ]
    }

    export default {
        name: "tagDetail",
        created() {
            if (this.isEdit)
            {
                let id = this.$route.params.id
                this.fetchData(id)
            } else {
                this.form = Object.assign({}, form)
            }
        },
        props: {
            isEdit: {
                type: Boolean,
                default: false
            },
            isArticle: {
                type: Boolean,
                default: false
            },
        },
        data() {
            return {
                form: Object.assign({}, form),
                rules: validRules,
                submitText: '',
                isHighlight: true,
            }
        },
        computed: {
            requestPath() {
                return '';
            }
        },
        methods: {
            fetchData(id) {
                fetch(id)
                    .then((response) => {
                        this.form = response.data.data
                    })
            },
            onSubmit(formName) {
                console.log(this.$refs[formName])
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.isEdit)
                        {
                            update(this.form, this.form.id)
                                .then((repsonse) => {
                                    helper.message('修改成功!')
                                    this.$router.go(-1)
                                })
                        } else {
                            add(this.form)
                                .then((response) => {
                                    helper.message('创建成功!')
                                    if (!this.isArticle)
                                        this.$router.go(-1)
                                    else {
                                        this.form = Object.assign({}, form)
                                        this.$emit("finish", response.data.data)
                                    }

                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
            onCancel() {
                if (!this.isArticle)
                    this.$router.go(-1)
                else
                    this.$emit("cancel")
            }
        }
    }
</script>

<style scoped></style>