<template>
    <el-select
        v-model="tags"
        filterable
        multiple
        @change="handleChange"
        placeholder="请选择">
        <el-option
            v-for="item in tagOptions"
            :key="item.value"
            :label="item.label"
            :value="item.value">
        </el-option>
    </el-select>
</template>

<script>
    import { fetchList } from "../api/tags"
    export default {
        name: "CkTag",
        created() {
            this.tags = this.defaultTags
            this.fetchData()
        },
        props: {
            defaultTags: {
                type: Array
            }
        },
        watch: {
            defaultTags(val) {
                console.log(val)
                this.tags = val
            }
        },
        data() {
            return {
                tagOptions: [],
                tags: [],
            }
        },
        methods: {
            fetchData() {
                let query = { pageSize: 100 }
                fetchList(query)
                    .then((response) => {
                        let tagList = response.data.result.data
                        this.tagOptions = tagList.map((val) => {
                            return {
                                label: val.tag_name,
                                value: val.id,
                            }
                        })
                    })
            },
            handleChange(list) {
                console.log(list)
                this.$emit('change', list)
            }
        }
    }
</script>

<style scoped>

</style>