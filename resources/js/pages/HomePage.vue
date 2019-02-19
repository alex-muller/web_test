<template>
    <component :is="layout">
        <div>
            <RemoteFilesTable></RemoteFilesTable>
        </div>
    </component>
</template>

<script>
import RemoteFilesTable from '../components/RemoteFilesTable/RemoteFilesTable';
export default {
    name: "HomePage",
    components: {
        RemoteFilesTable
    }
}
</script>

<style scoped>

</style>