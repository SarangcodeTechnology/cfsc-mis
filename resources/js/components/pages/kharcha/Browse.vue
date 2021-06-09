<template>
    <v-container fluid>

        <v-row>
            <v-col>
                <v-row v-if="filter">
                    <v-col cols="auto">
                        <v-autocomplete chips outlined @input="getDataFromApi" v-model="filterData.aarthikBarsaIds"
                                        :items="aarthikBarsas" item-text="name" multiple item-value="id"
                                        label="आर्थिक वर्ष"></v-autocomplete>
                    </v-col>
                    <v-col cols="auto">
                        <v-autocomplete chips outlined @input="getDataFromApi" v-model="filterData.cfugIds" :items="cfugs"
                                        item-text="fug_name" multiple item-value="id"
                                        label="वन उपभोक्ता समूह"></v-autocomplete>
                    </v-col>
                </v-row>
                <v-data-table
                    :headers="headers"
                    :hide-default-footer="true"
                    :items="kharcha"
                    :items-per-page="20"
                    :loading="loading"
                    :options.sync="options"
                    :page="page"
                    :pageCount="numberOfPages"
                    fixed-header
                    loading-text="Loading Data... Please wait"
                >
                    <template v-slot:header>
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th v-for="categoryItem in categoryHeader" :colspan="categoryItem.colspan">
                                <strong>({{ categoryItem.title }})</strong></th>
                        </tr>
                        </thead>
                    </template>
                    <template v-slot:top="{ pagination, options, updateOptions }">
                        <v-container fluid>
                            <v-row>
                                <v-col cols="4">
                                    <div class="d-flex align-content-center">
                                        <h5 class="mb-0 align-self-center">खर्च विवरणहरु</h5>
                                        <v-divider class="mx-4 mt-0" inset vertical></v-divider>
                                        <v-btn
                                            class="d-flex align-self-center"
                                            color="primary"
                                            @click="goToEditPage"
                                        >
                                            <v-icon left>mdi-plus-circle-outline</v-icon>
                                            <span>नयाँ</span></v-btn
                                        >
                                    </div>
                                </v-col>
                                <v-col cols="6">
                                    <v-data-footer
                                        :options="options"
                                        :pagination="pagination"
                                        items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                    />
                                </v-col>
                                <v-col cols="1"><v-btn @click="filter=!filter" color="secondary">Filter</v-btn></v-col>
                                <v-col cols="1"><v-btn @click="csvExport(csvData)" color="secondary">Export</v-btn></v-col>
                            </v-row>
                        </v-container>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-content-center align-items-center">
                            <v-btn icon x-small @click="editData(item)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>

                            <v-btn color="red" icon x-small @click="confirm(item)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </div>
                    </template>
                    <template v-slot:item.title="{ item }">{{ item.title }}
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {mapState} from "vuex";
import router from '../../../routes';

export default {
    data() {
        return {
            search: "",
            page: 1,
            numberOfPages: 0,
            options: {},
            headers: [],
            categoryHeader: [],
            loading: true,
            filterData: {
                aarthikBarsaIds: [],
                cfugIds: []
            },
            printData:[

            ],
            kharcha:[],
            filter:false,
            csvData:[]
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
                aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
                cfugs: (state) => state.webservice.resources.cfugs,
            },
        ),
    },
    methods: {
        csvExport(arrData) {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += [
                Object.keys(arrData[0]).join(";"),
                ...arrData.map(item => Object.values(item).join(";"))
            ]
                .join("\n")
                .replace(/(^\[)|(\]$)/gm, "");

            const data = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", data);
            link.setAttribute("download", "export.csv");
            link.click();
        },
        getDataFromApi() {
            const tempthis = this;
            this.loading = true;
            const {page, itemsPerPage} = tempthis.options;
            let pageNumber = page - 1;
            this.$store.dispatch("makeGetRequest", {
                route: 'kharcha',
                data: {filterData: this.filterData}
            }).then(function (response) {
                tempthis.loading = false;
                tempthis.headers = response.data.data.headers;
                tempthis.kharcha = response.data.data.kharcha;
                tempthis.categoryHeader = response.data.data.categoryHeader;
                tempthis.csvData = response.data.data.csvData;
            });
        },
        goToEditPage() {
            this.$store.dispatch("setKharchaEditData", {
                fug_id: null,
                aarthik_barsa_id: null,
                kharcha_type_id: null,
                kharcha: null,
                kaifiyat: "",
            });
        },
        editData(item) {
            router.push(`/kharcha-edit?aarthik_barsa=${item.aarthik_barsa.id}&cfug=${item.fug.id}`);
            // this.$store.dispatch("setKharchaEditData", item)
        },
        confirm(item) {
            const tempthis = this;
            this.$root.confirm('मेट्ने पुष्टि गर्नुहोस्', 'के तपाईं ' + item.title + ' मेट्न निश्चित हुनुहुन्छ ?', {color: 'red'}).then((confirm) => {
                tempthis.deleteData(item);
            }).catch((error) => {
                console.log(error);
            });
        },
        deleteData(item) {
            let tempthis = this;
            this.$store.dispatch("deleteKharcha", item).then(function (response) {
                if (response.data.status === 200) {
                    tempthis.getDataFromApi();
                }
                tempthis.deleteLoading = false;
            }).catch(function (error) {
                tempthis.deleteLoading = false;
            });

        },
    },
};
</script>
