import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export const constantRouterMap = [
    {
        name: '个人中心',
        path: '/',
        component: require('../views/Index'),
    },
    {
        name: '标签管理',
        path: '/tag',
        component: require('../components/CkBody'),
        icon: 'el-icon-document',
        children: [
            {
                name: '标签列表',
                path: 'index',
                component: require('../views/tag/Index'),
            },
            {
                name: '创建标签',
                path: 'add',
                component: require('../views/tag/Add'),
            },
            {
                name: '修改标签',
                path: 'edit/:id',
                component: require('../views/tag/Edit'),
                display: false,
            },
        ],
    },
    {
        name: '类别管理',
        path: '/category',
        component: require('../components/CkBody'),
        children: [
            {
                name: '类别列表',
                path: 'index',
                component: require('../views/category/Index'),
            },
            {
                name: '创建类别',
                path: 'add',
                component: require('../views/category/Add'),
            },
            {
                name: '修改类别',
                path: 'edit/:id',
                component: require('../views/category/Edit'),
                display: false,
            },
        ],
    },
    {
        name: '素材管理',
        path: '/material',
        component: require('../components/CkBody'),
        children: [
            {
                name: '新增素材',
                path: 'add',
                component: require('../views/material/Add')
            },
            {
                name: '素材列表',
                path: 'index',
                component: require('../views/material/Index')
            }
        ]
    }
]

export default new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({y: 0}),
    routes: constantRouterMap
})