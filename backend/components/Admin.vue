<template>
    <el-container>
        <ck-menu></ck-menu>
        <ck-main></ck-main>
    </el-container>
</template>
<style>
html,body {
    height: 100%;
    margin: 0;
}
.el-container {
    height: 100%;
}
.operate-section,.table-section {
    margin-bottom: 30px;
}
.page-section {
    float: right;
}
.el-input .el-select {
    width: 130px;
}
.input-with-select .el-input-group__prepend {
    background-color: #fff;
}
</style>
<script>
    import CkMenu from './CkMenu'
    import CkMain from './CkMain'
    export default {
        name: "Admin",
        data() {
            return {

            }
        },
        components: {
            CkMenu, CkMain
        }
    }
</script>