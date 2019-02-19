<template>
    <component :is="layout">
        <div class="login-form--wrapper">
            <LoginForm></LoginForm>
        </div>
    </component>
</template>

<script>
import LoginForm from '../../components/auth/LoginForm';

export default {
    name: "LoginPage",
    components: {
        LoginForm
    }
}
</script>

<style scoped>
.login-form--wrapper {
    width: 320px;
    margin: 0 auto;
}
</style>