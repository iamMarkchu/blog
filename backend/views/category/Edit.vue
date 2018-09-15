<template>
    <div id="category-edit">
        <category-detail :is-edit='true'></category-detail>
    </div>
</template>

<script>
    import categoryDetail from "./components/categoryDetail"
    export default {
        name: "CategoryEdit",
        components: { categoryDetail }
    }
</script>

<style scoped>

</style>