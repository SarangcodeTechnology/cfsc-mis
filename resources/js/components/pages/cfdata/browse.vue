<template>
    <v-container fill-height fluid>
        <v-row>
            <v-col>
                <v-data-table
                    :headers="headers"
                    :hide-default-footer="true"
                    :items="cfData"
                    :items-per-page=20
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
                            <v-row >
                                <v-col cols="3">
                                    <div class="d-flex align-content-center">
                                        <h5>CF Data</h5>
                                        <v-divider
                                            class="mx-4"
                                            inset
                                            vertical
                                        ></v-divider>
                                        <v-btn color="primary" @click="goToEditPage">
                                            <v-icon left>mdi-plus-circle-outline</v-icon>
                                            <span>New</span></v-btn>
                                    </div>
                                </v-col>
                                <v-col cols="5">
                                    <v-text-field v-model="search" dense label="Search" outlined></v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-data-footer
                                        :items-per-page-options=[20,50,100,500]
                                        :options="options"
                                        :pagination="pagination"
                                        items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                        @update:options="updateOptions"/>
                                </v-col>
                            </v-row>
                        </v-container>

                    </template>

                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            search: "",
            page: 1,
            totalCfData: 0,
            numberOfPages: 0,
            cfData: [],
            loading: true,
            options: {},
            totalItems: 20,
            headers: [
                {text: 'District', value: 'district',},
                {text: 'Province', value: 'province'},
                {text: 'Local Level Name', value: 'local_level_name'},
                {text: 'Local Level Type', value: 'local_level'},
                {text: 'LLId', value: 'llid'},
                {text: 'Physiography', value: 'physiography'},
                {text: 'X', value: 'x'},
                {text: 'Y', value: 'y'},
                {text: 'CFID', value: 'cfid'},
                {text: 'Subdivision', value: 'subdivision'},
                {text: 'FUG Code', value: 'fug_code'},
                {text: 'FUG Name', value: 'fug_name'},
                {text: 'Approval Date BS', value: 'approval_date_bs'},
                {text: 'Approval Date AD', value: 'approval_date_ad'},
                {text: 'Approval FY', value: 'approval_fy'},
                {text: 'Area Ha', value: 'area_ha'},
                {text: 'Household', value: 'hh'},
                {text: 'Household / Area', value: 'hh_ha'},
                {text: 'Vegetation Type', value: 'vegetation_type'},
                {text: 'Vegetation Type Code', value: 'vegetation_type_code'},
                {text: 'Vegetation Type Scientific Name', value: 'vegetation_type_scientific_name'},
                {text: 'Forest Condition', value: 'forest_condition'},
                {text: 'No. of person in Committee', value: 'no_of_person_in_committee'},
                {text: 'Women in Committee', value: 'women_in_committee'},
                {text: 'Remarks', value: 'remarks'},
                {text: 'Approval Revision Date BS', value: 'approval_revision_date_bs'},
                {text: 'Approval Revision Date AD', value: 'approval_revision_date_ad'},
            ],
        }
    },
    watch: {
        //this one will populate new data set when user changes current page.
        options: {
            handler() {
                this.getDataFromApi()
            },
            deep: true,
        },
    },
    mounted() {
        this.getDataFromApi()
    },
    methods: {
        goToEditPage() {
            this.$router.push('/cf-data-edit');
        },
        getDataFromApi() {
            var tempthis = this;
            this.loading = true
            const {page, itemsPerPage} = tempthis.options;
            let pageNumber = page - 1;
            this.$store.dispatch("getCfData", {
                page: pageNumber,
                totalItems: itemsPerPage,
            }).then(function (response) {
                const {sortBy, sortDesc} = tempthis.options

                let items = response.data.data.cfData.data

                if (sortBy.length === 1 && sortDesc.length === 1) {
                    items = items.sort((a, b) => {
                        const sortA = a[sortBy[0]]
                        const sortB = b[sortBy[0]]

                        if (sortDesc[0]) {
                            if (sortA < sortB) return 1
                            if (sortA > sortB) return -1
                            return 0
                        } else {
                            if (sortA < sortB) return -1
                            if (sortA > sortB) return 1
                            return 0
                        }
                    })
                }

                tempthis.cfData = items;
                tempthis.totalCfData = parseInt(response.data.data.cfData.total);
                tempthis.numberOfPages = parseInt(response.data.data.cfData.last_page);
                tempthis.loading = false
            });
        },
    }
}
</script>

<style lang="scss" scoped>
.theme--light.v-data-table .v-data-footer {
    border-top: none !important;
}
</style>
