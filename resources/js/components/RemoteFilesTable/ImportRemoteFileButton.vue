<template>
    <div>
        <b-button class="button" v-show="showButton"  :variant="variant" @click="onProcessClick">
            Import
        </b-button>
        <div v-show="showProcess" class="alertBox"><span  class="lds-hourglass"></span></div>
        <b-alert :show="showError" class="alertBox" variant="danger">Error</b-alert>
        <b-alert :show="showSuccess" class="alertBox" variant="success">Success</b-alert>
    </div>



</template>

<script>
    export default {
        name: "ImportRemoteFileButton",
        props: {
            fileKey: String
        },
        data() {
            return {
                showButton: true,
                showProcess: false,
                success: false,
                error: false,
                variant: 'primary'
            }
        },
        methods: {
            onProcessClick: function() {
                this.showButton = false;
                this.showProcess = true;
                axios.post('/remote-files/'+this.fileKey+'/import').then(this.onProcessSuccess).catch(this.onProcessError);
            },
            onProcessSuccess() {
                this.showProcess = false;
                this.success = true;
            },
            onProcessError() {
                this.showProcess = false;
                this.error = true;
            }
        },
        computed: {
            showError() {
                return this.error;
            },
            showSuccess() {
                return this.success;
            }
        }
    }
</script>

<style scoped>

    .lds-hourglass {
      display: inline-block;
      position: relative;
      width: 25px;
      height: 25px;
    }
    .lds-hourglass:after {
      content: " ";
      display: block;
      border-radius: 50%;
      width: 0;
      height: 0;
      margin: 0px;
      box-sizing: border-box;
      border: 16px solid #cef;
      border-color: #007bff transparent #007bff transparent;
      animation: lds-hourglass 1.2s infinite;
    }
    @keyframes lds-hourglass {
      0% {
        transform: rotate(0);
        animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
      }
      50% {
        transform: rotate(900deg);
        animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
      }
      100% {
        transform: rotate(1800deg);
      }
    }
    .alertBox {
        height: 38px;
        width: 85px;
        margin-bottom: 0px;
        padding: 6px 10px;
    }
    .button {
        width: 85px
    }

</style>