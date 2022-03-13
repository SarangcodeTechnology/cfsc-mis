<template>
    <v-form ref="form" v-model="valid">
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>उद्यम आ.व. विवरणहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    color="green darken-1"
                    depressed
                    hint="E.g.: save"
                    @click="saveUdhyamFyData()"
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
                            <v-autocomplete v-model="udhyamFyData.aarthik_barsa_id"
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
                            <v-autocomplete v-model="udhyamFyData.udhyam_id"
                                            :items="udhyams"
                                            :rules="[(v) => !!v || 'उद्यम छनाैट गर्न अनिवार्य छ']"
                                            clearable
                                            hint="E.g. : फलानाे उद्यम"
                                            item-text="udhyam_name"
                                            item-value="id"
                                            label="उद्यम"
                                            outlined
                                            placeholder="उद्यम छनाैट गर्नुहाेस् ।"

                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <span v-if="udhyamFyData.length>0"
                    >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                    >
                    <v-divider v-if="udhyamFyData.length>0"></v-divider>
                    <div class="item">
                        <v-card
                        >
                            <v-card-text>
                                <h4><strong>लाभान्वित घरधुरी</strong></h4>
                                <v-divider></v-divider>
                                <v-row>
                                    <v-col cols="6">
                                        <v-text-field v-model="udhyamFyData.pratakchya_rojgari" label="प्रतक्ष राेजगारी"
                                                      outlined
                                                      placeholder="प्रतक्ष राेजगारी राख्नुहाेस्"
                                                      type="number"></v-text-field>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-text-field v-model="udhyamFyData.apratakchya_rojgari"
                                                      label="अप्रतक्ष राेजगारी"
                                                      outlined
                                                      placeholder="अप्रतक्ष राेजगारी राख्नुहाेस्"
                                                      type="number"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-divider></v-divider>
                                <v-row>
                                    <v-col cols="6">
                                        <v-text-field v-model="udhyamFyData.punji" label="पूंजि"
                                                      outlined
                                                      placeholder="पूंजि राख्नुहाेस्"
                                                      type="number"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </div>
                </v-container>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "udhyamFyDataEdit",
    data() {
        return {
            valid: false,
            filterData: {
                id: "",
                aarthikBarsa: "",
                udhyam: ""
            },
        }
    },
    methods: {
        saveUdhyamFyData() {
            const temp = this;
            this.$store.dispatch("saveUdhyamFyData", temp.udhyamFyData)
        },
        getDataFromApi() {
            var tempthis = this;
            // if (this.$refs.form.validate()) {
            if (this.$route.query.aarthik_barsa && this.$route.query.udhyam && this.$route.query.id) {
                this.filterData.id = this.$route.query.id;
                this.filterData.aarthikBarsa = this.$route.query.aarthik_barsa;
                this.filterData.udhyam = this.$route.query.udhyam;
                this.$store.dispatch("makePostRequest", {
                    data: tempthis.filterData,
                    route: 'get-udhyam-fy-data'
                }).then((response) => {
                    this.$store.dispatch('setUdhyamFyEditData', response.udhyamFyData)
                })
            }
        }
    },
    computed: {
        ...mapState({
            aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
            udhyams: (state) => state.webservice.resources.udhyams,
            udhyamDisable: (state, getters) => !getters.CHECK_PERMISSION('udhyam-browse'),
            udhyamFyData: (state) => state.webservice.editUdhyamFyData,
        }),

    },
    mounted() {
        if (this.$route.query.aarthik_barsa || this.$route.query.udhyam || this.$route.query.id) {
            const temp=this;
            this.$store.dispatch('setUdhyamFyEditData', {
                aarthik_barsa_id:parseInt(temp.$route.query.aarthik_barsa),
                udhyam_id:parseInt(temp.$route.query.udhyam),
                pratakchya_rojgari: null,
                apratakchya_rojgari: null,
                punji: null,
            })
            if (this.$route.query.aarthik_barsa && this.$route.query.udhyam && this.$route.query.id) {
                this.filterData.id = this.$route.query.id;
                this.filterData.aarthikBarsa = this.$route.query.aarthik_barsa;
                this.filterData.udhyam = this.$route.query.udhyam;
                this.getDataFromApi();
            }
        }

    }
}
</script>

<style scoped>

</style>
