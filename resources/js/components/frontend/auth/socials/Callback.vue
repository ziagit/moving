<template>
  <div>Callback page</div>
</template>
<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
  created() {
    this.login();
  },
  methods: {
    ...mapActions({
      loginGoogle: "auth/signInGooglCallback",
    }),
    login() {
      this.loginGoogle({
        code: this.$route.query.code,
      }).then((res) => {
        if (res.data) {
          window.location.href = res.data.url;
          console.log("url:", res.data.url);
        }
      });
    },
  },
};
</script>
