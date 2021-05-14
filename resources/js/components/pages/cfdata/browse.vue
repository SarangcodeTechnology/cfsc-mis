<template>
  <v-container fluid>
    <v-row>
      <v-col>
          <v-container fluid>
                <v-row>
                    <v-col cols="6">
                        <h3 class="mb-0 strong align-self-center">सामुदायिक वन विवरण</h3>
                        <v-divider class="mx-4 mt-0" inset vertical></v-divider>
                    </v-col>

                    <v-col cols="6" align="right">
                        <v-btn
                        color="primary"
                        @click="goToEditPage"
                        >
                        <v-icon left>mdi-plus-circle-outline</v-icon>
                        <span>नया थप्नुहोस्</span></v-btn
                        >
                        <v-btn color="primary" @click="drawer = true">
                        <v-icon left>mdi-plus-circle-outline</v-icon>
                        <span>फिल्टर</span></v-btn
                        >
                    </v-col>
                </v-row>
          </v-container>

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
                <v-col cols="6">
                  <v-text-field
                    v-model="search"
                    dense
                    label="खोजी गर्नुहोस्"
                    outlined
                    @change="getDataFromApi"
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
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
              <v-btn icon x-small @click="editData(item, 'edit')">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              <v-btn color="red" icon x-small @click="deletePopup(item)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
              <v-btn
                color="orange"
                icon
                x-small
                @click="editData(item, 'view')"
              >
                <v-icon>mdi-eye</v-icon>
              </v-btn>
            </div>
          </template>
          <template v-slot:item.approval_revision_date_ad="{ item }">
            {{ JSON.parse(item.approval_revision_date_ad).join(", ") }}
          </template>
        </v-data-table>
        <v-dialog v-model="deleteDialog" max-width="290">
          <v-card>
            <v-card-title class="headline"> Confirm Delete Data</v-card-title>
            <v-card-text
              >Are you sure you want to delete the data of
              {{ deleteItem.fug_name }} - {{ deleteItem.fug_code }} ?
            </v-card-text>
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

    <v-navigation-drawer
      v-model="drawer"
      hide-overlay
      class="elevation-0"
      color="grey lighten-5"
      temporary
      right
      fixed
    >
      <v-container>
        <v-row>
          <v-col>
            <h4>Filter Data</h4>
            <v-divider></v-divider>
            <v-autocomplete
              v-model="filterData.provinces"
              :items="provinces"
              item-text="name"
              @change="getDataFromApi"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="प्रदेश"
              multiple
            ></v-autocomplete>
            <v-autocomplete
              v-model="filterData.districts"
              :items="districts"
              @change="getDataFromApi"
              item-text="name"
              item-value="id"
              outlined
              dense
              chips
              small-chips
              label="जिल्ला"
              multiple
            ></v-autocomplete>
            <v-autocomplete
              v-model="filterData.localLevels"
              :items="localLevels"
              item-text="name"
              item-value="id"
              @change="getDataFromApi"
              outlined
              dense
              chips
              small-chips
              label="स्थानिय तहको नाम"
              multiple
            ></v-autocomplete>
            <v-autocomplete
              v-model="filterData.wards"
              :items="wards"
              @change="getDataFromApi"
              outlined
              dense
              chips
              small-chips
              label="वार्ड"
              multiple
            ></v-autocomplete>
            <p class="text--darken-2 mb-1">वनकाे क्षेत्रफल</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.areaHa.from"
                  outlined
                  dense
                  chips
                  number
                  type="number"
                  @keyup="getDataFromApi"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.areaHa.to"
                  outlined
                  dense
                  chips
                  small-chips
                  @keyup="getDataFromApi"
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">घरधुरी संख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.hh.from"
                  outlined
                  dense
                  chips
                  number
                  type="number"
                  @keyup="getDataFromApi"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.hh.to"
                  outlined
                  dense
                  chips
                  small-chips
                  @keyup="getDataFromApi"
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">कूल जनसंख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.totalPopulation.from"
                  outlined
                  dense
                  chips
                  number
                  @keyup="getDataFromApi"
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.totalPopulation.to"
                  outlined
                  dense
                  chips
                  @keyup="getDataFromApi"
                  small-chips
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">पुरुष जनसंख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.menPopulation.from"
                  outlined
                  dense
                  @keyup="getDataFromApi"
                  chips
                  number
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.menPopulation.to"
                  outlined
                  dense
                  @keyup="getDataFromApi"
                  chips
                  small-chips
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">महिला जनसंख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.womenPopulation.from"
                  outlined
                  dense
                  chips
                  number
                  @keyup="getDataFromApi"
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.womenPopulation.to"
                  outlined
                  dense
                  chips
                  small-chips
                  @keyup="getDataFromApi"
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">कार्यसमिति कूल संख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.numberOfPersonInCommittee.from"
                  outlined
                  dense
                  chips
                  number
                  @keyup="getDataFromApi"
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.numberOfPersonInCommittee.to"
                  outlined
                  dense
                  chips
                  @keyup="getDataFromApi"
                  small-chips
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">कार्यसमितिमा पुरुष संख्याा</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.menInCommittee.from"
                  outlined
                  dense
                  @keyup="getDataFromApi"
                  chips
                  number
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.menInCommittee.to"
                  outlined
                  dense
                  @keyup="getDataFromApi"
                  chips
                  small-chips
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <p class="text--darken-2 mb-1">कार्यसमितिमा महिला संख्या</p>
            <v-row>
              <v-col>
                <v-text-field
                  v-model="filterData.womenInCommittee.from"
                  outlined
                  dense
                  chips
                  number
                  @keyup="getDataFromApi"
                  type="number"
                  small-chips
                  label="From"
                >
                </v-text-field>
              </v-col>
              <v-col>
                <v-text-field
                  v-model="filterData.womenInCommittee.to"
                  outlined
                  dense
                  chips
                  small-chips
                  @keyup="getDataFromApi"
                  type="number"
                  label="To"
                >
                </v-text-field>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>
    </v-navigation-drawer>
  </v-container>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      drawer: true,
      filterDialog: true,
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
        { text: "कार्यहरू", value: "actions" },
        { text: "समूहको नाम", value: "fug_name" },
        { text: "समूहको कोड", value: "fug_code" },
        { text: "प्रदेश", value: "province.name" },
        { text: "जिल्ला", value: "district.name" },
        { text: "स्थानिय तहको नाम", value: "local_level.name" },
        { text: "वार्ड नं", value: "ward" },
        { text: "समूहको प्यान नं", value: "fug_pan_no" },
        { text: "घरधुरी संख्या", value: "hh" },
        { text: "कूल जनसंख्या", value: "population" },
        { text: "महिला जनसंख्या", value: "women_population" },
        { text: "पुरुष जनसंख्या", value: "men_population" },
        { text: "वनको क्षेत्रफल हे.", value: "area_ha" },
        { text: "कार्यसमिति कूल संख्या", value: "no_of_person_in_committee" },
        { text: "कार्यसमितिमा महिला संख्या", value: "women_in_committee" },
        { text: "कार्यसमितिमा पुरुष संख्या", value: "men_in_committee" },
        {
          text: "वैज्ञानिक वन ब्यवस्थापन भएको मिती",
          value: "scientific_forest_approval_date",
        },
        {
          text: "वैज्ञानिक वन ब्यवस्थापन भएको क्षेत्रफल हे.",
          value: "scientific_forest_area_ha",
        },
        { text: "वन उद्यम संचालन", value: "forest_based_industry_operations" },
        {
          text: "पर्यापर्यटन गतिबिधी संचालन",
          value: "forest_based_tourism_operations",
        },
        { text: "कैफियत", value: "remarks" },
      ],
      filterData: {
        provinces: [],
        districts: [],
        localLevels: [],
        wards: [],
        areaHa: {
          from: 0,
          to: 0,
        },
        hh: {
          from: 0,
          to: 0,
        },
        totalPopulation: {
          from: 0,
          to: 0,
        },
        menPopulation: {
          from: 0,
          to: 0,
        },
        womenPopulation: {
          from: 0,
          to: 0,
        },
        numberOfPersonInCommittee: {
          from: 0,
          to: 0,
        },
        menInCommittee: {
          from: 0,
          to: 0,
        },
        womenInCommittee: {
          from: 0,
          to: 0,
        },
      },
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
  computed: {
    ...mapState({
      provinces: (state) => state.webservice.resources.provinces,
      localLevelWithWard: (state) =>
        state.webservice.resources.localLevelWithWard,
      districts: function () {
        const tempthis = this;
        let data = [];
        this.provinces.forEach(function (province) {
          if (tempthis.filterData.provinces.includes(province.id)) {
            province.districts.forEach(function (district) {
              data.push(district);
            });
          }
        });
        return data;
      },
      localLevels: function () {
        const tempthis = this;
        let data = [];
        this.districts.forEach(function (district) {
          if (tempthis.filterData.districts.includes(district.id)) {
            district.local_levels.forEach(function (localLevel) {
              data.push(localLevel);
            });
          }
        });
        return data;
      },
      wards: function () {
        const tempthis = this;
        let data = [];
        this.localLevelWithWard.forEach(function (item) {
          if (tempthis.filterData.localLevels.includes(item.local_level_id)) {
            if (item.ward) {
              data.push(item.ward);
            }
          }
        });
        //removing the commas and dots
        var pattern = /[,]/g;

        data.sort(function (a, b) {
          a = +a.replace(pattern, "");
          b = +b.replace(pattern, "");
          //use the numberic versions to sort the string versions
          return a - b;
        });
        return [...new Set(data)];
      },
    }),
  },
  mounted() {
    this.getDataFromApi();
  },
  methods: {
    deletePopup(item) {
      this.deleteItem = item;
      this.deleteDialog = true;
    },
    editData(item, type) {
      if (type == "view") {
        this.$store.commit("SET_IS_CFDATA_VIEW", true);
      } else {
        this.$store.commit("SET_IS_CFDATA_VIEW", false);
      }
      this.$store.dispatch("setCfEditData", item);
    },
    deleteData() {
      let tempthis = this;
      let deleteItem = this.deleteItem;
      let index = this.cfData.indexOf(this.deleteItem);
      this.$store
        .dispatch("deleteCfData", { index: index, id: deleteItem.id })
        .then(function (response) {
          if (response.data.status === 200) {
            tempthis.cfData.splice(index, 1);
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
      this.$store.dispatch("setCfEditData", {
        ward: "",
        fug_name: "",
        fug_code: "",
        fug_pan_no: "",
        hh: "",
        population: "",
        women_population: "",
        men_population: "",
        area_ha: "",
        no_of_person_in_committee: "",
        women_in_committee: "",
        men_in_committee: "",
        scientific_forest_approval_date: "",
        scientific_forest_area_ha: "",
        forest_based_industry_operations: "",
        forest_based_tourism_operations: "",
        remarks: "",
        fug_approval_dates: [
          {
            date: "",
          },
        ],
        fug_audit_reports: [],
        fug_maps: [],
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
          filterData: tempthis.filterData,
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

.scrollable {
  overflow-y: scroll;
}
</style>
