<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>खर्च विवरणहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    @click="saveKharcha()"
                    hint="E.g.: save"
                    depressed
                    color="green darken-1"
                >
                    <v-icon>mdi-floppy</v-icon>
                    <span>Save</span>
                </v-btn>
            </v-toolbar>

            <v-divider class="ma-0 pa-0"></v-divider>

            <v-card-text>
                <v-container class="pa-0 ma-0">
                    <v-row>
                        <v-col cols="4">
                            <v-autocomplete
                                v-model="filterData.aarthikBarsa"
                                :items="aarthikBarsas"
                                :rules="[(v) => !!v || 'आर्थिक वर्ष छनाैट गर्न अनिवार्य छ']"
                                clearable
                                hint="E.g. : 2078/079"
                                item-text="name"
                                item-value="id"
                                label="आर्थिक वर्ष"
                                outlined
                                placeholder="आर्थिक वर्ष छनाैट गर्नुहाेस् ।"
                                @input="getDataFromApi()"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-autocomplete
                                v-model="filterData.cfug"
                                :items="cfugs"
                                :rules="[(v) => !!v || 'वन उपभाेक्ता समूह छनाैट गर्न अनिवार्य छ']"
                                clearable
                                hint="E.g. : फलानाे वन उपभाेक्ता समूह"
                                item-text="fug_name"
                                item-value="id"
                                label="वन उपभाेक्ता समूह"
                                outlined
                                placeholder="वन उपभाेक्ता समूह छनाैट गर्नुहाेस् ।"
                                @input="getDataFromApi()"
                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <span
                    >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                    >
                    <v-divider></v-divider>
                </v-container>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
import {mapState} from "vuex";

export default {
    data() {
        return {
            valid: false,
            filterData: {
                aarthikBarsa: "",
                cfug: ""
            }
        }
    },
    computed: {
        ...mapState({
            kharchaData: (state) => state.webservice.editKharchaData,
            aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
            cfugs: (state) => state.webservice.resources.cfugs,
        }),
    },
    methods: {
        getDataFromApi() {
            var tempthis = this;
            if (this.valid) {
                this.$store.dispatch("makePostRequest", {
                    data: tempthis.filterData,
                    route: 'kharcha-data'
                })
            }
        },
        saveKharcha() {
            this.$store.dispatch('saveKharcha', this.kharchaData)
        }
    }

};
</script>

<style scoped>


</style>
