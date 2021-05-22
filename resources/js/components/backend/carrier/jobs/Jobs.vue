<template>
  <div class="jobs" v-if="jobs">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="Are you sure what you doing?"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
      <md-dialog-title>Update job</md-dialog-title>
      <md-dialog-content>
        <Details v-on:close-dialog="refresh" :jobId="jobId" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Carrier jobs</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by id/carrier " v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()">Create new job</md-button>
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>From</md-table-head>
        <md-table-head>To</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Carrier</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(job, index) in jobs.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ job.order_detail.addresses[0].city }}</md-table-cell>
        <md-table-cell>{{ job.order_detail.addresses[1].city }}</md-table-cell>
        <md-table-cell>{{ job.updated_at }}</md-table-cell>
        <md-table-cell>{{ job.carrier.company }}</md-table-cell>
        <md-table-cell>{{ job.jobstatus.title }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(job)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(job.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="jobs" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Details from "./Details";
import axios from "axios";

export default {
  name: "job",
  data: () => ({
    keywords: null,
    jobs: null,
    jobId: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-job", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          console.log(res.data);
          this.jobs = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/jobs?page=" + page)
        .then((res) => {
          console.log("jobs: ", res.data.data);
          this.jobs = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
      this.stateData = this.states;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.$router.push("job-details/" + data.id);
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/jobs/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
  },
  created() {
    this.get();
  },

  components: {
    Details,
  },
};
</script>

<style lang="scss" scoped>
.jobs {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
