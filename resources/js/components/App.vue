<template>
    <v-app>
    <v-navigation-drawer app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Application
          </v-list-item-title>
          <v-list-item-subtitle>
            subtext
          </v-list-item-subtitle>
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
          :to = "item.route"
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
    </v-navigation-drawer>

        <v-app-bar app>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <router-view>
                </router-view>
            </v-container>
        </v-main>
        <v-footer app>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        data () {
        return {
            items: [
            { title: 'Dashboard', icon: 'mdi-view-dashboard' },
            { title: 'Login', icon: 'mdi-image' , route: '/login' },
            { title: 'Register', icon: 'mdi-help-box', route: '/register' },
            ],
            right: null,
        }
        },
    }
</script>

<style scoped>
    .v-list-item {
        text-decoration: none;
    }
</style>