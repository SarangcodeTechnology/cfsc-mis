<template>
    <div class="container">
        <table>
            <thead>
                
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
