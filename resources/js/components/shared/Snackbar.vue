<template>
    <div>
    <md-snackbar
      class="required-feild-error"
      :md-position="snackbar.position"
      :md-duration="snackbar.isInfinity ? Infinity : snackbar.duration"
      :md-active.sync="data.show"
      md-persistent
    >
      <span>{{data.message}}</span>
      <span style="color:red">Status: {{data.statusCode}}</span>
    </md-snackbar>
    </div>
</template>
<script>
export default {
    name: "Snackbar",
    props:['data'],
    data:()=>({
        snackbar: {
            position: "center",
            duration: 5000,
            isInfinity: false,
        },
    })
}
</script>
