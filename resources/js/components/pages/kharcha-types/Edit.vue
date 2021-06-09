<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>खर्च बर्गिकरण प्रकारहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    @click="saveKharchaTypes()"
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
                            <v-autocomplete outlined
                                v-model="kharchaTypesData.kharcha_category_id"
                                :items="kharchaCategories"
                                :rules="[(v) => !!v || 'खर्च बर्गिकरण छनाेट गर्न अनिवार्य छ']"
                                clearable
                                hint="E.g. : प्रशासनिक"
                                item-text="title"
                                item-value="id"
                                label="खर्च बर्गिकरण"

                                placeholder="खर्च बर्गिकरण छनाेट गर्नुहाेस् ।"
                            >
                            </v-autocomplete>
                            <v-text-field outlined
                                v-model="kharchaTypesData.title"
                                label="खर्च बर्गिकरण प्रकारकाे नाम"
                                placeholder="खर्च बर्गिकरण प्रकारकाे नाम राख्नुहोस्"

                            >
                            </v-text-field>
                            <v-text-field outlined
                                v-model="kharchaTypesData.order"
                                label="खर्च बर्गिकरण प्रकारकाे अर्डर"
                                placeholder="खर्च बर्गिकरण प्रकारकाे अर्डर राख्नुहोस्"

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
            kharchaTypesData: (state) => state.webservice.editKharchaTypesData,
            kharchaCategories: (state) => state.webservice.resources.kharchaCategories,
        }),
    },
    methods:{
        saveKharchaTypes(){
            this.$store.dispatch('saveKharchaTypes',this.kharchaTypesData)
        }
    }

};
</script>

<style scoped>


</style>
