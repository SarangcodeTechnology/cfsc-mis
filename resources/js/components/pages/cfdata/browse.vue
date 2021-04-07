<template>
  <v-container fluid>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :hide-default-footer="true"
          :items="cfData"
          :items-per-page="20"
          :loading="loading"
          :options.sync="options"
          :page="page"
          :pageCount="numberOfPages"
          :server-items-length="totalCfData"
          fixed-header
          loading-text="Loading Data... Please wait"
        >
          <template v-slot:top="{ pagination, options, updateOptions }">
            <v-container fluid>
              <v-row>
                <v-col cols="3">
                  <div class="d-flex align-content-center">
                    <h5 class="mb-0 align-self-center">CF DATA</h5>
                    <v-divider class="mx-4 mt-0" inset vertical></v-divider>
                    <v-btn
                      class="d-flex align-self-center"
                      color="primary"
                      @click="goToEditPage"
                    >
                      <v-icon left>mdi-plus-circle-outline</v-icon>
                      <span>New</span></v-btn
                    >
                  </div>
                </v-col>
                <v-col cols="5">
                  <v-text-field
                    v-model="search"
                    dense
                    label="Search"
                    outlined
                    @change="getDataFromApi"
                  ></v-text-field>
                </v-col>
                <v-col cols="4">
                  <v-data-footer
                    :items-per-page-options="[20, 50, 100, 500]"
                    :options="options"
                    :pagination="pagination"
                    items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                    @update:options="updateOptions"
                  />
                </v-col>
              </v-row>
            </v-container>
          </template>
          <template v-slot:item.approval_revision_date_bs="{ item }">
            {{ JSON.parse(item.approval_revision_date_bs).join(", ") }}
          </template>
          <template v-slot:item.actions="{ item }">
            <div class="d-flex justify-content-center align-items-center">
              <v-btn icon x-small @click="editData(item)">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>

              <v-btn color="red" icon x-small @click="deletePopup(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </div>
          </template>
          <template v-slot:item.approval_revision_date_ad="{ item }">
            {{ JSON.parse(item.approval_revision_date_ad).join(", ") }}
          </template>
        </v-data-table>
        <v-dialog v-model="deleteDialog" max-width="290">
          <v-card>
            <v-card-title class="headline"> Confirm Delete Data </v-card-title>
            <v-card-text
              >Are you sure you want to delete the data of
              {{ deleteItem.fug_name }} -
              {{ deleteItem.fug_code }} ?</v-card-text
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="deleteDialog = false">
                Cancel
              </v-btn>
              <v-btn color="red darken-1" text @click="deleteData">
                Delete
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      deleteItem: "",
      deleteDialog: false,
      search: "",
      page: 1,
      totalCfData: 0,
      numberOfPages: 0,
      cfData: [],
      loading: true,
      options: {},
      totalItems: 20,
      headers: [
        { text: "Actions", value: "actions" },
        { text: "FUG Name", value: "fug_name" },
        { text: "FUG Code", value: "fug_code" },
        { text: "CFID", value: "cfid" },
        { text: "Province", value: "province.name" },
        { text: "District", value: "district.name" },
        { text: "Local Level Name", value: "local_level.name" },
        { text: "Local Level Type", value: "local_level.type" },
        { text: "LLId", value: "local_level.llid" },
        { text: "Physiography", value: "physiography.name" },
        { text: "X", value: "x" },
        { text: "Y", value: "y" },
        { text: "Subdivision", value: "subdivision.name" },
        { text: "Approval Date BS", value: "approval_date_bs" },
        { text: "Approval Date AD", value: "approval_date_ad" },
        { text: "Approval FY", value: "approval_fy" },
        { text: "Area Ha", value: "area_ha" },
        { text: "Household", value: "hh" },
        { text: "Household / Area", value: "hh_ha" },
        { text: "Vegetation Type", value: "vegetation_type.name" },
        { text: "Vegetation Type Code", value: "vegetation_type.code" },
        { text: "Forest Type Scientific Name", value: "forest_type.name" },
        { text: "Forest Type Code", value: "forest_type.code" },
        { text: "Forest Condition", value: "forest_condition.code" },
        {
          text: "No. of person in Committee",
          value: "no_of_person_in_committee",
        },
        { text: "Women in Committee", value: "women_in_committee" },
        {
          text: "Approval Revision Date BS",
          value: "approval_revision_date_bs",
        },
        {
          text: "Approval Revision Date AD",
          value: "approval_revision_date_ad",
        },
        { text: "Remarks", value: "remarks" },
      ],
    };
  },
  watch: {
    //this one will populate new data set when user changes current page.
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
  },
  mounted() {
    this.getDataFromApi();
  },
  methods: {
    deletePopup(item) {
      this.deleteItem = item;
      this.deleteDialog = true;
    },
    editData(item) {
        this.$store.dispatch("setCfEditData",item);
    },
    deleteData() {
      let tempthis = this;
      let deleteItem = this.deleteItem;
      let index = this.cfData.indexOf(this.deleteItem);
      this.$store
        .dispatch("deleteCfData", { index: index, id: deleteItem.id })
        .then(function (response) {
          if (response.data.status === 200) {
            tempthis.cfData.splice(index,1);
            tempthis.deleteDialog = false;
            // popup close
          }
        })
        .catch(function (error) {
          this.$store.dispatch("addNotification", {
            type: "error",
            message: error,
          });
        });
    },
    goToEditPage() {
      this.$store.dispatch("setCfEditData",{
        fug_name: "",
        fug_code: "",
        cfid: "",
        province_id: null,
        district_id: null,
        local_level_id: null,
        physiography_id: null,
        x: "",
        y: "",
        subdivision_id: null,
        approval_date_bs: "",
        approval_date_ad: "",
        approval_fy: "",
        area_ha: "",
        hh: "",
        vegetation_type_id: null,
        forest_type_id: null,
        forest_condition_id: null,
        no_of_person_in_committee: "",
        women_in_committee: "",
        remarks: "",
        approval_revision_date_bs: "",
        approval_revision_date_ad: "",
    });
    },
    getDataFromApi() {
      const tempthis = this;
      this.loading = true;
      const { page, itemsPerPage } = tempthis.options;
      this.$store
        .dispatch("getCfData", {
          page: page,
          totalItems: itemsPerPage,
          search: tempthis.search,
        })
        .then(function (response) {
          const { sortBy, sortDesc } = tempthis.options;

          let items = response.data.data.cfData.data;

          if (sortBy.length === 1 && sortDesc.length === 1) {
            items = items.sort((a, b) => {
              const sortA = a[sortBy[0]];
              const sortB = b[sortBy[0]];

              if (sortDesc[0]) {
                if (sortA < sortB) return 1;
                if (sortA > sortB) return -1;
                return 0;
              } else {
                if (sortA < sortB) return -1;
                if (sortA > sortB) return 1;
                return 0;
              }
            });
          }

          tempthis.cfData = items;
          tempthis.totalCfData = parseInt(response.data.data.cfData.total);
          tempthis.numberOfPages = parseInt(
            response.data.data.cfData.last_page
          );
          tempthis.loading = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.theme--light.v-data-table .v-data-footer {
  border-top: none !important;
}
</style>
