<template>
    <div id="merchant-detail">
        <el-form ref="form" :model="form" :rules="rules" label-width="120px">
            <el-form-item label="类别名称" prop="name">
                <el-col :span="8">
                    <el-input v-model="form.name"></el-input>
                </el-col>
            </el-form-item>
            <el-form-item label="排序">
                <el-col :span="2">
                    <el-input-number v-model="form.display_order" :step="5"></el-input-number>
                </el-col>
            </el-form-item>
            <el-form-item label="父类别">
                <el-col :span="12">
                    <el-cascader
                        placeholder="搜索父类别"
                        :options="parentData"
                        @change="handleParentChange()"
                        v-model="parentSelected"
                        filterable
                        clearable
                        change-on-select
                    ></el-cascader>
                </el-col>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit('form')">{{ $route.name }}</el-button>
                <el-button @click="onCancel">取消</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import { fetch, tree, add, update, fetchAll } from "../../../api/categories"

    const form = {
        name: '',
        recursive: [],
        parent_id: 0,
        display_order: 99,
    }

    let categoryData = [
        {
            id: 0,
            name: '顶级类别',
            children: [],
        }
    ]
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
        name: "categoryDetail",
        created() {
            this.fetchAllData()
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
                defaultProps: {
                    label: 'name',
                    children: 'children',
                },
                parentData: [],
                parentSelected: [],
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
                        this.parentSelected = response.data.data.recursive.split(",").map(x => parseInt(x))
                    })
            },
            fetchAllData() {
                tree()
                    .then((response) => {
                        this.parentData = response.data.data
                    })
            },
            onSubmit(formName) {
                console.log(this.$refs[formName])
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        if (this.isEdit)
                        {
                            if (this.form.id == this.form.parent_id)
                            {
                                this.$alert('不能选自身作为父类别', '提示', {confirmButtonText: '确定'})
                                return
                            }
                            update(this.form, this.form.id)
                                .then((repsonse) => {
                                    this.$message({
                                        showClose: true,
                                        message: '恭喜你，修改成功!',
                                        type: 'success'
                                    });
                                    this.$router.go(-1)
                                })
                        } else {
                            add(this.form)
                                .then((response) => {
                                    this.$message({
                                        showClose: true,
                                        message: '恭喜你，创建成功!',
                                        type: 'success'
                                    });
                                    if (!this.isArticle)
                                        this.$router.go(-1)
                                    else
                                        this.$emit("finish")
                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
            handleParentChange(value) {
                console.log(this.parentSelected)
                let length = this.parentSelected.length
                if (length)
                {
                    this.form.parent_id = this.parentSelected[length-1]
                } else {
                    this.form.parent_id = 0
                }
                this.form.recursive = this.parentSelected
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

<style scoped>
    .el-input .el-select {
        width: 130px;
    }
    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }
</style>