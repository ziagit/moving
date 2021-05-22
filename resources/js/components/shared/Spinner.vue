<template>
<div>
    <md-progress-spinner :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
</div>
</template>

<script>
export default {
    name: "Spinner",
    data: () => ({
        snackbar: {
            show: false,
            position: "center",
            duration: 5000,
            isInfinity: false,
            message: null,
            statusCode: null,
        },
    })
}
</script>
