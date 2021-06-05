<template>
<v-container fluid>
    <v-row>
        <v-col>
            <v-data-table
                :headers="headers"
                :hide-default-footer="true"
                :items="roles"
                :items-per-page="20"
                :loading="loading"
                :options.sync="options"
                :page="page"
                :pageCount="numberOfPages"
                fixed-header
                loading-text="Loading Data... Please wait"
            >
            </v-data-table>
        </v-col>
    </v-row>
</v-container>
</template>

<script>
export default {
    name: "Browse"
}
</script>

<style scoped>

</style>
