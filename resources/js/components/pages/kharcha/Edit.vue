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
                        <v-autocomplete
                            v-model="incomeTypesData.income_category_id"
                            :items="incomeCategories"
                            :rules="[(v) => !!v || 'आम्दानी बर्गिकरण छनाेट गर्न अनिवार्य छ']"
                            clearable
                            hint="E.g. : प्रशासनिक"
                            item-text="title"
                            item-value="id"
                            label="आम्दानी बर्गिकरण"
                            outlined
                            placeholder="आम्दानी बर्गिकरण छनाेट गर्नुहाेस् ।"
                        >
                        </v-autocomplete>
                        <v-autocomplete
                            v-model="incomeTypesData.income_category_id"
                            :items="incomeCategories"
                            :rules="[(v) => !!v || 'आम्दानी बर्गिकरण छनाेट गर्न अनिवार्य छ']"
                            clearable
                            hint="E.g. : प्रशासनिक"
                            item-text="title"
                            item-value="id"
                            label="आम्दानी बर्गिकरण"
                            outlined
                            placeholder="आम्दानी बर्गिकरण छनाेट गर्नुहाेस् ।"
                        >
                        </v-autocomplete>
                    </v-row>

          <span
          >कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
          >
                    <v-divider></v-divider>

                    <div v-for="(item,i) in kharchaData" :key="i">
                        <div v-for="(subItem,j) in item" v-if="subItem.kharcha != null" :key="j">
                            <v-row>
                                <h3>{{ item.title }}</h3>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <h4>{{ subItem.title }}</h4>
                                    <v-text-field
                                        v-model="subItem.kharcha"
                                        label="खर्च रकम"
                                        placeholder="खर्च रकम राख्नुहोस्"
                                        outlined
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="subItem.kaifiyat"
                                        label="कैफियत"
                                        placeholder="कैफियत राख्नुहोस्"
                                        outlined
                                    >
                                    </v-text-field>
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
        saveKharcha() {
            this.$store.dispatch('saveKharcha', this.kharchaData)
        }
    }

};
</script>

<style scoped>


</style>
