<template>
    <div id="article-edit">
        <article-detail :is-edit='true'></article-detail>
    </div>
</template>

<script>
    import articleDetail from "./components/ArticleDetail"
    export default {
        name: "ArticleEdit",
        components: {
            articleDetail
        }
    }
</script>

<style scoped>

</style>