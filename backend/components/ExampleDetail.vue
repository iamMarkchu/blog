<template>
    <div id="-detail">
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
                <el-button type="primary" @click="onSubmit('form')">{{ $route.name }}</el-button>
                <el-button @click="$router.go(-1)">取消</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    import { fetch, add, update } from "../../../api/tags"

    const form = {
        name: '',
        parent_id: 0,
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
            }
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
                        this.form = response.data.result
                        this.$refs.tree.setCurrentKey(response.data.result.parent_id)
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
                                    this.$router.go(-1)
                                })
                        }
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            },
        }
    }
</script>

<style scoped></style>