<template>
<div class="info">
    <div class="content">
        <div class="md-body-2">About <span v-if="company !== 'null'">{{company}}</span> <span v-else>{{lastName}}</span></div>
        <p class="details" v-if="detail !== 'null'">{{detail}}</p>
        <p class="details" v-else>There is no more information about this carrier</p>

    </div>
</div>
</template>

<script>
export default {
    name: "CarrierInfor",
    props: ["lastName", "company", "detail"],
};
</script>

<style lang="scss" scoped>
.info {
    min-width: 100%;
    min-height: 100%;

    .content {
        padding: 20px;

        .md-body-1 {
            display: flex;
            justify-content: space-between;
        }

        .details {
            white-space: initial;
        }
    }
}
</style>
