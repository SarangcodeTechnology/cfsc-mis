<template>
    <v-list dense nav>
        <div v-for="(item, i) in items" :key="i">
            <v-list-item
                v-if="!item.subItems && checkPermission(item.check)"
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
            <v-list-group v-if="item.subItems && checkPermissionForSubItems(item.subItems)" :prepend-icon="item.icon"
                          color="grey darken-4">
                <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title class="pt-1"
                        ><strong>{{ item.title }}</strong></v-list-item-title
                        >
                    </v-list-item-content>
                </template>
                <v-list-item
                    v-for="(subItem, j) in item.subItems"
                    v-if="checkPermission(subItem.check)"
                    :key="j"
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
            </v-list-group>
            <v-divider class="ma-0 pa-0"></v-divider>
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
                {title: "ड्यसबोर्ड", icon: "mdi-view-dashboard", route: "/dashboard", check: "can_browse_dashboard"},
                {title: "गृहपृष्ठ", icon: "mdi-home", route: "/home", check: "can_browse_home"},
                {
                    title: "खाताहरु", icon: "mdi-account-circle", route: "/users", subItems: [
                        {
                            title: "प्रयोगकर्ताहरू",
                            icon: "mdi-account-circle",
                            route: "/users",
                            check: "can_browse_users"
                        },
                        {title: "भूमिकाहरू", icon: "mdi-account-settings", route: "/roles", check: "can_browse_roles"},
                        {title: "अनुमतिहरू", icon: "mdi-key", route: "/permissions", check: "can_browse_permissions"}
                    ]
                },
                {title: "सामुदायिक वन थप", icon: "mdi-plus", route: "/cf-data-edit", check: "can_browse_cfdata"},
                {title: "सामुदायिक वन विवरण", icon: "mdi-border-all", route: "/cf-data", check: "can_browse_cfdata"},
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
        checkPermission(check) {
            return this.userPermissions.includes(check);
        },
        checkPermissionForSubItems(subItems) {
            var count = 0;
            let tempthis = this;
            subItems.forEach(function (item) {
                if (tempthis.checkPermission(item.check)) {
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

<style scoped>
.v-list-item {
    text-decoration: none;
}
</style>
