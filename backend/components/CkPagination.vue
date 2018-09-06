<template>
    <el-pagination
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
            :current-page="currentPage"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total">
    </el-pagination>
</template>

<script>
    export default {
        name: "CkPagination",
        props: ["currentPage", "pageSize", "total"],
        created() {
        },
        data() {
            return {}
        },
        methods: {
            handleSizeChange(val) {
                this.$emit('size-change', val)
            },
            handleCurrentChange(val) {
                this.$emit('current-change', val)
            }
        }
    }
</script>

<style scoped>

</style>