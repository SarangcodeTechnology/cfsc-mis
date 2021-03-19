<template>
    <v-app>
        <v-container class="login-page-bg" fill-height fluid>
            <v-row justify="center">
                <v-col cols="4">
                    <v-card class="pa-3" elevation="10">
                        <v-container>
                            <v-row justify="center">
                                <v-col cols="3">
                                    <v-img contain height="100%" width="100%" src="/images/nepal_emblem.png"></v-img>
                                </v-col>
                                <v-col cols="9">
                                    <h5>नेपाल सरकार</h5>
                                    <h5>वन तथा बातावरण मन्त्रालय</h5>
                                    <h4><strong>सामुदायिक वन अध्ययन केन्द्र </strong></h4>
                                    <h3>व्यवस्थापन सूचना प्रणाली (MIS)</h3>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col align="center">
                                    <v-divider></v-divider>
                                    <p>सामुदायिक वन अध्ययन केन्द्र वव्यवस्थापन सूचना प्रणालीमा तपाइलाइ स्वागत छ । सूरू
                                        गर्नको लागी आफ्नाे खातामा साईन ईन गर्नुहोस् ।</p>
                                    <v-divider></v-divider>
                                    <v-form>
                                        <v-text-field
                                            v-model="user.email"
                                            append-icon="fas fa-user"
                                            autocomplete="on"
                                            label="यूजरनेम"
                                            outlined
                                            placeholder="यूजरनेम हाल्नुहा्ेस्"
                                            v-on:keyup.enter="login"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="user.password"
                                            append-icon="fas fa-key"
                                            autocomplete="on"
                                            label="पासवर्ड"
                                            outlined
                                            placeholder="पासवर्ड हाल्नुहा्ेस्"
                                            type="password"
                                            v-on:keyup.enter="login"
                                        ></v-text-field>
                                        <v-divider></v-divider>
                                        <v-btn block class="ma-2" color="#2E7D32" dark depressed tile x-large
                                               @click="login">
                                            साईन ईन
                                        </v-btn>
                                    </v-form>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-col>
            </v-row>
            <!--        <v-row align="center" justify="center">-->
            <!--            <v-col class="d-flex justify-content-center align-items-center" cols="4">-->
            <!--                <v-container>-->
            <!--                    <v-container>-->
            <!--                        <v-row align="center" justify="center">-->
            <!--                            <v-col cols="3">-->
            <!--                                <v-img src="/images/nepal_emblem.png"></v-img>-->
            <!--                            </v-col>-->
            <!--                            <v-col cols="9">-->
            <!--                                <h5>नेपाल सरकार</h5>-->
            <!--                                <h5>वन तथा बातावरण मन्त्रालय</h5>-->
            <!--                                <h4><strong>सामुदायिक वन अध्ययन केन्द्र </strong></h4>-->
            <!--                            </v-col>-->
            <!--                        </v-row>-->
            <!--                        <v-divider></v-divider>-->
            <!--                        <v-row align="center" justify="center">-->
            <!--                            <h2><strong>सामुदायिक वन अध्ययन केन्द्र वव्यवस्थापन सूचना प्रणाली</strong></h2>-->
            <!--                        </v-row>-->
            <!--                    </v-container>-->
            <!--                    <v-container>-->
            <!--                        <p>सामुदायिक वन अध्ययन केन्द्र वव्यवस्थापन सूचना प्रणालीमा तपाइलाइ स्वागत छ । सूरू-->
            <!--                            गर्नको लागी आफ्नाे खातामा साईन ईन गर्नुहोस् ।</p>-->
            <!--                    </v-container>-->
            <!--                    <v-divider/>-->
            <!--                    <v-container>-->
            <!--                        <v-form>-->
            <!--                            <v-text-field-->
            <!--                                v-model="user.email"-->
            <!--                                append-icon="fas fa-user"-->
            <!--                                color="#2E7D32"-->
            <!--                                label="यूजरनेम"-->
            <!--                                outlined-->
            <!--                                placeholder="यूजरनेम हाल्नुहा्ेस्"-->
            <!--                                v-on:keyup.enter="login"-->
            <!--                            ></v-text-field>-->
            <!--                            <v-text-field-->
            <!--                                v-model="user.password"-->
            <!--                                append-icon="fas fa-key"-->
            <!--                                autocomplete="on"-->
            <!--                                color="#2E7D32"-->
            <!--                                label="पासवर्ड"-->
            <!--                                outlined-->
            <!--                                placeholder="पासवर्ड हाल्नुहा्ेस्"-->
            <!--                                type="password"-->
            <!--                                v-on:keyup.enter="login"-->
            <!--                            ></v-text-field>-->
            <!--                        </v-form>-->
            <!--                        <v-divider></v-divider>-->
            <!--                        &lt;!&ndash;                            <v-checkbox v-model="rememberLogin" color="#2E7D32" hide-details&ndash;&gt;-->
            <!--                        &lt;!&ndash;                                        label="खाता विवरण सम्झनुहाेस्" v-on:change="setRememberLogin"></v-checkbox>&ndash;&gt;-->
            <!--                        <v-row align="center" class="d-flex justify-content-center">-->
            <!--                            <v-col cols="6">-->
            <!--                                <v-btn block class="ma-2" color="#2E7D32" dark depressed tile x-large-->
            <!--                                       @click="login">-->
            <!--                                    साईन ईन-->
            <!--                                </v-btn>-->
            <!--                            </v-col>-->
            <!--                            &lt;!&ndash;                                <v-col class="text-right">&ndash;&gt;-->
            <!--                            &lt;!&ndash;                                    <span @click="forgotPassword">पासवर्ड विर्सनुभयाे? </span>&ndash;&gt;-->
            <!--                            &lt;!&ndash;                                </v-col>&ndash;&gt;-->
            <!--                        </v-row>-->
            <!--                    </v-container>-->
            <!--                </v-container>-->
            <!--            </v-col>-->
            <!--        </v-row>-->
        </v-container>
    </v-app>

</template>

<script>
export default {
    data() {
        return {
            user: {
                email: "",
                password: "",
            },
            rememberLogin: false,
        };
    },
    methods: {
        setRememberLogin() {
            var mypointer = this;
            mypointer.$store.commit("setRememberLogin", mypointer.rememberLogin);
        },
        login() {
            var mypointer = this;
            this.$store
                .dispatch("login", mypointer.user)
                .then(function (response) {
                    if (response.data.status == 200) {
                        mypointer.$tabs.reset();
                        mypointer.$router.push("/home").catch(() => {
                        });
                        mypointer.$store.dispatch("addNotification", {
                            type: response.data.type,
                            message: response.data.message,
                        });
                    } else {
                        mypointer.$store.dispatch("addNotification", {
                            type: response.data.type,
                            message: "Error! Code: " +
                                response.data.status +
                                " Message: " +
                                response.data.message,
                        });
                    }
                })
                .catch(function (error) {
                    mypointer.$store.dispatch("addNotification", {
                        type: "error",
                        message: error,
                    });
                });
        },
        forgotPassword() {
        },
    },
};
</script>

<style scoped>

</style>
