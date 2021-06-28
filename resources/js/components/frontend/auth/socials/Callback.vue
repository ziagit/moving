<template>
  <div class="container d-flex">
    <div class="m-auto text-center">
      <p>Please wait...</p>
      <p v-if="isLoaded">Redirecting to user profile</p>
      <b-spinner></b-spinner>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => ({
    isLoaded: false,
  }),
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
          this.isLoaded = true;
          setTimeout(() => {
            this.isLoaded = false;
            if (this.user.phone) {
              this.$router.push("/carrier/profile");
            } else {
              this.$router.push("/carrier/profile/add");
            }
          }, 5000);
        });
      }
    },
  },
};
</script>
