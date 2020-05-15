<template>
  <v-card>
    <v-card-title>Register</v-card-title>
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
      <v-btn @click="register">Create</v-btn>
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
    register() {
      this.$api
        .post("register", this.form.data)
        .then(({ token }) => {
          this.$api.setToken(token);

          Bus.$emit("checkToken");
        })
        .catch(({ data }) => {
          this.setFormErrors(data);
        });
    }
  }
};
</script>

<style>
</style>