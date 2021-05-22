<template>
    <div>
        <router-view :carrierId="carrierId" :countryId="countryId"></router-view>
    </div>
</template>
<script>
export default {
    name: "RateContainer",
    props: ["carrierId", "countryId"],
}
</script>
<style lang="scss">

</style>