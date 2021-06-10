<template>
    <div class="container">
        <table border="1">
            <thead>
                <tr>
                    <td rowspan="2">वन उपभाेक्ता समूह</td>
                    <td rowspan="2">आर्थिक वर्ष</td>
                    <td v-for="categoryHeader in printData.categoryHeader" :colspan="categoryHeader.colspan">{{categoryHeader.title}}</td>
                </tr>
                <tr>
                    <td v-for="tempHeader in "></td>
                </tr>
            </thead>
        </table>



    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    data() {
        return {

        };
    },
    computed: {
        ...mapState({
            printData: (state) => state.webservice.printData,
        })

    },
    methods: {


    },
}
</script>

<style scoped>
h5{
    font-size: 15px;
}
h4{
    font-size: 19px;
}
table td{
    padding: 0px 3px 0px 3px;
}

p{
    font-size: 13px;
    margin: 0;
}
table {
    font-size: 13px;
}
</style>
