<template>
  <v-card>
    <v-card-title>Login</v-card-title>
    <v-card-text>
      <v-text-field
        v-model="form.data.username"
        outlined
        :error="formHasError('username')"
        :error-messages="formGetError('username')"
        label="Username"
        required
      />

      <v-text-field
        v-model="form.data.password"
        outlined
        :error="formHasError('password')"
        :error-messages="formGetError('password')"
        label="Password"
        type="password"
        required

      />
    </v-card-text>
    <v-card-actions>
        <v-btn @click="login">Log in</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import formActions from "@/mixins/formActions";

export default {
  data: () => ({
    formStructure: {
      username: "",
      password: ""
    }
  }),
  mixins: [formActions],
  methods: {
    login() {
      this.$api
        .post("login", this.form.data)
        .then(async ({ token }) => {
            await this.$api.setToken(token);

            Bus.$emit('checkToken');

        })
        .catch(({ data }) => {
          this.setFormErrors(data);
        });
    },
  }
};
</script>

<style>
</style>