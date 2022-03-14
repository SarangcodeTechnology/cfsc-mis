<template>
    <v-form ref="form" v-model="valid">
        <v-toolbar color="#E0E0E0" dark flat></v-toolbar>
        <v-card class="mx-11 my-n11">
            <v-toolbar flat>
                <v-toolbar-title>
                    <strong>समुह विवरण फारम</strong>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                    <template v-slot:activator="{on, attrs}">
                        <v-btn
                            :disabled="!valid"
                            class="ma-2"
                            color="green darken-1"
                            depressed
                            v-bind="attrs"
                            @click="saveCfData()"
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

            <v-container fluid>
                     <span
                     >कृपया तलकाे फारम मार्फत आफ्नाे विवरण सूचना प्रणालीमा सुनिश्चित गर्नुहाेस् ।</span
                     >
                <v-divider></v-divider>
                <h5><strong>परिचय विवरण</strong></h5>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="4">
                        <v-select v-model="cfData.cfug_type_id"
                                  :items="cfugTypes"
                                  :readonly="isCfDataView"
                                  item-text="name"
                                  item-value="id"
                                  label="वनकाे प्रकार (CFUG Type)"
                                  outlined
                                  placeholder="वनकाे प्रकार राख्नुहाेस् ।"
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field v-model="cfData.fug_name"
                                      :readonly="isCfDataView"
                                      hint="E.g. : Ukhubari"
                                      label="समुहकाे नाम"
                                      outlined

                                      placeholder="समुहकाे नाम राख्नुहाेस् ।"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.fug_code"
                                      :readonly="isCfDataView"
                                      hint="E.g. : KAS/NI/06/20"
                                      label="समुहकाे काेड (FUG Code)"
                                      outlined
                                      placeholder="समुहकाे काेड राख्नुहाेस् ।"

                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="4">
                        <v-text-field v-if="approvalDates[0]"
                                      v-model="approvalDates[0].date"
                                      :readonly="isCfDataView"
                                      hint="E.g. : 2070/06/12"
                                      label="स्विक्रित मिती"
                                      outlined
                                      placeholder="स्विक्रित मिती राख्नुहाेस् ।"
                                      @change="saveApprovalDates"

                        >
                            <template v-slot:append-outer>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            color="primary"
                                            dark
                                            depressed
                                            small
                                            v-bind="attrs"
                                            @click="approveDialog = true"
                                            v-on="on"
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
                            id="approvalDates"
                            v-model="approveDialog"
                            persistent
                            scrollable
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
                                            color="green darken-4"
                                            dark
                                            depressed
                                            @click="saveApprovalDates"
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
                                                <v-text-field v-model="item.date"

                                                              :readonly="isCfDataView"
                                                              hint="MM/DD/YYYY format"
                                                              label="मिती"
                                                              outlined
                                                              prepend-inner-icon="mdi-calendar"
                                                >
                                                    <template v-if="approvalDateIndex !== 0 && !isCfDataView"
                                                              v-slot:append-outer>
                                                        <v-btn
                                                            color="error"
                                                            icon
                                                            @click="removeApprovalDate(approvalDateIndex)"
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
                                    <v-btn v-if="!isCfDataView" color="primary" depressed @click="addApprovalDate">
                                        <v-icon>mdi-plus</v-icon>
                                        <span>Add</span>
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.fug_pan_no"
                                      :readonly="isCfDataView"
                                      :rules="[(v) => !!v || 'समूहको प्यान नं अनिवार्य छ']"
                                      hint="E.g. : 9327/232"
                                      label="समूहको प्यान नं*"
                                      outlined
                                      placeholder="समूहको प्यान नं राख्नुहाेस् ।"
                        >
                        </v-text-field>
                    </v-col>


                    <v-col cols="3">
                        <v-text-field v-model="cfData.area_ha"
                                      :readonly="isCfDataView"
                                      hint="E.g. : 23"
                                      label="वनको क्षेत्रफल हे."
                                      outlined
                                      placeholder="वनको क्षेत्रफल हे. राख्नुहाेस् ।"

                                      type="number"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.scientific_forest_approval_date"
                                      :readonly="isCfDataView"
                                      hint="E.g. : 2010/05/20"
                                      label="वैज्ञानिक वन ब्यवस्थापन भएको मिती"
                                      outlined

                                      placeholder="वैज्ञानिक वन ब्यवस्थापन भएको मिती राख्नुहाेस् ।"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.scientific_forest_area_ha"
                                      :readonly="isCfDataView"
                                      hint="E.g. : 230.32"
                                      label="वैज्ञानिक वन ब्यवस्थापन भएको क्षेत्रफल हे."
                                      outlined

                                      placeholder="वैज्ञानिक वन ब्यवस्थापन भएको क्षेत्रफल हे. राख्नुहाेस् ।"
                        >
                        </v-text-field>
                    </v-col>

                </v-row>
                <h5><strong>ठेगाना विवरण</strong></h5>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="3">
                        <v-select v-model="cfData.division_id"
                                  :items="divisions"
                                  :readonly="isCfDataView"
                                  item-text="name"
                                  item-value="id"
                                  label="डिभिजन"
                                  outlined
                                  placeholder="डिभिजन राख्नुहाेस् ।"
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="3">
                        <v-select v-model="cfData.subdivision_id"
                                  :items="subDivisions"
                                  :readonly="isCfDataView"
                                  item-text="name"
                                  item-value="id"
                                  label="सबडिभिजन"
                                  outlined
                                  placeholder="सबडिभिजन राख्नुहाेस् ।"
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="3">
                        <v-autocomplete v-model="cfData.province_id"
                                        :items="provinces"
                                        :readonly="isCfDataView"
                                        clearable
                                        hint="E.g. : Province-4"
                                        item-text="name"
                                        item-value="id"
                                        label="प्रदेश"
                                        outlined

                                        placeholder="प्रदेश छनाैट गर्नुहाेस् ।"
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="3">
                        <v-autocomplete v-model="cfData.district_id"
                                        :items="districts"
                                        :readonly="isCfDataView"
                                        clearable
                                        hint="E.g. : Kaski"
                                        item-text="name"
                                        item-value="id"
                                        label="जिल्ला"
                                        outlined

                                        placeholder="जिल्ला छनाैट गर्नुहाेस् ।"
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="3">
                        <v-autocomplete v-model="cfData.local_level_id"
                                        :items="localLevels"
                                        :readonly="isCfDataView"
                                        clearable
                                        hint="E.g. : Pokhara Lekhnath"
                                        item-text="name"
                                        item-value="id"
                                        label="पालिका"
                                        outlined

                                        placeholder="पालिका छनाैट गर्नुहाेस् ।"
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.ward"
                                      :readonly="isCfDataView"
                                      hint="E.g. : 11"
                                      label="वार्ड नं"
                                      outlined

                                      placeholder="वार्ड नं लेख्नुहोस्"
                        >
                        </v-text-field>
                    </v-col>
                </v-row>

                <v-divider></v-divider>
                <v-row>
                    <v-col cols="3">
                        <v-text-field v-model="cfData.remarks"
                                      :readonly="isCfDataView"
                                      hint="E.g. : Remarks"
                                      label="कैफियत"
                                      outlined

                                      placeholder="कैफियत राख्नुहाेस् ।"
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
                :close="!isCfDataView"
                :to="`/storage/${cfData.id}/audit-reports/${auditReportItem.file}`"
                class="ma-2"
                small
                style="text-decoration: none"
                target="_blank"

                @click:close="deleteAuditReport(auditReportIndex)"
            >
              {{ auditReportItem.name }}
            </v-chip>
          </span>
                <v-row>
                    <v-col cols="12">
                        <v-file-input
                            v-model="auditReports"
                            :disabled="isCfDataView"
                            label="यहा बाट फाईल अपलोड गर्नुहोस्"
                            multiple
                            small-chips
                        ></v-file-input>
                    </v-col>
                </v-row>

                <h5><strong>नक्सा फाईलहरु</strong></h5>
                <v-divider></v-divider>
                <span v-if="cfData.fug_maps.length > 0">
            <v-chip
                v-for="(mapItem, mapIndex) in cfData.fug_maps"
                :key="mapIndex"
                :close="!isCfDataView"
                :to="`/storage/${cfData.id}/maps/${mapItem.file}`"
                class="ma-2"
                small
                style="text-decoration: none"
                target="_blank"

                @click:close="deleteMap(mapIndex)"
            >
              {{ mapItem.name }}
            </v-chip>
          </span>
                <v-row>
                    <v-col cols="12">
                        <v-file-input
                            v-model="maps"
                            :disabled="isCfDataView"
                            label="यहा बाट फाईल अपलोड गर्नुहोस्"
                            multiple
                            small-chips
                        ></v-file-input>
                    </v-col>
                </v-row>


                <v-row>
                    <v-col cols="auto"><h5><strong>आ.व. विवरण</strong></h5></v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="auto">
                        <v-tooltip v-if="cfData.id" bottom>
                            <template v-slot:activator="{on, attrs}">
                                <v-btn
                                    v-if="cfData.id"
                                    class="ma-2"
                                    color="blue darken-1"
                                    dark
                                    depressed
                                    v-bind="attrs"
                                    @click="addFyDetails()"
                                    v-on="on"
                                >
                                    <v-icon>mdi-calendar</v-icon>
                                    <span>आ.व. विवरणहरू थप्नुहोस्</span>
                                </v-btn>
                            </template>
                            <span>Add Fiscal Year Data</span>
                        </v-tooltip>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12">
                        <v-data-table
                            :headers="headersFyData"
                            :hide-default-footer="true"
                            :items="cfData.cf_fy_data"
                            :items-per-page="20"
                            :loading="loadingFyData"
                            :options.sync="optionsFyData"
                            :page="pageFyData"
                            :pageCount="numberOfPagesFyData"
                            :search="searchFyData"
                            fixed-header
                            height="500px"
                            loading-text="Loading Data... Please wait"
                        >
                            <template v-slot:top="{ pagination, options, updateOptions }">
                                <v-row>
                                    <v-col cols="3">
                                        <v-text-field v-model="searchFyData" append-icon="mdi-magnify"
                                                      dense
                                                      label="Search"
                                                      outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-spacer></v-spacer>
                                    <v-col cols="auto">
                                        <v-data-footer
                                            :options="options"
                                            :pagination="pagination"
                                            items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <div class="d-flex justify-content-center align-items-center">
                                    <v-btn icon x-small
                                           @click="editFyDetails(item.id,item.fug_id,item.aarthik_barsa_id)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>

                                    <v-btn color="red" icon x-small @click="confirm(item)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </div>
                            </template>
                            <template v-slot:item.title="{ item }">{{ item.title }}
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>


                <v-row>
                    <v-col cols="auto"><h5><strong>खर्च विवरण</strong></h5></v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="auto">
                        <v-tooltip v-if="cfData.id" bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-if="cfData.id"
                                    class="ma-2"
                                    color="blue darken-1"
                                    dark
                                    depressed
                                    v-bind="attrs"
                                    @click="addIncomeDetails()"
                                    v-on="on"
                                >
                                    <v-icon>mdi-cash-plus</v-icon>
                                    <span>आम्दानी विवरणहरू थप्नुहोस्</span>
                                </v-btn>
                            </template>
                            <span>Add Income Data</span>
                        </v-tooltip>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12">
                        <v-data-table
                            :headers="headersKharcha"
                            :hide-default-footer="true"
                            :items="cfData.kharcha"
                            :items-per-page="20"
                            :loading="loadingKharcha"
                            :options.sync="optionsKharcha"
                            :page="pageKharcha"
                            :pageCount="numberOfPagesKharcha"
                            :search="searchKharcha"
                            fixed-header
                            height="500px"
                            loading-text="Loading Data... Please wait"
                        >
                            <template v-slot:header>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th v-for="categoryItem in categoryHeaderKharcha"
                                        :colspan="categoryItem.colspan"
                                        class="d-flex-inline align-content-center justify-content-center">
                                        <h6><strong>{{ categoryItem.title }}</strong></h6></th>
                                </tr>
                                </thead>
                            </template>
                            <template v-slot:top="{ pagination, options, updateOptions }">
                                <v-row>
                                    <v-col cols="3">
                                        <v-text-field v-model="searchKharcha" append-icon="mdi-magnify"
                                                      dense
                                                      label="Search"
                                                      outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-spacer></v-spacer>
                                    <v-col cols="auto">
                                        <v-data-footer
                                            :options="options"
                                            :pagination="pagination"
                                            items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <div class="d-flex justify-content-center align-items-center">
                                    <v-btn icon x-small @click="editKharchaDetails(item.fug.id,item.aarthik_barsa.id)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>

                                    <v-btn color="red" icon x-small @click="confirm(item)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </div>
                            </template>
                            <template v-slot:item.title="{ item }">{{ item.title }}
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="auto">
                        <h5><strong>आम्दानी विवरण</strong></h5>
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col cols="auto">
                        <v-tooltip v-if="cfData.id" bottom>
                            <template v-slot:activator="{on, attrs}">
                                <v-btn
                                    v-if="cfData.id"
                                    class="ma-2"
                                    color="blue darken-1"
                                    dark
                                    depressed
                                    v-bind="attrs"
                                    @click="addKharchaDetails()"
                                    v-on="on"
                                >
                                    <v-icon>mdi-cash-minus</v-icon>
                                    <span>खर्च विवरणहरू थप्नुहोस्</span>
                                </v-btn>
                            </template>
                            <span>Add Expenditure Data</span>
                        </v-tooltip>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row>
                    <v-col cols="12">
                        <v-data-table
                            :headers="headersIncome"
                            :hide-default-footer="true"
                            :items="cfData.income"
                            :items-per-page="20"
                            :loading="loadingIncome"
                            :options.sync="optionsIncome"
                            :page="pageIncome"
                            :pageCount="numberOfPagesIncome"
                            :search="searchIncome"
                            fixed-header
                            height="500px"
                            loading-text="Loading Data... Please wait"
                        >
                            <template v-slot:header>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th v-for="categoryItem in categoryHeaderIncome"
                                        :colspan="categoryItem.colspan"
                                        class="d-flex-inline align-content-center justify-content-center">
                                        <h6><strong>{{ categoryItem.title }}</strong></h6></th>
                                </tr>
                                </thead>
                            </template>
                            <template v-slot:top="{ pagination, options, updateOptions }">
                                <v-row>
                                    <v-col cols="3">
                                        <v-text-field v-model="searchIncome" append-icon="mdi-magnify"
                                                      dense
                                                      label="Search"
                                                      outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-spacer></v-spacer>
                                    <v-col cols="auto">
                                        <v-data-footer
                                            :options="options"
                                            :pagination="pagination"
                                            items-per-page-text="$vuetify.dataTable.itemsPerPageText"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <div class="d-flex justify-content-center align-items-center">
                                    <v-btn icon x-small @click="editIncomeDetails(item.fug.id,item.aarthik_barsa.id)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>

                                    <v-btn color="red" icon x-small @click="confirm(item)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </div>
                            </template>
                            <template v-slot:item.title="{ item }">{{ item.title }}
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>


                <!--                    <div class="item mb-3" v-if="JSON.stringify(cfData.kharcha)">-->
                <!--                        <div class="sub-item" v-for="(kharchaItem,kharchaIndex) in cfData.kharcha"-->
                <!--                             :key="kharchaIndex">-->
                <!--                            <v-card-->

                <!--                            >-->
                <!--                                <v-card-text>-->
                <!--                                    <div class="d-flex align-items-center">-->
                <!--                                        <h5 class="mb-0"><strong>आर्थिक वर्ष: {{-->
                <!--                                                kharchaItem.aarthik_barsa.name-->
                <!--                                            }}</strong></h5>-->
                <!--                                        <v-tooltip bottom>-->
                <!--                                            <template v-slot:activator="{on, attrs}">-->
                <!--                                                <v-btn-->
                <!--                                                    class="ma-2"-->
                <!--                                                    @click="editKharchaDetails(cfData.id,kharchaItem.aarthik_barsa.id)"-->
                <!--                                                    depressed-->
                <!--                                                    dark-->
                <!--                                                    color="blue darken-1"-->
                <!--                                                    v-bind="attrs"-->
                <!--                                                    v-on="on"-->
                <!--                                                >-->
                <!--                                                    <v-icon>mdi-pencil</v-icon>-->
                <!--                                                    <span>खर्च सम्पादन गर्नुहोस्</span>-->
                <!--                                                </v-btn>-->
                <!--                                            </template>-->
                <!--                                            <span>Edit This Data</span>-->
                <!--                                        </v-tooltip>-->
                <!--                                    </div>-->
                <!--                                    <v-divider></v-divider>-->
                <!--                                    <div v-for="(kharchaCategory,kharchaCategoryIndex) in kharchaItem.items"-->
                <!--                                         :key="kharchaCategoryIndex">-->
                <!--                                        <div v-if="kharchaCategory.kharcha_types.length>0">-->
                <!--                                            <v-card class="mb-2">-->
                <!--                                                <v-card-text>-->
                <!--                                                    <p><strong>{{ kharchaCategory.title }}</strong></p>-->
                <!--                                                    <v-divider></v-divider>-->
                <!--                                                    <div class="item">-->
                <!--                                                        <div class="sub-item"-->
                <!--                                                             v-for="(kharchaType,kharchaTypeIndex) in kharchaCategory.kharcha_types"-->
                <!--                                                             :key="kharchaTypeIndex">-->
                <!--                                                            <v-card v-if="kharchaType.kharcha">-->
                <!--                                                                <v-card-text>-->
                <!--                                                                    <p><strong>{{ kharchaType.title }}</strong></p>-->
                <!--                                                                    <v-divider></v-divider>-->
                <!--                                                                    <p><strong>जम्मा</strong>: {{-->
                <!--                                                                            kharchaItem.items[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.jamma-->
                <!--                                                                        }}</p>-->
                <!--                                                                    <p><strong>कैफियत</strong>: {{-->
                <!--                                                                            kharchaItem.items[kharchaCategoryIndex].kharcha_types[kharchaTypeIndex].kharcha.kaifiyat-->
                <!--                                                                        }}</p>-->
                <!--                                                                </v-card-text>-->
                <!--                                                            </v-card>-->
                <!--                                                        </div>-->
                <!--                                                    </div>-->
                <!--                                                </v-card-text>-->
                <!--                                            </v-card>-->

                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </v-card-text>-->
                <!--                            </v-card>-->
                <!--                        </div>-->
                <!--                    </div>-->

                <!--                    <h5 v-if="JSON.stringify(cfData.income)"><strong>आम्दानी विवरण</strong></h5>-->
                <!--                    <v-divider v-if="JSON.stringify(cfData.income)"></v-divider>-->
                <!--                    <div class="item" v-if="JSON.stringify(cfData.income)">-->
                <!--                        <div class="sub-item" v-for="(incomeItem,incomeIndex) in cfData.income"-->
                <!--                             :key="incomeIndex">-->
                <!--                            <v-card-->

                <!--                            >-->
                <!--                                <v-card-text>-->
                <!--                                    <div class="d-flex align-items-center">-->
                <!--                                        <h5 class="mb-0"><strong>आर्थिक वर्ष: {{-->
                <!--                                                incomeItem.aarthik_barsa.name-->
                <!--                                            }}</strong></h5>-->
                <!--                                        <v-tooltip bottom>-->
                <!--                                            <template v-slot:activator="{on, attrs}">-->
                <!--                                                <v-btn-->
                <!--                                                    class="ma-2"-->
                <!--                                                    @click="editIncomeDetails(cfData.id,incomeItem.aarthik_barsa.id)"-->
                <!--                                                    depressed-->
                <!--                                                    dark-->
                <!--                                                    color="blue darken-1"-->
                <!--                                                    v-bind="attrs"-->
                <!--                                                    v-on="on"-->
                <!--                                                >-->
                <!--                                                    <v-icon>mdi-pencil</v-icon>-->
                <!--                                                    <span>खर्च सम्पादन गर्नुहोस्</span>-->
                <!--                                                </v-btn>-->
                <!--                                            </template>-->
                <!--                                            <span>Edit This Data</span>-->
                <!--                                        </v-tooltip>-->
                <!--                                    </div>-->
                <!--                                    <v-divider></v-divider>-->
                <!--                                    <div v-for="(incomeCategory,incomeCategoryIndex) in incomeItem.items"-->
                <!--                                         :key="incomeCategoryIndex">-->
                <!--                                        <div v-if="incomeCategory.income_types.length>0">-->
                <!--                                            <v-card class="mb-2">-->
                <!--                                                <v-card-text>-->
                <!--                                                    <p><strong>{{ incomeCategory.title }}</strong></p>-->
                <!--                                                    <v-divider></v-divider>-->
                <!--                                                    <div class="item">-->
                <!--                                                        <div class="sub-item"-->
                <!--                                                             v-for="(incomeType,incomeTypeIndex) in incomeCategory.income_types"-->
                <!--                                                             :key="incomeTypeIndex">-->
                <!--                                                            <v-card v-if="incomeType.income">-->
                <!--                                                                <v-card-text>-->
                <!--                                                                    <p><strong>{{ incomeType.title }}</strong></p>-->
                <!--                                                                    <v-divider></v-divider>-->
                <!--                                                                    <p><strong>जम्मा</strong>: {{-->
                <!--                                                                            incomeItem.items[incomeCategoryIndex].income_types[incomeTypeIndex].income.jamma-->
                <!--                                                                        }}</p>-->
                <!--                                                                    <p><strong>कैफियत</strong>: {{-->
                <!--                                                                            incomeItem.items[incomeCategoryIndex].income_types[incomeTypeIndex].income.kaifiyat-->
                <!--                                                                        }}</p>-->
                <!--                                                                </v-card-text>-->
                <!--                                                            </v-card>-->
                <!--                                                        </div>-->
                <!--                                                    </div>-->
                <!--                                                </v-card-text>-->
                <!--                                            </v-card>-->

                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </v-card-text>-->
                <!--                            </v-card>-->
                <!--                        </div>-->
                <!--                    </div>-->
            </v-container>
        </v-card>
    </v-form>
</template>

<script>
import {mapState} from "vuex";

export default {
    data() {
        return {
            searchKharcha: "",
            pageKharcha: 1,
            numberOfPagesKharcha: 0,
            optionsKharcha: {},
            loadingKharcha: false,

            searchIncome: "",
            pageIncome: 1,
            numberOfPagesIncome: 0,
            optionsIncome: {},
            loadingIncome: false,

            searchFyData: "",
            pageFyData: 1,
            numberOfPagesFyData: 0,
            optionsFyData: {},
            loadingFyData: false,
            headersFyData: [
                {text: "कार्यहरू", value: "actions"},
                {text: "घरधुरी संख्या", value: "hh"},
                {text: "कूल जनसंख्या", value: "population"},
                {text: "महिला जनसंख्या", value: "women_population"},
                {text: "पुरुष जनसंख्या", value: "men_population"},
                {text: "कार्यसमिति कूल संख्या", value: "no_of_person_in_committee"},
                {text: "कार्यसमितिमा महिला संख्या", value: "women_in_committee"},
                {text: "कार्यसमितिमा पुरुष संख्या", value: "men_in_committee"},
                {text: "वन उद्यम संचालन", value: "forest_based_industry_operations"},
                {
                    text: "पर्यापर्यटन गतिबिधी संचालन",
                    value: "forest_based_tourism_operations",
                },
            ],

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
            headersKharcha: [],
            categoryHeaderKharcha: [],
            headersIncome: [],
            categoryHeaderIncome: [],
        };
    },
    methods: {
        addFyDetails() {
            this.$router.push(`/fug-fy-data-edit?fug=${this.cfData.id}`);
        },
        editFyDetails(id,fug, aarthikBarsa) {
            this.$router.push(`/fug-fy-data-edit?id=${id}&fug=${fug}&aarthik_barsa=${aarthikBarsa}`)
        },
        editKharchaDetails(cfug, aarthikBarsa) {
            this.$router.push(`/kharcha-edit?cfug=${cfug}&aarthik_barsa=${aarthikBarsa}`)
        },
        editIncomeDetails(cfug, aarthikBarsa) {
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
            cfugTypes: (state) => state.webservice.resources.cfug_types,
            divisions: (state) => state.webservice.resources.divisions,
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
        const tempthis = this;
        this.$store.dispatch("makeGetRequest", {
            route: 'get-kharcha-headers',
            data: {filterData: this.filterData}
        }).then(function (response) {
            tempthis.headersKharcha = response.data.data.headers;
            tempthis.categoryHeaderKharcha = response.data.data.categoryHeader;
        });

        this.$store.dispatch("makeGetRequest", {
            route: 'get-income-headers',
            data: {filterData: this.filterData}
        }).then(function (response) {
            tempthis.headersIncome = response.data.data.headers;
            tempthis.categoryHeaderIncome = response.data.data.categoryHeader;
        });
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
