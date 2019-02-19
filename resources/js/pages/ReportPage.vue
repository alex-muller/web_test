<template>
    <component :is="layout">
        <div v-if="loaded">
            Imported: {{report.imported}}
        </div>
    </component>
</template>

<script>
    export default {
        name: "ReportPage",
        data() {
            return {
                loaded: false,
                report: {}
            }
        },
        created() {
            axios.get('report').then(responce => {
                this.loaded = true;
                this.report = responce.data;
            });
        }
    }
</script>

<style scoped>

</style>