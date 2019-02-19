<template>
    <div class="container-fluid">
        <div class="row justify-content-space-around">
            <div class="col">

            </div>
            <div class="col-6">
                <b-nav tabs>
                    <b-nav-item>
                        <router-link :to="{ name: 'Home' }">Import</router-link>
                    </b-nav-item>
                    <b-nav-item>
                        <router-link :to="{ name: 'Report' }">Report</router-link>
                    </b-nav-item>
                </b-nav>
                <slot />
            </div>
            <div class="col">
                &nbsp;
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "default-layout",
    components: {

    }
}
</script>