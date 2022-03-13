<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <v-container fluid>
                    <v-row>
                        <v-col cols="6">
                            <h3 class="mb-0 strong align-self-center">उद्यम विवरण</h3>
                            <v-divider class="mx-4 mt-0" inset vertical></v-divider>
                        </v-col>

                        <v-col align="right" cols="6">
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
                    :items="udhyamData"
                    :items-per-page="20"
                    :loading="loading"
                    :options.sync="options"
                    :page="page"
                    :pageCount="numberOfPages"
                    :server-items-length="totalUdhyamData"
                    fixed-header
                    loading-text="Loading Data... Please wait"
                >
                    <template v-slot:top="{ pagination, options, updateOptions }">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="3">
                                    <v-text-field v-model="search"
                                                  append-icon="mdi-magnify"
                                                  dense label="खोजी गर्नुहोस्"
                                                  outlined
                                                  @change="getDataFromApi"
                                    ></v-text-field>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="auto">
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
                </v-data-table>
                <v-dialog v-model="deleteDialog" max-width="290">
                    <v-card>
                        <v-card-title class="headline"> Confirm Delete Data</v-card-title>
                        <v-card-text
                        >Are you sure you want to delete the data of
                            {{ deleteItem.udhyam_name }} ?
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
            class="elevation-0"
            color="grey lighten-5"
            fixed
            hide-overlay
            right
            temporary
        >
            <v-container>
                <v-row>
                    <v-col>
                        <h4>Filter Data</h4>
                        <v-divider></v-divider>
                        <v-autocomplete v-model="filterData.provinces"
                                        :items="provinces"
                                        chips
                                        dense
                                        item-text="name"
                                        item-value="id"
                                        label="प्रदेश"
                                        multiple
                                        outlined
                                        small-chips
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                        <v-autocomplete v-model="filterData.districts"
                                        :items="districts"
                                        chips
                                        dense
                                        item-text="name"
                                        item-value="id"
                                        label="जिल्ला"
                                        multiple
                                        outlined
                                        small-chips
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                        <v-autocomplete v-model="filterData.localLevels"
                                        :items="localLevels"
                                        chips
                                        dense
                                        item-text="name"
                                        item-value="id"
                                        label="स्थानिय तहको नाम"
                                        multiple
                                        outlined
                                        small-chips
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                        <v-autocomplete v-model="filterData.wards"
                                        :items="wards"
                                        chips
                                        dense
                                        label="वार्ड"
                                        multiple
                                        outlined
                                        small-chips
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                        <v-autocomplete v-model="filterData.udhyam_types"
                                        :items="udhyamTypes"
                                        chips
                                        dense
                                        label="उद्यमकाे प्रकार"
                                        multiple
                                        outlined
                                        small-chips
                                        item-value="id"
                                        item-text="udhyam_type_name"
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                        <v-autocomplete v-model="filterData.registration_types"
                                        :items="registrationTypes"
                                        chips
                                        dense
                                        label="उद्यमकाे रजिष्ट्रेसन प्रकार"
                                        multiple
                                        item-value="id"
                                        item-text="registration_type_name"
                                        outlined
                                        small-chips
                                        @change="getDataFromApi"
                        ></v-autocomplete>
                    </v-col>
                </v-row>
            </v-container>
        </v-navigation-drawer>
    </v-container>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "browse",
    data() {
        return {
            udhyamData: [],
            drawer: false,
            deleteItem: "",
            deleteDialog: false,
            search: "",
            page: 1,
            totalUdhyamData: 0,
            numberOfPages: 0,
            loading: false,
            options: {},
            totalItems: 20,
            headers: [
                {text: "कार्यहरू", value: "actions"},
                {text: "उद्यमकाे नाम", value: "udhyam_name"},
                {text: "उद्यमकाे प्रकार", value: "udhyam_type.udhyam_type_name"},
                {text: "उद्यमकाे PAN/VAT नं", value: "pan_vat_no"},
                {text: "उद्यमकाे रजिष्ट्रेसन नं", value: "registration_no"},
                {text: "उद्यमकाे रजिष्ट्रेसन मिती", value: "registration_date"},
            ],
            filterData: {
                provinces: [],
                districts: [],
                localLevels: [],
                wards: [],
                udhyam_types:[],
                registration_types:[]
            },
        }
    },
    methods: {
        getDataFromApi() {
            const tempthis = this;
            this.loading = true;
            const {page, itemsPerPage} = tempthis.options;
            this.$store
                .dispatch("getUdhyamData", {
                    page: page,
                    totalItems: itemsPerPage,
                    search: tempthis.search,
                    filterData: tempthis.filterData,
                })
                .then(function (response) {
                    const {sortBy, sortDesc} = tempthis.options;

                    let items = response.data.data.udhyamData.data;

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

                    tempthis.udhyamData = items;
                    tempthis.totalUdhyamData = parseInt(response.data.data.udhyamData.total);
                    tempthis.numberOfPages = parseInt(
                        response.data.data.udhyamData.last_page
                    );
                    tempthis.loading = false;
                });
        },
        deletePopup(item) {
            this.deleteItem = item;
            this.deleteDialog = true;
        },
        editData(item, type) {
            if (type == "view") {
                this.$store.commit("SET_IS_UDHYAMDATA_VIEW", true);
            } else {
                this.$store.commit("SET_IS_UDHYAMDATA_VIEW", false);
            }
            this.$store.dispatch("setUdhyamEditData", item);
        },
        deleteData() {
            let tempthis = this;
            let deleteItem = this.deleteItem;
            let index = this.udhyamData.indexOf(this.deleteItem);
            this.$store
                .dispatch("deleteUdhyamData", {index: index, id: deleteItem.id})
                .then(function (response) {
                    if (response.data.status === 200) {
                        tempthis.udhyamData.splice(index, 1);
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
            this.$store.dispatch("setUdhyamEditData", {
                id: null,
                kaaryalaya_id: null,
                udhyam_name: "",
                udhyam_type_id: null,
                pan_vat_no: null,
                registration_type_id: null,
                registration_no: null,
                registration_date: null,
                province_id: null,
                district_id: null,
                local_level_id: null,
                ward: null,
            });
        },

    },
    computed: {
        ...mapState({
            provinces: (state) => state.webservice.resources.provinces,
            udhyamTypes: (state) => state.webservice.resources.udhyam_types,
            registrationTypes: (state) => state.webservice.resources.registration_types,
            localLevelWithWard: (state) => state.webservice.resources.localLevelWithWard,
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
        })
    },
    watch: {
        //this one will populate new data set when user changes current page.
        options: {
            handler() {
                this.getDataFromApi();
            }
            ,
            deep: true,
        }
    }
}
</script>

<style scoped>

</style>
