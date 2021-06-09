<template>
    <v-list
        dense
        nav
    >
        <div v-for="(item, i) in items" :key="i">
            <v-tooltip right>
                <template v-slot:activator="{on, attrs}">
                    <v-list-item
                        v-bind="attrs"
                        v-on="on"
                        v-if="!item.subItems && checkPermission(item.can)"
                        :to="item.route"
                        color="white"
                        link
                        router
                    >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title class="pt-1"
                            ><strong>{{ item.title }}</strong></v-list-item-title
                            >
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <span>{{ item.title }}</span>
            </v-tooltip>

            <v-tooltip right>
                <template v-slot:activator="{on, attrs}">
                    <v-list-group v-on="on" v-bind="attrs" v-if="item.subItems && checkPermissionForSubItems(item.subItems)"
                                  :prepend-icon="item.icon"
                                  color="grey lighten-3">
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title class="pt-1"
                                ><strong>{{ item.title }}</strong></v-list-item-title
                                >
                            </v-list-item-content>
                        </template>
                        <div v-for="(subItem, j) in item.subItems" :key="j" v-if="checkPermission(subItem.can)"
                        >
                            <v-tooltip right>
                                <template v-slot:activator="{on, attrs}">
                                    <v-list-item
                                        v-bind="attrs"
                                        v-on="on"
                                        :to="subItem.route"
                                        color="white"
                                        link
                                        router
                                    >
                                        <v-list-item-icon>
                                            <v-icon>{{ subItem.icon }}</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title class="pt-1"
                                            ><strong>{{ subItem.title }}</strong></v-list-item-title
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                </template>
                                <span>{{ subItem.title }}</span>
                            </v-tooltip>
                        </div>
                    </v-list-group>
                </template>
                <span>{{ item.title }}</span>
            </v-tooltip>
        </div>
    </v-list>
</template>

<script>
import {mapState} from "vuex";

export default {
    data() {
        return {
            miniVariant: false,
            items: [
                {title: "ड्यसबोर्ड", icon: "mdi-view-dashboard", route: "/dashboard", can: "dashboard-browse"},
                {title: "गृहपृष्ठ", icon: "mdi-home", route: "/home", can: "home-browse"},
                {
                    title: "खाताहरु", icon: "mdi-account-circle", route: "/users", subItems: [
                        {
                            title: "प्रयोगकर्ताहरू",
                            icon: "mdi-account-circle",
                            route: "/users",
                            can: "users-browse"
                        },
                        {title: "भूमिकाहरू", icon: "mdi-account-settings", route: "/roles", can: "roles-browse"},
                        {title: "अनुमतिहरू", icon: "mdi-key", route: "/permissions", can: "permissions-browse"}
                    ]
                },
                {
                    title: "फारम", icon: "mdi-note", subItems: [
                        {title: "सामुदायिक वन थप", icon: "mdi-plus", route: "/cf-data-edit", can: "dashboard-browse"},
                        {
                            title: "खर्च विवरण थप",
                            icon: "mdi-cash-plus",
                            route: "/kharcha-edit",
                            can: "dashboard-browse"
                        },
                        {
                            title: "आम्दानी विवरण थप",
                            icon: "mdi-cash-minus",
                            route: "/income-edit",
                            can: "dashboard-browse"
                        },
                    ]
                },
                {
                    title: "प्रतिवेदन", icon: "mdi-file-document", subItems: [
                        {
                            title: "सामुदायिक वन विवरण",
                            icon: "mdi-border-all",
                            route: "/cf-data",
                            can: "dashboard-browse"
                        },
                        {title: "खर्च विवरण", icon: "mdi-cash-plus", route: "/kharcha", can: "dashboard-browse"},
                        {title: "आम्दानी विवरण", icon: "mdi-cash-minus", route: "/income", can: "dashboard-browse"},
                    ]
                },
                {
                    title: "संसाधनहरु", icon: "mdi-folder", subItems: [
                        {title: 'आर्थिक वर्ष', icon: 'mdi-calendar', route: '/aarthik-barsa', can: "dashboard-browse"},
                        {title: 'कार्यलय', icon: 'mdi-folder', route: '/kaaryalaya', can: "kaaryalaya-browse"},
                        {
                            title: 'खर्च बर्गिकरणहरु',
                            icon: 'mdi-cash-plus',
                            route: '/kharcha-categories',
                            can: "dashboard-browse"
                        },
                        {
                            title: 'खर्च प्रकारहरु',
                            icon: 'mdi-cash-plus',
                            route: '/kharcha-types',
                            can: "dashboard-browse"
                        },
                        {
                            title: 'आम्दानी बर्गिकरणहरु',
                            icon: 'mdi-cash-minus',
                            route: '/income-categories',
                            can: "dashboard-browse"
                        },
                        {
                            title: 'आम्दानी प्रकारहरु',
                            icon: 'mdi-cash-minus',
                            route: '/income-types',
                            can: "dashboard-browse"
                        },
                    ]
                },
            ],
        };
    },
    computed: {
        ...mapState({
            userPermissions: (state) => state.webservice.resources.userPermissions
        })
    },
    methods: {
        setMiniVariant() {
            var tempthis = this;
            this.miniVariant = !this.miniVariant;
            this.$store.dispatch("setMiniVariant", tempthis.miniVariant);
        },
        checkPermission(can) {
            const tempthis = this;
            return tempthis.userPermissions.includes(can);
        },
        checkPermissionForSubItems(subItems) {
            var count = 0;
            let tempthis = this;
            subItems.forEach(function (item) {
                if (tempthis.checkPermission(item.can)) {
                    count++;
                }
            });
            if (count === 0) {
                return false;
            }
            return true;
        }
    },
};
</script>

<style lang="scss" scoped>
.v-list-item {
    text-decoration: none;
}

.v-list-group {
    &--active {
        background: #0e360c;
        border-radius: 5px;
    }

}
</style>
