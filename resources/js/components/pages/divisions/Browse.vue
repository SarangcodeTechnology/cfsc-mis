<template>
    <v-container fluid>
        <v-row>
            <v-col cols="auto">
                <div class="d-flex align-content-center">
                    <h5 class="mb-0 align-self-center">डिभिजन</h5>
                    <v-divider class="mx-4 mt-0" inset vertical></v-divider>
                    <v-btn
                        class="d-flex align-self-center"
                        color="primary"
                        @click="editItem(defaultItem)"
                    >
                        <v-icon left>mdi-plus-circle-outline</v-icon>
                        <span>नयाँ</span></v-btn
                    >
                </div>
            </v-col>
            <v-spacer></v-spacer>
        </v-row>
        <v-divider></v-divider>
        <v-row>
            <v-col>
                <v-data-table
                    :headers="headers"
                    :hide-default-footer="true"
                    :items="items"
                    :items-per-page="20"
                    :loading="loading"
                    :options.sync="options"
                    :page="page"
                    :pageCount="numberOfPages"
                    :server-items-length="totalItems"
                    fixed-header
                    loading-text="Loading Data... Please wait"
                >
                    <template v-slot:top="{ pagination, options, updateOptions }">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="5">
                                    <v-text-field
                                        v-model="search"
                                        append-icon="mdi-magnify"
                                        @click:append="getDataFromApi"
                                        dense
                                        label="Search"
                                        outlined
                                        @change="getDataFromApi"
                                    ></v-text-field>
                                </v-col>
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
                        <div class="d-flex align-items-center">
                            <v-btn icon x-small @click="editItem(item)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>

                            <v-btn color="red" icon x-small @click="confirm(item)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <v-dialog v-model="editDialog" max-width="500px" persistent>
            <v-card>
                <v-card-title>
                    <span>डिभिजन डाटा</span>
                </v-card-title>
                <v-card-text>
                    <v-form v-model="itemValid">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="editedItem.name"
                                        label="डिभिजनको नाम"
                                        outlined
                                        placeholder="डिभिजनको नाम राख्नुहाेस् ।"
                                        :rules="[(v) => !!v || 'डिभिजनको नाम राख्न अनिवार्य छ']"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete
                                        v-model="editedItem.province_id"
                                        label="प्रदेश"
                                        placeholder="प्रदेश नाम राख्नुहाेस् ।"
                                        :items="provinces"
                                        outlined
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete
                                        v-model="editedItem.district_id"
                                        label="जिल्ला"
                                        placeholder="जिल्ला नाम राख्नुहाेस् ।"
                                        :items="districts"
                                        outlined
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete
                                        v-model="editedItem.local_level_id"
                                        label="पालिका"
                                        placeholder="पालिका राख्नुहाेस् ।"
                                        :items="localLevels"
                                        outlined
                                        item-text="name"
                                        item-value="id"
                                    >
                                    </v-autocomplete>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        v-model="editedItem.ward_id"
                                        label="वार्ड"
                                        outlined
                                        type="number"
                                        placeholder="वार्ड राख्नुहाेस् ।"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        depressed
                        @click="close"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        :disabled="!itemValid"
                        :loading="saveLoading"
                        color="success"
                        depressed
                        @click="saveItem"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>

</template>

<script>
import {mapState} from "vuex";
import router from '../../../routes';

export default {
    data() {
        return {
            headers: [
                {text: "कार्यहरु", value: "actions"},
                {text: "क्र.सं", value: "id"},
                {text: "डिभिजनको नाम", value: "name"},
            ],
            loading: false,
            page: 1,
            totalItems: 0,
            numberOfPages: 0,
            search: "",
            options: {},
            items: [],
            editDialog: false,
            editedItem: {
                id: '',
                name: '',
                province_id: '',
                district_id: '',
                local_level_id: '',
                ward_id: ''
            },
            defaultItem: {
                id: '',
                name: '',
                province_id: '',
                district_id: '',
                local_level_id: '',
                ward_id: ''
            },
            editedIndex: -1,
            saveLoading: false,
            itemValid:false,
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

    computed: {
        ...mapState(
            {
                provinces: (state) => state.webservice.resources.provinces,
            },
        ),
        districts: function () {
            const tempthis = this;
            let data = [];
            this.provinces.forEach(function (province) {
                if (province.id === tempthis.editedItem.province_id) {
                    data = province.districts;
                }
            });
            return data;
        },
        localLevels: function () {
            const tempthis = this;
            let data = [];
            this.districts.forEach(function (district) {
                if (district.id === tempthis.editedItem.district_id) {
                    data = district.local_levels;
                }
            });
            return data;
        },
    },
    methods: {
        confirm(item) {
            const tempthis = this;
            this.$root.confirm('मेट्ने पुष्टि गर्नुहोस्', 'के तपाईं ' + item.name + ' मेट्न निश्चित हुनुहुन्छ ?', {color: 'red'}).then((confirm) => {
                tempthis.deleteData(item);
            }).catch((error) => {
                console.log(error);
            });
        },
        deleteData(item) {
            let tempthis = this;
            this.$store.dispatch("deleteData", {id: item.id, model: 'Division'}).then(function (response) {
                if (response.data.status === 200) {
                    tempthis.getDataFromApi();
                }
                tempthis.deleteLoading = false;
            }).catch(function (error) {
                tempthis.deleteLoading = false;
            });
        },
        saveItem() {
            this.saveLoading = true;
            let tempthis = this;
            this.$store.dispatch("makePostRequest", {
                route:'divisions',
                data:{method:'_POST',items:tempthis.editedItem}
            }).then(function (response) {
                tempthis.close();
                tempthis.getDataFromApi();
                tempthis.saveLoading = false;
            }).catch(function (error) {
                tempthis.saveLoading = false;
            });
        },
        getDataFromApi() {
            const tempthis = this;
            this.loading = true;
            const {page, itemsPerPage} = tempthis.options;
            let pageNumber = page - 1;
            this.$store.dispatch("makeGetRequest", {
                route: 'divisions',
                data: {
                    page: page,
                    totalItems: itemsPerPage,
                    search: tempthis.search,
                }
            }).then(function (response) {
                tempthis.loading = false;
                const {sortBy, sortDesc} = tempthis.options;
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
                tempthis.items =  response.data.data.items.data;
                tempthis.totalItems = parseInt(response.data.data.items.total);
                tempthis.numberOfPages = parseInt(
                    response.data.data.items.last_page
                );
                tempthis.loading = false;
            });
        },
        close() {
            this.editDialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
            });
        },
        editItem(item) {
            this.editedItem = Object.assign({}, item);
            this.editDialog = true;
        },

    },
};
</script>

<style lang="scss" scoped>

</style>
