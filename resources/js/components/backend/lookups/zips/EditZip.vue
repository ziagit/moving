<template>
<div>
    <form>
        <md-card>
            <md-card-content>
                <md-content class="md-layout">
                    <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
                        <md-input v-model="form.postalcode" placeholder="Postal code"></md-input>
                    </md-field>
                    <md-field>
                        <md-select v-model="form.address" placeholder="address">
                            <md-option v-for="address in addresses" :key="address.id" :value="address.id">{{address.name}}</md-option>
                        </md-select>
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
    props: ["zip"],
    data: () => {
        return {
            form: {
                postalcode: null,
                address: null,
            },
            addresses: null,
        };
    },
    methods: {
        update() {
            axios
                .put("admin/zips/" + this.zip.id, this.form)
                .then((res) => {
                    console.log("Updated successfully! ", res.data);
                    this.$emit("close-dialog");
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
        get() {
            axios
                .get("addresses")
                .then((res) => {
                    console.log("xxx ", res.data)
                    this.addresses = res.data;
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
    },
    created() {
        this.get();
        this.form.postalcode = this.zip.postal_code;
        this.form.address = this.zip.address.id;
    },
};
</script>

<style scoped>
.md-card {
    box-shadow: none;
}
</style>
