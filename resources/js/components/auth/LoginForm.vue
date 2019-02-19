<template>
    <div class="login-form">
        <b-form @submit.prevent="onSubmit">
            <b-form-group label="Email address:"
                          label-for="email-field" >
                <b-form-input id="email-field"
                              type="email"
                              :state="isValidEmail"
                              v-model.trim="form.email"
                              @blur.native="onBlurEmail"
                              required
                              placeholder="Enter email">
                </b-form-input>
            </b-form-group >
            <b-form-group label="Password:"
                          label-for="pass-field" >
                <b-form-input id="pass-field"
                              type="password"
                              :state="isValidPassword"
                              v-model.trim="form.password"
                              @blur.native="onBlurPass"
                              autocomplete="current-password"
                              required
                              placeholder="Enter password">
                </b-form-input>
            </b-form-group >
            <div v-if="isErrors">
                <b-alert show variant="danger">{{errors.general}}</b-alert>
            </div>
            <b-button  type="submit" variant="primary">Login</b-button>
        </b-form>
    </div>
</template>

<script>

export default {
    name: 'LoginForm',
    data: () => {
        return {
            form: {
                email: '',
                password: '',
                noBlurEmail: true,
                noBlurPass: true,
            },
            showErrors: false,
            errors: {
                general: 'Invalid email/password'
            }
        }
    },
    computed: {
        isValidEmail() {
            if (this.form.noBlurEmail) return null;
            return (/^.+@.+\..+$/.test(this.form.email)) ? true : false;
        },
        isValidPassword() {
            if (this.form.noBlurPass) return null;
            return this.form.password.length > 0 ? true : false
        },
        isErrors() {
            return this.showErrors;
        }
    },
    methods: {
        onSubmit: function() {
            this.showErrors = false;
            this.$store.dispatch('tryLogin', this._getFormData())
                .then((responce) => { this._makeRedirectAfterSuccess()})
                .catch((error) => { this.showErrors = true; });
        },
        _getFormData() {
            return this.form;
        },
        _makeRedirectAfterSuccess() {
            let redirectItem = this.$router.options.routes.find(function (routeItem) {
                if (routeItem.options && routeItem.options.redirectAfterLogin) {
                    return true;
                }
            });
            let path = '/';
            if (redirectItem) {
                path = redirectItem.path;
            }
            window.location.href = path;
        },
        onBlurEmail() {
            this.form.noBlurEmail = false;
        },
        onBlurPass() {
            this.form.noBlurPass = false;
        }
    }
}
</script>