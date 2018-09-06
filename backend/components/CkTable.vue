<template>
    <el-table
            border
            style="width: 100%"
            :data="data">
        <template v-for="colConfig in colData">
            <slot v-if="colConfig.slot" :name="colConfig.slot"></slot>
            <component
                    v-else-if="colConfig.component"
                    :is="colConfig.component"
                    :col-config="colConfig">
            </component>
            <el-table-column v-else v-bind="colConfig"></el-table-column>
        </template>
    </el-table>
</template>

<script>
    export default {
        name: "CkTable",
        props: ['colData', 'data'],
        created() {
        },
        data() {
            return {}
        },
        methods: {}
    }
</script>

<style scoped>

</style>