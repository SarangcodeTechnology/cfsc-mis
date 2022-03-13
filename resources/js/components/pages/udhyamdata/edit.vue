<template>
    <v-form ref="form" v-model="valid">
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <v-toolbar-title>
                    <strong>उद्यम विवरण फारम</strong>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <template v-slot:activator="{on, attrs}">
                        <v-btn
                            :disabled="!valid"
                            class="ma-2"
                            color="green darken-1"
                            depressed
                            v-bind="attrs"
                            @click="saveUdhyamData()"
                            v-on="on"
                        >
                            <v-icon>mdi-floppy</v-icon>
                            <span>सेभ</span>
                        </v-btn>
                    </template>
                    <span>Save</span>
                </v-tooltip>
            </v-toolbar>

            <v-divider class="ma-0 pa-0"></v-divider>

            <v-card-text>
                <v-container class="pa-0 ma-0">
                     <span
                     >कृपया तलकाे फारम मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                     >
                    <v-divider></v-divider>
                    <h5><strong>परिचय विवरण</strong></h5>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="4">
                            <v-autocomplete v-model="udhyamData.kaaryalaya_id"
                                            :disabled="!$store.getters.CHECK_PERMISSION('udhyam-select_kaaryalaya')"
                                            :items="kaaryalaya"
                                            :readonly="isUdhyamDataView"
                                            item-text="name"
                                            item-value="id"
                                            label="कार्यालयकाे नाम"
                                            outlined
                                            placeholder="कार्यालयकाे नाम राख्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="udhyamData.udhyam_name"
                                          :readonly="isUdhyamDataView"
                                          label="उद्यमकाे नाम"
                                          outlined
                                          placeholder="उद्यमकाे नाम राख्नुहाेस् ।"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-autocomplete v-model="udhyamData.udhyam_type_id"
                                            :items="udhyamTypes"
                                            :readonly="isUdhyamDataView"
                                            item-text="udhyam_type_name"
                                            item-value="id"
                                            label="उद्यमकाे प्रकार"
                                            outlined
                                            placeholder="उद्यमकाे प्रकार राख्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="udhyamData.pan_vat_no"
                                          :readonly="isUdhyamDataView"
                                          label="उद्यमकाे PAN/VAT नं"
                                          outlined
                                          placeholder="उद्यमकाे PAN/VAT नं राख्नुहाेस् ।"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-autocomplete v-model="udhyamData.registration_type_id"
                                            :items="registrationTypes"
                                            :readonly="isUdhyamDataView"
                                            item-text="registration_type_name"
                                            item-value="id"
                                            label="उद्यमकाे रजिष्ट्रेसन प्रकार"
                                            outlined
                                            placeholder="उद्यमकाे रजिष्ट्रेसन प्रकार राख्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="udhyamData.registration_no"
                                          :readonly="isUdhyamDataView"
                                          label="उद्यमकाे रजिष्ट्रेसन नं (Registration No.)"
                                          outlined
                                          placeholder="उद्यमकाे रजिष्ट्रेसन नं राख्नुहाेस् ।"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field v-model="udhyamData.registration_date"
                                          :readonly="isUdhyamDataView"
                                          label="उद्यमकाे रजिष्ट्रेसन मिती"
                                          outlined
                                          placeholder="उद्यमकाे रजिष्ट्रेसन मिती राख्नुहाेस् ।"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <h5><strong>ठेगाना विवरण</strong></h5>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="3">
                            <v-autocomplete v-model="udhyamData.province_id"
                                            :items="provinces"
                                            :readonly="isUdhyamDataView"
                                            hint="E.g. : Province-4"
                                            item-text="name"
                                            item-value="id"
                                            label="प्रदेश"
                                            outlined

                                            placeholder="प्रदेश छनाैट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-autocomplete v-model="udhyamData.district_id"
                                            :items="districts"
                                            :readonly="isUdhyamDataView"

                                            hint="E.g. : Kaski"
                                            item-text="name"
                                            item-value="id"
                                            label="जिल्ला"
                                            outlined
                                            placeholder="जिल्ला छनाैट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-autocomplete v-model="udhyamData.local_level_id"
                                            :items="localLevels"
                                            :readonly="isUdhyamDataView"

                                            hint="E.g. : Pokhara Lekhnath"
                                            item-text="name"
                                            item-value="id"
                                            label="पालिका"
                                            outlined

                                            placeholder="पालिका छनाैट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field v-model="udhyamData.ward"
                                          :readonly="isUdhyamDataView"
                                          hint="E.g. : 11"
                                          label="वार्ड नं"
                                          outlined

                                          placeholder="वार्ड नं लेख्नुहोस्"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="auto"><h5><strong>आ.व. विवरण</strong></h5></v-col>
                        <v-spacer></v-spacer>
                        <v-col cols="auto">
                            <v-tooltip v-if="udhyamData.id" bottom>
                                <template v-slot:activator="{on, attrs}">
                                    <v-btn
                                        v-if="udhyamData.id"
                                        class="ma-2"
                                        color="blue darken-1"
                                        dark
                                        depressed
                                        v-bind="attrs"
                                        @click="addFyDetails()"
                                        v-on="on"
                                    >
                                        <v-icon>mdi-calendar</v-icon>
                                        <span>आ.व. विवरणहरू थप्नुहोस्</span>
                                    </v-btn>
                                </template>
                                <span>Add Fiscal Year Data</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="12">
                            <v-data-table
                                :headers="headersFyData"
                                :hide-default-footer="true"
                                :items="udhyamData.udhyam_fy_data"
                                :items-per-page="20"
                                :loading="loadingFyData"
                                :options.sync="optionsFyData"
                                :page="pageFyData"
                                :pageCount="numberOfPagesFyData"
                                :search="searchFyData"
                                fixed-header
                                height="500px"
                                loading-text="Loading Data... Please wait"
                            >
                                <template v-slot:top="{ pagination, options, updateOptions }">
                                    <v-row>
                                        <v-col cols="3">
                                            <v-text-field dense v-model="searchFyData"
                                                          append-icon="mdi-magnify"
                                                          label="Search"
                                                          outlined
                                            ></v-text-field>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col cols="auto">
                                            <v-data-footer
                                                :options="options"
                                                :pagination="pagination"
                                                items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                            />
                                        </v-col>
                                    </v-row>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <v-btn icon x-small @click="editFyDetails(item.id,item.udhyam_id,item.aarthik_barsa_id)">
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
            </v-card-text>
        </v-card>
    </v-form>

</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
    name: "edit",
    data() {
        return {
            valid: false,
            searchFyData: "",
            pageFyData: 1,
            numberOfPagesFyData: 0,
            optionsFyData: {},
            loadingFyData: false,
            headersFyData:[
                {text:"कार्यहरू",value:"actions"},
                {text:"प्रत्यक्ष राेजगारी",value:"pratakchya_rojgari"},
                {text:"अप्रत्यक्ष राेजगारी",value:"apratakchya_rojgari"},
                {text:"पूंजि",value:"punji"}
            ],
        }
    },
    methods: {
        addFyDetails() {
            this.$router.push(`/udhyam-fy-data-edit?udhyam=${this.udhyamData.id}`);
        },
        editFyDetails(id,udhyam, aarthikBarsa) {
            this.$router.push(`/udhyam-fy-data-edit?id=${id}&udhyam=${udhyam}&aarthik_barsa=${aarthikBarsa}`)
        },
        saveUdhyamData() {
            const temp = this;
            this.$store.dispatch("saveUdhyamData", temp.udhyamData)
        },
    },
    computed: {
        ...mapState({
            provinces: (state) => state.webservice.resources.provinces,
            kaaryalaya: (state) => state.webservice.resources.kaaryalaya,
            udhyamData: (state) => state.webservice.editUdhyamData,
            udhyamTypes: (state) => state.webservice.resources.udhyam_types,
            registrationTypes: (state) => state.webservice.resources.registration_types,
            isUdhyamDataView: (state) => state.webservice.isUdhyamDataView,
        }),
        ...mapGetters({
                user: "GET_USER",
            }
        ),
        districts: function () {
            const tempthis = this;
            let data = [];
            this.provinces.forEach(function (province) {
                if (province.id === tempthis.udhyamData.province_id) {
                    data = province.districts;
                }
            });
            return data;
        },
        localLevels: function () {
            const tempthis = this;
            let data = [];
            this.districts.forEach(function (district) {
                if (district.id === tempthis.udhyamData.district_id) {
                    data = district.local_levels;
                }
            });
            return data;
        },
    },
    mounted() {
        this.udhyamData.kaaryalaya_id = this.user.kaaryalaya_id;
    }
}
</script>

<style scoped>

</style>
