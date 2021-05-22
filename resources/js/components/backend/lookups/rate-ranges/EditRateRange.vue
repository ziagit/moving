<template>
<div>
    <form>
        <md-card>
            <md-card-content>
                <md-content class="md-layout">
                    <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
                        <md-input v-model="form.name" placeholder="Name"></md-input>
                    </md-field>
                    <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
                        <md-input v-model="form.value" placeholder="Value"></md-input>
                    </md-field>
                </md-content>
            </md-card-content>
            <md-card-actions>
                <md-button v-on:click="update()">Done</md-button>
            </md-card-actions>
        </md-card>
    </form>
</div>
</template>

<script lang="ts">
import axios from "axios";
export default {
    name: 'EditRateRanges',
    props: ["range"],
    data: () => {
        return {
            form: {
                name: null,
                value: null,
            },
        };
    },
    methods: {
        update() {
            axios
                .put("admin/rate-ranges/" + this.range.id, this.form)
                .then((res) => {
                    console.log("Updated successfully! ", res.data);
                    this.$emit("close-dialog");
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
    },
    created() {
        this.form = this.range;
    }
};
</script>

<style scoped>
.md-card {
    box-shadow: none;
}
</style>
