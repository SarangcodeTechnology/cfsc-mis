<template>
    <v-app>
        <v-navigation-drawer
            v-model="expandDrawer"
            :expand-on-hover="expandOnHover"
            :mini-variant="miniVariant"
            app
            color="#2E7D32"
            dark
        >
            <v-list dense nav>
                <v-list-item class="pl-1 d-flex align-items-center">
                    <v-list-item-avatar>
                        <v-btn class="mr-1" icon @click.stop="miniVariant = !miniVariant">
                            <v-icon v-if="!miniVariant" class="fas fa-chevron-left"></v-icon>
                            <v-icon v-if="miniVariant" class="fas fa-chevron-right"></v-icon>
                        </v-btn>
                    </v-list-item-avatar>
                    <v-list-item-title class="title">
                        <span>CFSC MIS</span>
                    </v-list-item-title>
                </v-list-item>
            </v-list>
            <navigation-drawer/>
        </v-navigation-drawer>

        <v-app-bar app color="#E0E0E0" flat>
            <v-app-bar-nav-icon
                @click.stop="expandDrawer = !expandDrawer"
            ></v-app-bar-nav-icon>
            <v-btn icon @click="goBack">
                <v-icon>mdi-arrow-left</v-icon>
            </v-btn>
            <v-btn icon @click="goForward">
                <v-icon>mdi-arrow-right</v-icon>
            </v-btn>
            <v-btn icon @click="refresh">
                <v-icon>mdi-refresh</v-icon>
            </v-btn>
            <v-container fluid>
                <v-breadcrumbs :items="breadcrumbs">
                    <template v-slot:item="{ item }">
                        <v-breadcrumbs-item :to="item.meta.breadcrumb.link" router>
                            {{ item.meta.breadcrumb.text }}
                        </v-breadcrumbs-item>
                    </template>
                </v-breadcrumbs>
            </v-container>

            <app-bar/>
        </v-app-bar>
        <v-main>
            <router-view></router-view>
        </v-main>
        <!--        <v-footer app>-->
        <!--        </v-footer>-->
        <notification-list/>
        <confirm-dialog ref="confirm"/>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            expandDrawer: true,
            expandOnHover: false,
            miniVariant: false,
        };
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        goForward() {
            this.$router.go(1);
        },
        refresh() {
            this.$router.go(0);
        },
    },
    computed: {
        breadcrumbs: function () {
            return this.$route.matched;
        },
    },
    mounted() {
        this.$root.confirm = this.$refs.confirm.open;
    }

};
</script>

<style lang="scss">

.theme--light.v-data-table .v-data-footer {
    border-top: none !important;
}

::-webkit-scrollbar {
    width: 8px;
    height: 8px;
    background-color: #f5f5f5;
}

::-webkit-scrollbar-track {
    background-color: #f5f5f5;
}

::-webkit-scrollbar-thumb {
    background-color: #9e9e9e;
}
</style>
