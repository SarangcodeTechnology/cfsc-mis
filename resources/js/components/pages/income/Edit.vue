<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <strong>आम्दानी विवरणहरु सम्पादन गर्नुहोस्</strong>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="!valid"
                    class="ma-2"
                    @click="saveIncome()"
                    hint="E.g.: save"
                    depressedE
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
                    <v-row v-for="(item,i) in incomeData" :key="i">
                        <v-col cols="12">
                            <h3>{{ item.title }}</h3>
                        </v-col>
                        <v-col v-for="(subItem,j) in item" cols="auto" :key="j">
                            <h4>{{ subItem.title }}</h4>
                            <v-text-field
                                v-model="subItem.income"
                                label="आम्दानी रकम"
                                placeholder="आम्दानी रकम राख्नुहोस्"
                                outlined
                            >
                            </v-text-field>
                            <v-text-field
                                v-model="subItem.kaifiyat"
                                label="कैफियत"
                                placeholder="कैफियत राख्नुहोस्"
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
import {mapState} from "vuex";

export default {
    data() {
        return {
            valid: false,
        }
    },
    computed: {
        ...mapState({
            incomeData: (state) => state.webservice.editIncomeData,
        }),
    },
    methods: {
        saveIncome() {
            this.$store.dispatch('saveIncome', this.incomeData)
        }
    }

};
</script>

<style scoped>


</style>
