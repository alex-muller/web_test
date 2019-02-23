<template>
    <component :is="layout">
        <div v-if="loaded">
            Imported: {{report.imported}}

            <div v-if="report.files.length">
                <h3 class="mt-4">Files imported:</h3>
                <b-table :items="report.files"></b-table>
            </div>

            <div v-if="report.subscriptions.length">
                <h3 class="mt-4">Subscriptions:</h3>
                <b-table :items="report.subscriptions"></b-table>
            </div>

            <div v-if="report.big_files.length">
                <h3 class="mt-4">Big Files imported:</h3>
                <b-table :items="report.big_files"></b-table>
            </div>

        </div>
    </component>
</template>

<script>
    export default {
        name: "ReportPage",
        data() {
            return {
                loaded: false,
                report: {},
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