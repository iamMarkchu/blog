<template>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
        <!--<i class="el-icon-caret-left menu-item" @click="handleMenu"></i>-->
        <el-breadcrumb separator-class="el-icon-arrow-right" class="menu-item">
            <el-breadcrumb-item :to="{ path: item.path }" v-for="(item,index)  in levelList" :key="item.path">{{ item.name }}</el-breadcrumb-item>
        </el-breadcrumb>
    </el-menu>
</template>

<script>
    export default {
        name: "CkMenuBar",
        created() {
            this.getBreadcrumb()
        },
        data() {
            return {
                activeIndex: "1",
                levelList: [],
            }
        },
        watch: {
            $route() {
                this.getBreadcrumb()
            }
        },
        methods: {
            getBreadcrumb() {
                let matched = this.$route.matched.filter(item => item.name)
                const first = matched[0]
                if (first && first.name !== '首页') {
                    matched = [{ path: '/', name: '首页'}].concat(matched)
                }
                this.levelList = matched
                console.log(this.levelList)
            },
            handleMenu: () => {
                alert(123)
            },
            handleSelect: () => {
                alert(4)
            }
        }
    }
</script>

<style scoped>
    .menu-item {
        float: left;
        padding-left: 20px;
        height: 50px;
        line-height: 50px;
        border-radius: 0!important;
    }
</style>