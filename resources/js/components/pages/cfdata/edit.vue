<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-toolbar color="#E0E0E0" dark flat> </v-toolbar>
    <v-card class="mx-11 my-n11">
      <v-toolbar flat>
        <v-toolbar-title>
          <strong>सामुदायिक वन विवरण फारम</strong>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          class="ma-2"
          @click="saveCfData()"
          hint="E.g. : Save"
          depressed
          dark
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
            >सामुदायिक वन विवरण फारममा तपाइहरुलाइ स्वागत छ । कृपया तलकाे फारम
            मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
          >
          <v-divider></v-divider>
          <h5><strong>परिचय विवरण</strong></h5>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="4">
              <v-text-field
                v-model="cfData.fug_name"
                label="सामुदायिक वनकाे नाम (FUG Name)"
                hint="E.g. : Ukhubari"
                placeholder="सामुदायिक वनकाे नाम राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.fug_code"
                label="सामुदायिक वनकाे काेड (FUG Code)"
                hint="E.g. : KAS/NI/06/20"
                placeholder="सामुदायिक वनकाे काेड राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="2">
              <v-text-field
                v-model="cfData.cfid"
                label="सामुदायिक वनकाे ID (CFID)"
                hint="E.g. : 9327"
                placeholder="सामुदायिक वनकाे ID राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.approval_date_bs"
                label="स्विक्रित मिती बि‍ सं(Approval Date BS)"
                hint="E.g. : 2076/3/18"
                placeholder="सामुदायिक वनकाे स्विक्रित मिती बि‍ सं राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.approval_date_ad"
                label="स्विक्रित मिती इ सं(Approval Date AD)"
                hint="E.g. : 1996/3/17"
                placeholder="सामुदायिक वनकाे स्विक्रित मिती इ सं राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.approval_fy"
                label="स्विक्रित आर्थिक बर्ष (Fiscal Year)"
                hint="E.g. : 056/057"
                placeholder="सामुदायिक वनकाे स्विक्रित आर्थिक बर्ष राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
          </v-row>
          <h5><strong>ठेगाना विवरण</strong></h5>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.province_id"
                :items="provinces"
                item-text="name"
                item-value="id"
                label="प्रदेश"
                hint="E.g. : Province-4"
                placeholder="प्रदेश छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.district_id"
                :items="districts"
                item-text="name"
                item-value="id"
                label="जिल्ला"
                hint="E.g. : Kaski"
                placeholder="जिल्ला छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.local_level_id"
                :items="localLevels"
                item-text="name"
                item-value="id"
                label="पालिका"
                hint="E.g. : Pokhara Lekhnath"
                placeholder="पालिका छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.subdivision_id"
                :items="subDivisions"
                item-text="name"
                item-value="id"
                label="डिभिजन"
                hint="E.g. : Namule"
                placeholder="डिभिजन छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.x"
                label="X Coordinate"
                hint="E.g. : 81.8227042124"
                placeholder="सामुदायिक वनकाे X Coordinate राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.y"
                label="Y Coordinate"
                hint="E.g. : 28.9311883496"
                placeholder="सामुदायिक वनकाे Y Coordinate राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
          </v-row>
          <h5><strong>कमिटी विवरण</strong></h5>
          <v-divider></v-divider>

          <v-row>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.no_of_person_in_committee"
                label="कमिटीमा कुल ब्यक्तिकाे संख्या"
                hint="E.g. : 8"
                placeholder="सामुदायिक वनकाे कमिटीमा कुल ब्यक्तिकाे संख्या राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.women_in_committee"
                label="कमिटीमा कुल महिलाकाे संख्या"
                hint="E.g. : 4"
                placeholder="सामुदायिक वनकाे कमिटीमा कुल महिलाकाे संख्या राख्नुहाेस् ।"
                outlined
              >
              </v-text-field>
            </v-col>
          </v-row>
          <h5><strong>बनस्पती विवरण</strong></h5>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.physiography_id"
                :items="physiographies"
                item-text="name"
                item-value="id"
                label="भुगाेल (Physiography)"
                hint="E.g. : Middle Mountain"
                placeholder="भुगाेल(Physiography) छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.vegetation_type_id"
                :items="vegetationTypes"
                item-text="code"
                item-value="id"
                label="बनस्पती (Vegetation)"
                hint="E.g. : Forest"
                placeholder="बनस्पती (Vegetation) छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.forest_type_id"
                :items="forestTypes"
                item-text="name"
                item-value="id"
                label="वन प्रकार"
                hint="E.g. : Schima castanopsis"
                placeholder="वन प्रकार छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="3">
              <v-autocomplete
                clearable
                v-model="cfData.forest_condition_id"
                :items="forestConditions"
                item-text="code"
                item-value="id"
                label="वनकाे स्थिती"
                hint="E.g. : Good"
                placeholder="वनकाे स्थिती छनाैट गर्नुहाेस् ।"
                outlined
              >
              </v-autocomplete>
            </v-col>
          </v-row>
          <v-divider></v-divider>
          <v-row>
            <v-col cols="3">
              <v-text-field
                v-model="cfData.remarks"
                label="कैफियत"
                hint="E.g. : Remarks"
                placeholder="कैफियत राख्नुहाेस् ।"
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
import { mapState } from "vuex";

export default {
  data() {
    return {
      valid: false,
    };
  },
  methods: {
    saveCfData() {
      this.$store.dispatch("saveCfData", this.cfData);
    },
  },
  computed: {
    ...mapState({
      provinces: (state) => state.webservice.resources.provinces,
      cfData: (state) => state.webservice.editCfData,
      subDivisions: (state) => state.webservice.resources.subdivisions,
      physiographies: (state) => state.webservice.resources.physiographies,
      vegetationTypes: (state) => state.webservice.resources.vegetation_types,
      forestTypes: (state) => state.webservice.resources.forest_types,
      forestConditions: (state) => state.webservice.resources.forest_conditions,
    }),
    districts: function () {
      const tempthis = this;
      let data = [];
      this.provinces.forEach(function (province) {
        if (province.id === tempthis.cfData.province_id) {
          data = province.districts;
        }
      });
      return data;
    },
    localLevels: function () {
      const tempthis = this;
      let data = [];
      this.districts.forEach(function (district) {
        if (district.id === tempthis.cfData.district_id) {
          data = district.local_levels;
        }
      });
      return data;
    },
  },
};
</script>

<style scoped></style>
