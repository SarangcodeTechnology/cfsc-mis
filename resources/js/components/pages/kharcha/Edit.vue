<template>
    <v-form ref="form" v-model="valid">
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
                    <span  v-if="kharchaData.length>0"
                    >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                    >
                    <v-divider v-if="kharchaData.length>0"></v-divider>
                    <div class="item">
                    <div class="sub-item" v-for="(kharchaCategory,kharchaCategoryIndex) in kharchaData" :key="kharchaCategoryIndex">
                        <h4><strong>{{ kharchaCategory.title }}</strong></h4>
                        <v-divider></v-divider>
                        <div v-for="(kharchaType,kharchaTypeIndex) in kharchaCategory.kharcha_types"
                             :key="kharchaTypeIndex">
                            <h5>{{ kharchaType.title }}</h5>
                            <v-row>
                                <v-col cols="2">
                                    <v-text-field outlined type="number"
                                                  v-model="kharchaData[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.jamma"
                                                  @input="addKharchaInEditedKharchaData(kharchaData[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha)"
                                                  placeholder="रकम (रु) राख्नुहाेस्" label="जम्मा"></v-text-field>
                                </v-col>
                                <v-col cols="2">
                                    <v-text-field outlined
                                                  v-model="kharchaData[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.kaifiyat"
                                                  @input="addKharchaInEditedKharchaData(kharchaData[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha)"
                                                  placeholder="कैफियत राख्नुहाेस्" label="कैफियत"></v-text-field>
                                </v-col>
                            </v-row>

                        </div>
                    </div>
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
            },
            kharchaData: [],
            editedKharchaData: []
        }
    },
    computed: {
        ...mapState({
            // kharchaData: (state) => state.webservice.editKharchaData,
            aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
            cfugs: (state) => state.webservice.resources.cfugs,
        }),
    },
    methods: {
        addKharchaInEditedKharchaData(item) {
            if (!this.editedKharchaData.includes(item)) {
                this.editedKharchaData.push(item);
            }
        },
        getDataFromApi() {
            var tempthis = this;
            if (this.$refs.form.validate()) {
                this.$store.dispatch("makePostRequest", {
                    data: tempthis.filterData,
                    route: 'kharcha-data'
                }).then((response) => {
                    var tempKharchaData = [];
                    response.kharchaData.forEach((kharchaCategory, index) => {
                        var tempKharchaType = [];
                        kharchaCategory.kharcha_types.forEach((kharchaType) => {
                            if (kharchaType.kharcha == null) {
                                kharchaType.kharcha = {
                                    fug_id: tempthis.filterData.cfug,
                                    aarthik_barsa_id: tempthis.filterData.aarthikBarsa,
                                    kharcha_type_id: kharchaType.id,
                                    jamma: null,
                                    kaifiyat: null
                                };
                            }
                            tempKharchaType.push(kharchaType);
                        })
                        kharchaCategory.kharcha_types = tempKharchaType;
                        tempKharchaData.push(kharchaCategory);
                    });
                    tempthis.kharchaData = tempKharchaData;
                })
            } else {
                tempthis.kharchaData = [];
            }
        },
        saveKharcha() {
            this.$store.dispatch('makePostRequest', {
                data: {items: this.editedKharchaData},
                route: 'save-kharcha-data'
            });
        }
    }

};
</script>

<style scoped>


</style>
