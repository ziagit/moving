<template>
  <div class="container d-flex">
    <div class="m-auto text-center">
      <p>Please wait...</p>
      <b-spinner></b-spinner>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  created() {
    this.login();
  },
  methods: {
    ...mapActions({
      socialCallback: "auth/socialCallback",
    }),
    login() {
      var token = this.$route.params.token;
      if (token) {
        this.socialCallback(token).then((res) => {
          this.$router.push("/carrier/profile/add");
          console.log("user info", this.user);
        });
      }
    },
  },
};
</script>
