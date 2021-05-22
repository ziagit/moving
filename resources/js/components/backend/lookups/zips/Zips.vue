<template>
<div class="zips" v-if="zips">
    <!-- delete dialog-->
    <md-dialog-confirm :md-active.sync="deleteTogal" md-title="I assure what you doing" md-content md-confirm-text="OK" md-cancel-text="Cancel" @md-confirm="confirm()" @md-cancel="onCancel" />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
        <md-dialog-title>Update zip Data</md-dialog-title>
        <md-dialog-content>
            <EditZip v-on:close-dialog="refresh" :zip="zipData" />
        </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addTogal">
        <md-dialog-title>Add new zip</md-dialog-title>
        <md-dialog-content>
            <AddZip v-on:close-dialog="refresh" />
        </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title">Postal codes</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input placeholder="Search by name..." v-model="keywords" />
            </md-field>
        </md-table-toolbar>
        <md-table-row>
            <md-table-head md-numeric>ID</md-table-head>
            <md-table-head>Postal code</md-table-head>
            <md-table-head>Address</md-table-head>
            <md-table-head>Actions</md-table-head>
        </md-table-row>
        <md-table-row v-for="zip in zips.data" :key="zip.id">
            <md-table-cell md-numeric>{{zip.id}}</md-table-cell>
            <md-table-cell>{{zip.postal_code}}</md-table-cell>
            <md-table-cell>{{zip.address.name}}</md-table-cell>

            <md-table-cell>
                <md-button class="md-icon-button md-primary" @click="edit(zip)">
                    <md-icon>edit</md-icon>
                </md-button>
                <md-button class="md-icon-button md-accent" @click="remove(zip.id)">
                    <md-icon>delete</md-icon>
                </md-button>
            </md-table-cell>
        </md-table-row>
    </md-table>
    <pagination :limit="4" :data="zips" @pagination-change-page="get"></pagination>
    <md-button class="md-fab md-primary add-btn" @click="add()">
        <md-icon>add</md-icon>
        <md-tooltip>Add new zip</md-tooltip>
    </md-button>
</div>
</template>

<script>
import AddZip from "./AddZip";
import EditZip from "./EditZip";
import axios from "axios";

export default {
    name: "zips",
    data: () => ({
        keywords: null,
        zips: null,
        addTogal: false,
        editTogal: false,
        deleteTogal: false,
        selectedId: 0,
        zipData: {},
    }),
    watch: {
        keywords(after, before) {
            this.search();
        },
    },
    methods: {
        search() {
            axios
                .get("admin/search-zip", {
                    params: {
                        keywords: this.keywords
                    }
                })
                .then((res) => {
                    console.log("search data: ", res.data.data);
                    this.zips = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        get(page = 1) {
            axios
                .get("admin/zips?page=" + page)
                .then((res) => {
                    this.zips = res.data;
                    console.log("zips: ", res.data.data)
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },

        add() {
            this.addTogal = true;
        },
        refresh() {
            this.addTogal = false;
            this.editTogal = false;
            this.get();
        },
        edit(data) {
            this.editTogal = true;
            this.zipData = data;
        },
        remove(id) {
            this.deleteTogal = true;
            this.selectedId = id;
        },

        confirm() {
            axios
                .delete("admin/zips/" + this.selectedId)
                .then((res) => {
                    console.log("deleted", res.data);
                    this.get();
                })
                .catch((err) => {
                    console.log("Error: ", err);
                });
        },
        onCancel() {},
    },
    created() {
        this.get();
    },

    components: {
        AddZip,
        EditZip,
    },
};
</script>

<style lang="scss" scoped>
.zips {
    width: 100%;

    .add-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
}

.md-table-content {
    width: 100% !important;
}
</style>
