<template>
    <v-container fluid>
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">
                    CFSC MIS
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list
            dense
            nav
        >
            <v-list-item
                v-for="item in items"
                :key="item.title"
                link
                :to="item.route"
                router
            >
                <v-list-item-icon>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {title: 'Dashboard', icon: 'mdi-view-dashboard', route: '/dashboard'},
                {title: 'Home', icon: 'mdi-home', route: '/home'},
                {title: 'Trial', icon: 'mdi-border-all', route: '/trial'},
            ],
        }
    },
}
</script>

<style scoped>
.v-list-item {
    text-decoration: none;
}
</style>
