<template>
    <div id="category-add">
        <category-detail :is-edit='false'></category-detail>
    </div>
</template>

<script>
    import categoryDetail from "./components/categoryDetail"
    export default {
        name: "CategoryAdd",
        components: { categoryDetail }
    }
</script>

<style scoped>

</style>