<template>
<div>
    <form>
        <md-card>
            <md-card-content>
                <md-content class="md-layout">
                    <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
                        <md-input v-model="form.name" placeholder="Name"></md-input>
                    </md-field>
                    <md-field>
                        <md-select v-model="form.country" placeholder="Country" id="country">
                            <md-option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</md-option>
                        </md-select>
                    </md-field>
                </md-content>
            </md-card-content>
            <md-card-actions>
                <md-button v-on:click="update()">Submit</md-button>
            </md-card-actions>
        </md-card>
    </form>
</div>
</template>

<script lang="ts">
import axios from "axios";
export default {
    props: ["state"],
    data: () => {
        return {
            form: {
                name: null,
                country: null,
            },
            countries: null,
        };
    },
    methods: {
        update() {
            axios
                .put("admin/states/" + this.state.id, this.form)
                .then((res) => {
                    console.log("updated successfully! ", res.data);
                    this.$emit("close-dialog");
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
        get() {
            axios
                .get("countries")
                .then((res) => {
                    this.countries = res.data;
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
    },
    created() {
        this.get();
        this.form.name = this.state.name;
        this.form.country = this.state.country.id;
    },
};
</script>

<style scoped>
.md-card {
    box-shadow: none;
}
</style>
