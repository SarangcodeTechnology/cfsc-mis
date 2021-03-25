<template>
    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
    >
        <v-container>
            <h5>Basic Details</h5>
            <v-row>
                <v-col cols="12" md="4">
                    <v-text-field
                    v-model="fugName"
                    :rules="nameRules"
                    label="FUG Name"
                    required
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                    <v-text-field
                    v-model="fugCode"
                    label="FUG Code"
                    ></v-text-field>
                </v-col>
            </v-row>
            <h5>Address Details</h5>
            <v-row>
                <v-col cols="12" md="4">
                        <v-select
                        v-model="select"
                        :items="items"
                        :error-messages="errors"
                        label="Province"
                        data-vv-name="select"
                        required
                        ></v-select>
                </v-col>
            </v-row>
        </v-container>

    </v-form>
</template>

<script>
export default {
    data() {
        return {}
    },
    methods: {}

}
</script>

<style scoped></style>
