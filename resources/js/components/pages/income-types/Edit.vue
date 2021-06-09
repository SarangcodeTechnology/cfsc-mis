<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>आम्दानी बर्गिकरण प्रकारहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    @click="saveIncomeTypes()"
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
          <span
          >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सkharchaCategoriesूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
          >
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="4">
                            <v-autocomplete outlined
                                v-model="incomeTypesData.income_category_id"
                                :items="incomeCategories"
                                :rules="[(v) => !!v || 'आम्दानी बर्गिकरण छनाेट गर्न अनिवार्य छ']"
                                clearable
                                hint="E.g. : प्रशासनिक"
                                item-text="title"
                                item-value="id"
                                label="आम्दानी बर्गिकरण"

                                placeholder="आम्दानी बर्गिकरण छनाेट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                            <v-text-field outlined
                                v-model="incomeTypesData.title"
                                label="आम्दानी बर्गिकरण प्रकारकाे नाम"
                                placeholder="आम्दानी बर्गिकरण प्रकारकाे नाम राख्नुहोस्"

                            >
                            </v-text-field>
                            <v-text-field outlined
                                v-model="incomeTypesData.order"
                                label="आम्दानी बर्गिकरण प्रकारकाे अर्डर"
                                placeholder="आम्दानी बर्गिकरण प्रकारकाे अर्डर राख्नुहोस्"

                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
import { mapState,mapGetters } from "vuex";

export default {
    data(){
        return {
            valid:false,
        }
    },
    computed:{
        ...mapState({
            incomeTypesData: (state) => state.webservice.editIncomeTypesData,
            incomeCategories: (state) => state.webservice.resources.incomeCategories,
        }),
    },
    methods:{
        saveIncomeTypes(){
            this.$store.dispatch('saveIncomeTypes',this.incomeTypesData)
        }
    }

};
</script>

<style scoped>


</style>
