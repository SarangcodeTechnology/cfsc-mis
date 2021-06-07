<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>आम्दानी बर्गिकरणहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    @click="saveIncomeCategories()"
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
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
          >
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                v-model="incomeCategoriesData.title"
                                label="आम्दानी बर्गिकरणकाे नाम"
                                placeholder="आम्दानी बर्गिकरणकाे नाम राख्नुहोस्"
                                outlined
                            >
                            </v-text-field>
                            <v-text-field
                                v-model="incomeCategoriesData.order"
                                label="आम्दानी बर्गिकरणकाे अर्डर"
                                placeholder="आम्दानी बर्गिकरणकाे अर्डर राख्नुहोस्"
                                outlined
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
            incomeCategoriesData: (state) => state.webservice.editIncomeCategoriesData,
        }),
    },
    methods:{
        saveIncomeCategories(){
            this.$store.dispatch('saveIncomeCategories',this.incomeCategoriesData)
        }
    }

};
</script>

<style scoped>


</style>
