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
                    @click="saveIncome()"
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
                            <v-autocomplete outlined
                                            v-model="filterData.aarthikBarsa"
                                            :items="aarthikBarsas"
                                            :rules="[(v) => !!v || 'आर्थिक वर्ष छनाैट गर्न अनिवार्य छ']"
                                            clearable
                                            hint="E.g. : 2078/079"
                                            item-text="name"
                                            item-value="id"
                                            label="आर्थिक वर्ष"
                                            :disabled="aarthikBarsaDisable"
                                            placeholder="आर्थिक वर्ष छनाैट गर्नुहाेस् ।"
                                            @input="getDataFromApi"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="4">
                            <v-autocomplete outlined
                                            v-model="filterData.cfug"
                                            :items="cfugs"
                                            :rules="[(v) => !!v || 'वन उपभाेक्ता समूह छनाैट गर्न अनिवार्य छ']"
                                            clearable
                                            hint="E.g. : फलानाे वन उपभाेक्ता समूह"
                                            item-text="fug_name"
                                            item-value="id"
                                            label="वन उपभाेक्ता समूह"
                                            :disabled="cfugDisable"
                                            placeholder="वन उपभाेक्ता समूह छनाैट गर्नुहाेस् ।"
                                            @input="getDataFromApi"
                            >
                            </v-autocomplete>
                        </v-col>
                    </v-row>
                    <span v-if="incomeData.length>0"
                    >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                    >
                    <v-divider v-if="incomeData.length>0"></v-divider>
                    <div class="item">
                        <div class="sub-item" v-for="(incomeCategory,incomeCategoryIndex) in incomeData"
                             :key="incomeCategoryIndex">
                            <v-card

                            >
                                <v-card-text>
                                    <h4><strong>{{ incomeCategory.title }}</strong></h4>
                                    <v-divider></v-divider>
                                    <div v-for="(incomeType,incomeTypeIndex) in incomeCategory.income_types"
                                         :key="incomeTypeIndex">
                                        <h5>{{ incomeType.title }}</h5>
                                        <v-row>
                                            <v-col cols="6">
                                                <v-text-field outlined  type="number"
                                                              v-model="incomeData[incomeCategoryIndex].income_types[incomeTypeIndex].income.jamma"
                                                              @input="addIncomeInEditedIncomeData(incomeData[incomeCategoryIndex].income_types[incomeTypeIndex].income)"
                                                              placeholder="रकम (रु) राख्नुहाेस्"
                                                              label="जम्मा"></v-text-field>
                                            </v-col>
                                            <v-col cols="6">
                                                <v-text-field outlined
                                                              v-model="incomeData[incomeCategoryIndex].income_types[incomeTypeIndex].income.kaifiyat"
                                                              @input="addIncomeInEditedIncomeData(incomeData[incomeCategoryIndex].income_types[incomeTypeIndex].income)"
                                                              placeholder="कैफियत राख्नुहाेस्"
                                                              label="कैफियत"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                    </div>
                                </v-card-text>
                            </v-card>
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
            incomeData: [],
            editedIncomeData: [],
            aarthikBarsaDisable:false
        }
    },
    mounted(){
        if(this.$route.query.aarthik_barsa || this.$route.query.cfug){
            this.filterData.aarthikBarsa = parseInt(this.$route.query.aarthik_barsa)
            this.filterData.cfug = parseInt(this.$route.query.cfug);
            if(this.$route.query.aarthik_barsa && this.$route.query.cfug){
                this.getDataFromApi();
            }
        }
    },
    computed: {
        ...mapState({
            // incomeData: (state) => state.webservice.editIncomeData,
            aarthikBarsas: (state) => state.webservice.resources.aarthikBarsas,
            cfugs: (state) => state.webservice.resources.cfugs,
            cfugDisable: (state,getters) => !getters.CHECK_PERMISSION('income-select_cfug'),
        }),
    },
    methods: {
        addIncomeInEditedIncomeData(item) {
            if (!this.editedIncomeData.includes(item)) {
                this.editedIncomeData.push(item);
            }
        },
        getDataFromApi() {
            var tempthis = this;
            // if (this.$refs.form.validate()) {
            if (this.filterData.aarthikBarsa && this.filterData.cfug ) {
                this.$store.dispatch("makePostRequest", {
                    data: tempthis.filterData,
                    route: 'income-data'
                }).then((response) => {
                    var tempIncomeData = [];
                    response.incomeData.forEach((incomeCategory, index) => {
                        var tempIncomeType = [];
                        incomeCategory.income_types.forEach((incomeType) => {
                            if (incomeType.income == null) {
                                incomeType.income = {
                                    fug_id: tempthis.filterData.cfug,
                                    aarthik_barsa_id: tempthis.filterData.aarthikBarsa,
                                    income_type_id: incomeType.id,
                                    jamma: null,
                                    kaifiyat: null
                                };
                            }
                            tempIncomeType.push(incomeType);
                        })
                        incomeCategory.income_types = tempIncomeType;
                        tempIncomeData.push(incomeCategory);
                    });
                    tempthis.incomeData = tempIncomeData;
                })
            }else{
                this.incomeData = [];
            }
        },
        saveIncome() {
            var tempthis = this;
            this.$store.dispatch('makePostRequest', {
                data: {items: this.editedIncomeData},
                route: 'save-income-data'
            }).then(function(response){
                tempthis.editedIncomeData = [];
                tempthis.getDataFromApi();
            });
        }
    }

};
</script>

<style scoped>
.item {
    width: 100%;
    columns: 2;
    column-gap: 2px;
}

.sub-item {
    width: 100%;
    margin: 0 0 5px;
    padding: 5px;
    overflow: hidden;
    break-inside: avoid;
}
</style>
