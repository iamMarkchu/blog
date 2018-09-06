<template>
    <el-main>
        <ck-menu-bar></ck-menu-bar>
        <ck-body></ck-body>
    </el-main>
</template>

<script>
    import CkMenuBar from './CkMenuBar'
    import CkBody from './CkBody'
    export default {
        name: "CkMain",
        components: {
            CkMenuBar, CkBody
        }
    }
</script>

<style scoped>
    .el-main {
        padding: 0;
    }
    .app-main {
        padding: 20px;
    }
</style>