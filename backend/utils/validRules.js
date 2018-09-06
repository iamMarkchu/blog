export default {
    name: [
        { required: true, message: '请输入商家名字', trigger: 'blur' },
        { min: 2, max: 50, message: '长度在 2 到 50 个字符', trigger: 'blur' },
    ],
    display_order: [
        { type: 'number', message: '必须为整数', trigger: 'change' }
    ],
    dest_url: [
        { required: true, message: '请输入商家链接', trigger: 'change' },
        { type: 'url', message: '链接格式不正确', trigger: 'change'},
    ],
    title: [
        { required: true, message: '请输入促销标题', trigger: 'blur' },
        { min: 2, max: 255, message: '长度在 2 到 255 个字符', trigger: 'blur' },
    ],
}