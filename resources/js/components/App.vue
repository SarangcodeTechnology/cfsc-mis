<template>
    <v-app>
        <v-navigation-drawer app>
            <navigation-drawer/>
        </v-navigation-drawer>

        <v-app-bar app>
            <v-spacer></v-spacer>
            <app-bar/>
        </v-app-bar>
        <v-main>
            <router-view>
            </router-view>
        </v-main>
        <v-footer app>
        </v-footer>
        <notification-list/>
    </v-app>
</template>

<script>
export default {
    data() {
        return {}
    },
}
</script>

<style scoped>

</style>
