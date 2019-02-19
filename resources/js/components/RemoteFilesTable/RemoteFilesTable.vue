<template>
    <b-table striped hover :items="items">
        <template slot="action" slot-scope="data">
            <import-remote-file-button :fileKey="data.value"></import-remote-file-button>
        </template>
    </b-table>
</template>
<script>
    import {mapGetters} from 'vuex';
    import ImportRemoteFileButton from './ImportRemoteFileButton';
    export default {
        name: "RemoteFilesTable",
        components: {
            ImportRemoteFileButton
        },
        data() {
            return {

            }
        },
        created() {
            this.$store.dispatch('loadRemoteFiles');
        },
        computed: {
            ...mapGetters([
                'remoteFiles'
            ]),
            items: function () {
                let items = [];
                for (let fileKey of this.remoteFiles) {
                        items.push({
                            name: fileKey,
                            action: fileKey,
                        });
                }
                return items;
            }
        }
    }
</script>

<style scoped>

</style>