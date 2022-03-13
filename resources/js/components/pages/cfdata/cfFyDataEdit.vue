<template>
    <v-form ref="form" v-model="valid">
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>वन उपभाेक्ता समुह आ.व. विवरणहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    color="green darken-1"
                    depressed
                    hint="E.g.: save"
                    @click="saveFugFyData()"
                >
                    <v-icon>mdi-floppy</v-icon>
                    <span>सेभ</span>
                </v-btn>
            </v-toolbar>

            <v-divider class="ma-0 pa-0"></v-divider>

            <v-card-text>
                <v-container class="pa-0 ma-0">
                    <v-row>
                        <v-col cols="4">
                            <v-autocomplete v-model="fugFyData.aarthik_barsa_id"
                                            :items="aarthikBarsas"
                                            :rules="[(v) => !!v || 'आर्थिक वर्ष छनाैट गर्न अनिवार्य छ']"
                                            clearable
                                            hint="E.g. : 2078/079"
                                            item-text="name"
                                            item-value="id"
                                            label="आर्थिक वर्ष"
                                            outlined
                                            placeholder="आर्थिक वर्ष छनाैट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-autocomplete v-model="fugFyData.fug_id"
                                            :items="fugs"
                                            :rules="[(v) => !!v || 'वन उपभाेक्ता समुह छनाैट गर्न अनिवार्य छ']"
                                            clearable
                                            hint="E.g. : फलानाे वन उपभाेक्ता समुह"
                                            item-text="fug_name"
                                            item-value="id"
                                            label="वन उपभाेक्ता समुह"
                                            outlined
                                            placeholder="वन उपभाेक्ता समुह छनाैट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <span v-if="fugFyData.length>0"
                    >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                    >
                    <v-divider v-if="fugFyData.length>0"></v-divider>
                    <div class="item">

                        <h5><strong>संख्यात्मक विवरण</strong></h5>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="3">
                                <v-text-field v-model="fugFyData.hh"
                                              hint="E.g. : 9327"
                                              label="घरधुरी संख्या"
                                              outlined
                                              placeholder="घरधुरी संख्या राख्नुहाेस् ।"
                                              type="number"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field v-model="fugFyData.population"
                                              hint="E.g. : 932721"
                                              label="कूल जनसंख्या"
                                              outlined
                                              placeholder="कूल जनसंख्या राख्नुहाेस् ।"
                                              type="number"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field v-model="fugFyData.women_population"
                                              hint="E.g. : 962721"
                                              label="महिला जनसंख्या"
                                              outlined
                                              placeholder="महिला जनसंख्या राख्नुहाेस् ।"
                                              type="number"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="2">
                                <v-text-field v-model="fugFyData.men_population"
                                              hint="E.g. : 932721"
                                              label="पुरुष जनसंख्या"
                                              outlined
                                              placeholder="पुरुष जनसंख्या राख्नुहाेस् ।"


                                              type="number"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field v-model="fugFyData.forest_based_industry_operations"
                                              hint="E.g. : 23"
                                              label="वन उद्यम संचालन"
                                              outlined

                                              placeholder="वन उद्यम संचालन राख्नुहाेस् ।"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="3">
                                <v-text-field v-model="fugFyData.forest_based_tourism_operations"
                                              hint="E.g. : पदमार्ग निर्माण"
                                              label="पर्यापर्यटन गतिबिधी संचालन"
                                              outlined

                                              placeholder="पर्यापर्यटन गतिबिधी संचालन राख्नुहाेस् ।"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <h5><strong>कमिटी विवरण</strong></h5>
                        <v-divider></v-divider>
                        <v-row>
                            <v-col cols="4">
                                <v-text-field v-model="fugFyData.no_of_person_in_committee"
                                              hint="E.g. : 8"
                                              label="कमिटीमा कुल ब्यक्तिकाे संख्या"
                                              outlined

                                              placeholder="वन उपभाेक्ता समुहकाे कमिटीमा कुल ब्यक्तिकाे संख्या राख्नुहाेस् ।"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field v-model="fugFyData.women_in_committee"
                                              hint="E.g. : 4"
                                              label="कमिटीमा कुल महिलाकाे संख्या"
                                              outlined

                                              placeholder="वन उपभाेक्ता समुहकाे कमिटीमा कुल महिलाकाे संख्या राख्नुहाेस् ।"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="4">
                                <v-text-field v-model="fugFyData.men_in_committee"
                                              hint="E.g. : 4"
                                              label="कमिटीमा कुल पुरुष संख्या"
                                              outlined

                                              placeholder="वन उपभाेक्ता समुहकाे कमिटीमा कुल पुरुष संख्या राख्नुहाेस् ।"
                                >
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                </v-container>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "fugFyDataEdit",
    data() {
        return {
            valid: false,
            filterData: {
                id: "",
                aarthikBarsa: "",
                fug: ""
            },
        }
    },
    methods: {
        saveFugFyData() {
            const temp = this;
            this.$store.dispatch("saveFugFyData", temp.fugFyData)
        },
        getDataFromApi() {
            var tempthis = this;
            // if (this.$refs.form.validate()) {
            if (this.$route.query.aarthik_barsa && this.$route.query.fug && this.$route.query.id) {
                this.filterData.id = this.$route.query.id;
                this.filterData.aarthikBarsa = this.$route.query.aarthik_barsa;
                this.filterData.fug = this.$route.query.fug;
                this.$store.dispatch("makePostRequest", {
                    data: tempthis.filterData,
                    route: 'get-fug-fy-data'
                }).then((response) => {
                    this.$store.dispatch('setFugFyEditData', response.fugFyData)
                })
            }
        }
    },
    computed: {
        ...mapState({
            aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
            fugs: (state) => state.webservice.resources.cfugs,
            fugDisable: (state, getters) => !getters.CHECK_PERMISSION('cfdata-browse'),
            fugFyData: (state) => state.webservice.editFugFyData,
        }),
    },

    mounted() {
        if (this.$route.query.aarthik_barsa || this.$route.query.fug || this.$route.query.id) {
            const temp = this;
            this.$store.dispatch('setFugFyEditData', {
                aarthik_barsa_id: parseInt(temp.$route.query.aarthik_barsa),
                fug_id: parseInt(temp.$route.query.fug),
                hh: null,
                population: null,
                women_population: null,
                men_population: null,
                no_of_person_in_committee: null,
                women_in_committee: null,
                men_in_committee: null,
                forest_based_industry_operations: null,
                forest_based_tourism_operations: null,
            })
            if (this.$route.query.aarthik_barsa && this.$route.query.fug && this.$route.query.id) {
                this.filterData.id = this.$route.query.id;
                this.filterData.aarthikBarsa = this.$route.query.aarthik_barsa;
                this.filterData.fug = this.$route.query.fug;
                this.getDataFromApi();
            }
        }
    }
}
</script>

<style scoped>

</style>
