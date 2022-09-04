<div id="calc-addition">
    <label for="calc-addition-factor-1">A (Summand)</label>
    <input id="calc-addition-factor-1" v-model="factor1" type="number">
    +
    <label for="calc-addition-factor-2">B (Summand)</label>
    <input id="calc-addition-factor-2" v-model="factor2" type="number">
    = {{ product }}
</div>

<script>
new Vue({
    el: "#calc-addition",
    data: {
        factor1: 1,
        factor2: 1,
    },
    computed: {
        product () {
            return +this.factor1 + +this.factor2;
        },
    },
});
</script>
