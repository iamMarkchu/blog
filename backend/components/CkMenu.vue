<template>
    <el-aside width="200px">
        <el-menu
                default-active="/"
                class="el-menu-vertical-demo"
                @open="handleOpen"
                @close="handleClose"
                background-color="#545c64"
                text-color="#fff"
                active-text-color="#ffd04b"
                :collapse="isCollapse"
                :router="isRouter">
            <template v-for="(item, index) in routes">
                <el-submenu v-if="item.children !== undefined" :index="(index+ '1')">
                    <template slot="title">{{ item.name }}</template>
                    <el-menu-item v-for="(subItem, subIndex) in item.children" v-if="subItem.display === undefined" :index="item.path + '/' +subItem.path" :key="subIndex+'1'">{{ subItem.name}}</el-menu-item>
                </el-submenu>
                <el-menu-item v-else :index="item.path">{{ item.name }}</el-menu-item>
            </template>
        </el-menu>
    </el-aside>
</template>

<script>
    import { constantRouterMap } from "../router/routes"
    export default {
        name: "CkMenu",
        data() {
            return {
                isCollapse: false,
                isRouter: true,
                routes: constantRouterMap
            }
        },
        methods: {
            handleOpen: () => {

            },
            handleClose: () => {

            }
        }
    }
</script>

<style scoped>
.el-menu {
    height: 100%;
}
</style>