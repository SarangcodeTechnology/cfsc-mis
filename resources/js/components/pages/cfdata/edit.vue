<template>
    <v-form ref="form" v-model="valid" lazy-validation>
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <v-toolbar-title>
                    <strong>सामुदायिक वन विवरण फारम</strong>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom v-if="cfData.id">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            class="ma-2"
                            @click="addIncomeDetails()"
                            depressed
                            dark
                            color="blue darken-1"
                            v-bind="attrs"
                            v-on="on"
                            v-if="cfData.id"
                        >
                            <v-icon>mdi-cash-plus</v-icon>
                            <span>आम्दानी विवरणहरू थप्नुहोस्</span>
                        </v-btn>
                    </template>
                    <span>Add Income Data</span>
                </v-tooltip>
                <v-tooltip bottom v-if="cfData.id">
                    <template v-slot:activator="{on, attrs}">
                        <v-btn
                            class="ma-2"
                            @click="addKharchaDetails()"
                            depressed
                            dark
                            color="blue darken-1"
                            v-bind="attrs"
                            v-if="cfData.id"
                            v-on="on"
                        >
                            <v-icon>mdi-cash-minus</v-icon>
                            <span>खर्च विवरणहरू थप्नुहोस्</span>
                        </v-btn>
                    </template>
                    <span>Add Expenditure Data</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{on, attrs}">
                        <v-btn
                            class="ma-2"
                            @click="saveCfData()"
                            depressed
                            dark
                            color="green darken-1"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>mdi-floppy</v-icon>
                            <span>सेभ</span>
                        </v-btn>
                    </template>
                    <span>Save</span>
                </v-tooltip>
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
                            <v-text-field outlined
                                          v-model="cfData.fug_name"
                                          label="सामुदायिक वनकाे नाम (FUG Name)"
                                          hint="E.g. : Ukhubari"
                                          placeholder="सामुदायिक वनकाे नाम राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.fug_code"
                                          label="सामुदायिक वनकाे काेड (FUG Code)"
                                          hint="E.g. : KAS/NI/06/20"
                                          placeholder="सामुदायिक वनकाे काेड राख्नुहाेस् ।"
                                          :readonly="isCfDataView"

                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field outlined
                                          v-if="approvalDates[0]"
                                          v-model="approvalDates[0].date"
                                          label="स्विक्रित मिती"
                                          hint="E.g. : 2070/06/12"
                                          @change="saveApprovalDates"
                                          placeholder="स्विक्रित मिती राख्नुहाेस् ।"
                                          :readonly="isCfDataView"

                            >
                                <template v-slot:append-outer>
                                    <v-tooltip bottom>
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn
                                                color="primary"
                                                depressed
                                                dark
                                                v-bind="attrs"
                                                v-on="on"
                                                @click="approveDialog = true"
                                                small
                                            >
                                                <v-icon>mdi-calendar-plus</v-icon>
                                            </v-btn>
                                        </template>
                                        <span>कार्ययाेजना स्विक्रित मितीहरु</span>
                                        <div class="d-flex flex-column">
                                        <span
                                            v-for="(approvalDateItem, k) in approvalDates"
                                            :key="k"
                                        >{{ approvalDateItem.date }}</span>
                                        </div>
                                    </v-tooltip>
                                </template>
                            </v-text-field>

                            <v-dialog
                                persistent
                                scrollable
                                id="approvalDates"
                                v-model="approveDialog"
                                width="500"
                            >
                                <v-card>
                                    <v-card-title
                                    >
                                        <h5><strong><span>कार्ययाेजना स्विक्रित मिती सम्पादन गर्नुहोस् ।</span></strong>
                                        </h5>
                                        <v-spacer></v-spacer>
                                        <div>
                                            <a class="close" @click="closeApprovalDates"
                                            >
                                                <v-icon>mdi-close</v-icon>
                                            </a
                                            >
                                            <v-btn
                                                class=""
                                                @click="saveApprovalDates"
                                                depressed
                                                dark
                                                color="green darken-4"
                                            >
                                                <v-icon>mdi-floppy</v-icon>
                                                <span>सेभ</span>
                                            </v-btn>
                                        </div>
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <div class="mt-3">
                                            <strong
                                            >वन उपभाेक्ता समूहकाे पुर्व कार्ययाेजना स्विक्रित
                                                मितीहरु</strong
                                            >
                                        </div>
                                        <v-divider></v-divider>
                                        <div
                                            v-for="(item, approvalDateIndex) in approvalDates"
                                            :key="approvalDateIndex"
                                        >
                                            <v-row :id="`item-${approvalDateIndex}`">
                                                <v-col cols="12">
                                                    <v-text-field outlined

                                                                  label="मिती"
                                                                  hint="MM/DD/YYYY format"
                                                                  prepend-inner-icon="mdi-calendar"
                                                                  v-model="item.date"
                                                                  :readonly="isCfDataView"
                                                    >
                                                        <template v-slot:append-outer
                                                                  v-if="approvalDateIndex !== 0 && !isCfDataView">
                                                            <v-btn
                                                                @click="removeApprovalDate(approvalDateIndex)"
                                                                icon
                                                                color="error"
                                                            >
                                                                <v-icon>mdi-delete</v-icon>
                                                            </v-btn
                                                            >
                                                        </template>
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                        </div>
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn depressed color="primary" @click="addApprovalDate" v-if="!isCfDataView">
                                            <v-icon>mdi-plus</v-icon>
                                            <span>Add</span>
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.fug_pan_no"
                                          label="समूहको प्यान नं"
                                          hint="E.g. : 9327/232"
                                          placeholder="समूहको प्यान नं राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.hh"
                                          label="घरधुरी संख्या"
                                          hint="E.g. : 9327"
                                          placeholder="घरधुरी संख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field outlined
                                          v-model="cfData.population"
                                          label="कूल जनसंख्या"
                                          hint="E.g. : 932721"
                                          placeholder="कूल जनसंख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field outlined
                                          v-model="cfData.women_population"
                                          label="महिला जनसंख्या"
                                          hint="E.g. : 962721"
                                          placeholder="महिला जनसंख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field outlined
                                          v-model="cfData.men_population"
                                          label="पुरुष जनसंख्या"
                                          hint="E.g. : 932721"
                                          placeholder="पुरुष जनसंख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.area_ha"
                                          label="वनको क्षेत्रफल हे."
                                          hint="E.g. : 23"
                                          placeholder="वनको क्षेत्रफल हे. राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.scientific_forest_approval_date"
                                          label="वैज्ञानिक वन ब्यवस्थापन भएको मिती"
                                          hint="E.g. : 2010/05/20"
                                          placeholder="वैज्ञानिक वन ब्यवस्थापन भएको मिती राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.scientific_forest_area_ha"
                                          label="वैज्ञानिक वन ब्यवस्थापन भएको क्षेत्रफल हे."
                                          hint="E.g. : 230.32"
                                          placeholder="वैज्ञानिक वन ब्यवस्थापन भएको क्षेत्रफल हे. राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.forest_based_industry_operations"
                                          label="वन उद्यम संचालन"
                                          hint="E.g. : 23"
                                          placeholder="वन उद्यम संचालन राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.forest_based_tourism_operations"
                                          label="पर्यापर्यटन गतिबिधी संचालन"
                                          hint="E.g. : पदमार्ग निर्माण"
                                          placeholder="पर्यापर्यटन गतिबिधी संचालन राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <h5><strong>ठेगाना विवरण</strong></h5>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="3">
                            <v-autocomplete outlined
                                            clearable
                                            v-model="cfData.province_id"
                                            :items="provinces"
                                            item-text="name"
                                            item-value="id"
                                            label="प्रदेश"
                                            hint="E.g. : Province-4"
                                            placeholder="प्रदेश छनाैट गर्नुहाेस् ।"

                                            :readonly="isCfDataView"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-autocomplete outlined
                                            clearable
                                            v-model="cfData.district_id"
                                            :items="districts"
                                            item-text="name"
                                            item-value="id"
                                            label="जिल्ला"
                                            hint="E.g. : Kaski"
                                            placeholder="जिल्ला छनाैट गर्नुहाेस् ।"

                                            :readonly="isCfDataView"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-autocomplete outlined
                                            clearable
                                            v-model="cfData.local_level_id"
                                            :items="localLevels"
                                            item-text="name"
                                            item-value="id"
                                            label="पालिका"
                                            hint="E.g. : Pokhara Lekhnath"
                                            placeholder="पालिका छनाैट गर्नुहाेस् ।"

                                            :readonly="isCfDataView"
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.ward"
                                          label="वार्ड नं"
                                          hint="E.g. : 11"
                                          placeholder="वार्ड नं लेख्नुहोस्"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <h5><strong>कमिटी विवरण</strong></h5>
                    <v-divider></v-divider>

                    <v-row>
                        <v-col cols="4">
                            <v-text-field outlined
                                          v-model="cfData.no_of_person_in_committee"
                                          label="कमिटीमा कुल ब्यक्तिकाे संख्या"
                                          hint="E.g. : 8"
                                          placeholder="सामुदायिक वनकाे कमिटीमा कुल ब्यक्तिकाे संख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field outlined
                                          v-model="cfData.women_in_committee"
                                          label="कमिटीमा कुल महिलाकाे संख्या"
                                          hint="E.g. : 4"
                                          placeholder="सामुदायिक वनकाे कमिटीमा कुल महिलाकाे संख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field outlined
                                          v-model="cfData.men_in_committee"
                                          label="कमिटीमा कुल पुरुष संख्या"
                                          hint="E.g. : 4"
                                          placeholder="सामुदायिक वनकाे कमिटीमा कुल पुरुष संख्या राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-divider></v-divider>
                    <v-row>
                        <v-col cols="3">
                            <v-text-field outlined
                                          v-model="cfData.remarks"
                                          label="कैफियत"
                                          hint="E.g. : Remarks"
                                          placeholder="कैफियत राख्नुहाेस् ।"

                                          :readonly="isCfDataView"
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <h5><strong>अडिट रिपोर्ट</strong></h5>
                    <v-divider></v-divider>
                    <span v-if="cfData.fug_audit_reports.length > 0">
            <v-chip
                v-for="(
                auditReportItem, auditReportIndex
              ) in cfData.fug_audit_reports"
                :key="auditReportIndex"
                target="_blank"
                :to="`/storage/${cfData.id}/audit-reports/${auditReportItem.file}`"
                @click:close="deleteAuditReport(auditReportIndex)"
                class="ma-2"
                :close="!isCfDataView"
                small

                style="text-decoration: none"
            >
              {{ auditReportItem.name }}
            </v-chip>
          </span>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input
                                v-model="auditReports"
                                small-chips
                                multiple
                                label="यहा बाट फाईल अपलोड गर्नुहोस्"
                                :disabled="isCfDataView"
                            ></v-file-input>
                        </v-col>
                    </v-row>

                    <h5><strong>नक्सा फाईलहरु</strong></h5>
                    <v-divider></v-divider>
                    <span v-if="cfData.fug_maps.length > 0">
            <v-chip
                v-for="(mapItem, mapIndex) in cfData.fug_maps"
                :key="mapIndex"
                target="_blank"
                :to="`/storage/${cfData.id}/maps/${mapItem.file}`"
                @click:close="deleteMap(mapIndex)"
                class="ma-2"
                :close="!isCfDataView"
                small

                style="text-decoration: none"
            >
              {{ mapItem.name }}
            </v-chip>
          </span>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input
                                v-model="maps"
                                small-chips
                                multiple
                                label="यहा बाट फाईल अपलोड गर्नुहोस्"
                                :disabled="isCfDataView"
                            ></v-file-input>
                        </v-col>
                    </v-row>

                    <h5 v-if="JSON.stringify(cfData.kharcha)"><strong>खर्च विवरण</strong></h5>
                    <v-divider v-if="JSON.stringify(cfData.kharcha)"></v-divider>
                    <div class="item mb-3" v-if="JSON.stringify(cfData.kharcha)">
                        <div class="sub-item" v-for="(kharchaItem,kharchaIndex) in cfData.kharcha"
                             :key="kharchaIndex">
                            <v-card

                            >
                                <v-card-text>
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0"><strong>आर्थिक वर्ष: {{ kharchaItem.aarthik_barsa.name }}</strong></h5>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{on, attrs}">
                                                <v-btn
                                                    class="ma-2"
                                                    @click="editKharchaDetails(cfData.id,kharchaItem.aarthik_barsa.id)"
                                                    depressed
                                                    dark
                                                    color="blue darken-1"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                >
                                                    <v-icon>mdi-pencil</v-icon>
                                                    <span>खर्च सम्पादन गर्नुहोस्</span>
                                                </v-btn>
                                            </template>
                                            <span>Edit This Data</span>
                                        </v-tooltip>
                                    </div>
                                    <v-divider></v-divider>
                                    <div v-for="(kharchaCategory,kharchaCategoryIndex) in kharchaItem.items"
                                         :key="kharchaCategoryIndex">
                                        <div v-if="kharchaCategory.kharcha_types.length>0">
                                            <v-card class="mb-2">
                                                <v-card-text>
                                                    <p><strong>{{ kharchaCategory.title }}</strong></p>
                                                    <v-divider></v-divider>
                                                    <div class="item">
                                                        <div class="sub-item"
                                                             v-for="(kharchaType,kharchaTypeIndex) in kharchaCategory.kharcha_types"
                                                             :key="kharchaTypeIndex">
                                                            <v-card v-if="kharchaType.kharcha">
                                                                <v-card-text>
                                                                    <p><strong>{{ kharchaType.title }}</strong></p>
                                                                    <v-divider></v-divider>
                                                                    <p><strong>जम्मा</strong>: {{
                                                                            kharchaItem.items[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.jamma
                                                                        }}</p>
                                                                    <p><strong>कैफियत</strong>: {{
                                                                            kharchaItem.items[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.kaifiyat
                                                                        }}</p>
                                                                </v-card-text>
                                                            </v-card>
                                                        </div>
                                                    </div>
                                                </v-card-text>
                                            </v-card>

                                        </div>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </div>
                    </div>

                    <h5 v-if="JSON.stringify(cfData.income)"><strong>आम्दानी विवरण</strong></h5>
                    <v-divider v-if="JSON.stringify(cfData.income)"></v-divider>
                    <div class="item" v-if="JSON.stringify(cfData.income)">
                        <div class="sub-item" v-for="(incomeItem,incomeIndex) in cfData.income"
                             :key="incomeIndex">
                            <v-card

                            >
                                <v-card-text>
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0"><strong>आर्थिक वर्ष: {{ incomeItem.aarthik_barsa.name }}</strong></h5>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{on, attrs}">
                                                <v-btn
                                                    class="ma-2"
                                                    @click="editIncomeDetails(cfData.id,incomeItem.aarthik_barsa.id)"
                                                    depressed
                                                    dark
                                                    color="blue darken-1"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                >
                                                    <v-icon>mdi-pencil</v-icon>
                                                    <span>खर्च सम्पादन गर्नुहोस्</span>
                                                </v-btn>
                                            </template>
                                            <span>Edit This Data</span>
                                        </v-tooltip>
                                    </div>
                                    <v-divider></v-divider>
                                    <div v-for="(incomeCategory,incomeCategoryIndex) in incomeItem.items"
                                         :key="incomeCategoryIndex">
                                        <div v-if="incomeCategory.income_types.length>0">
                                            <v-card class="mb-2">
                                                <v-card-text>
                                                    <p><strong>{{ incomeCategory.title }}</strong></p>
                                                    <v-divider></v-divider>
                                                    <div class="item">
                                                        <div class="sub-item"
                                                             v-for="(incomeType,incomeTypeIndex) in incomeCategory.income_types"
                                                             :key="incomeTypeIndex">
                                                            <v-card v-if="incomeType.income">
                                                                <v-card-text>
                                                                    <p><strong>{{ incomeType.title }}</strong></p>
                                                                    <v-divider></v-divider>
                                                                    <p><strong>जम्मा</strong>: {{
                                                                            incomeItem.items[incomeCategoryIndex].income_types[incomeTypeIndex].income.jamma
                                                                        }}</p>
                                                                    <p><strong>कैफियत</strong>: {{
                                                                            incomeItem.items[incomeCategoryIndex].income_types[incomeTypeIndex].income.kaifiyat
                                                                        }}</p>
                                                                </v-card-text>
                                                            </v-card>
                                                        </div>
                                                    </div>
                                                </v-card-text>
                                            </v-card>

                                        </div>
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
            approveDialog: false,
            approvalDates: [
                {
                    date: "",
                },
            ],
            deletedAuditReports: [],
            auditReports: [],
            maps: [],
            deletedMaps: [],
        };
    },
    methods: {
        editKharchaDetails(cfug,aarthikBarsa){
            this.$router.push(`/kharcha-edit?cfug=${cfug}&aarthik_barsa=${aarthikBarsa}`)
        },
        editIncomeDetails(cfug,aarthikBarsa){
            this.$router.push(`/income-edit?cfug=${cfug}&aarthik_barsa=${aarthikBarsa}`)
        },
        addKharchaDetails() {
            this.$router.push(`/kharcha-edit?cfug=${this.cfData.id}`);
        },
        addIncomeDetails() {
            this.$router.push(`/income-edit?cfug=${this.cfData.id}`);
        },
        saveCfData() {
            let formData = new FormData();
            if (this.auditReports.length > 0) {
                for (var i = 0; i < this.auditReports.length; i++) {
                    let file = this.auditReports[i];
                    formData.append(`fugAuditReports[${i}]`, file);
                }
            }
            if (this.maps.length > 0) {
                for (var i = 0; i < this.maps.length; i++) {
                    let file = this.maps[i];
                    formData.append(`maps[${i}]`, file);
                }
            }
            formData.append(
                "deletedAuditReports",
                JSON.stringify(this.deletedAuditReports)
            );
            formData.append(
                "deletedMaps",
                JSON.stringify(this.deletedMaps)
            );
            formData.append("cfData", JSON.stringify(this.cfData));

            this.$store.dispatch("saveCfData", formData);
        },

        // delete audit report
        deleteAuditReport(auditReportIndex) {
            if (
                window.confirm(
                    `के तपाईं निश्चित रूपमा ${this.cfData.fug_audit_reports[auditReportIndex].name} लाई मेटाउन चाहनुहुन्छ?`
                )
            ) {
                // deleted audit reports array
                this.deletedAuditReports.push(
                    this.cfData.fug_audit_reports[auditReportIndex]
                );
                this.cfData.fug_audit_reports.splice(auditReportIndex, 1);
            }
        },
        // delete map
        deleteMap(mapIndex) {
            if (
                window.confirm(
                    `के तपाईं निश्चित रूपमा ${this.cfData.fug_maps[mapIndex].name} लाई मेटाउन चाहनुहुन्छ?`
                )
            ) {
                // deleted audit reports array
                this.deletedMaps.push(this.cfData.fug_maps[mapIndex]);
                this.cfData.fug_maps.splice(mapIndex, 1);
            }
        },

        // approval dates dialog
        closeApprovalDates() {
            this.approveDialog = false;
            if (this.cfData.fug_approval_dates.length > 0) {
                this.approvalDates = JSON.parse(
                    JSON.stringify(this.cfData.fug_approval_dates)
                );
            } else {
                this.approvalDates = [
                    {
                        date: "",
                    },
                ];
            }
        },
        saveApprovalDates() {
            this.approveDialog = false;
            this.cfData.fug_approval_dates = JSON.parse(
                JSON.stringify(this.approvalDates)
            );
        },
        addApprovalDate() {
            var tempThis = this;
            this.approvalDates.push({
                date: "",
            });
            var approvalDateLatestIndex = this.approvalDates.length - 2;
            const el = document.getElementById(`item-${approvalDateLatestIndex}`);
            console.log(el);

            if (el) {
                el.scrollIntoView({behavior: "smooth", block: "center"});
            }
            document.getElementById("approvalDates").scrollTop -= 200;
        },
        removeApprovalDate(index) {
            this.approvalDates.splice(index, 1);
        },
        // end of approval dates dialog
    },
    computed: {
        ...mapState({
            provinces: (state) => state.webservice.resources.provinces,
            isCfDataView: (state) => state.webservice.isCfDataView,
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
    mounted() {
        if (this.cfData.fug_approval_dates.length > 0) {
            this.approvalDates = JSON.parse(
                JSON.stringify(this.cfData.fug_approval_dates)
            );
        }
    },
};
</script>

<style lang="scss" scoped>
.close {
    position: absolute;
    left: 0;
    top: 0;
    background: #fff;
    border-radius: 4px;
}

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
