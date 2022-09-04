<div id="calc-divison">
    <label for="calc-divison-factor-1">Dividend</label>
    <input id="calc-divison-factor-1" v-model="factor1" type="number">
    /
    <label for="calc-divison-factor-2">Divisor</label>
    <input id="calc-divison-factor-2" v-model="factor2" type="number">
    = {{ product }}
</div>

<script>
new Vue({
    el: "#calc-divison",
    data: {
        factor1: 1,
        factor2: 1,
    },
    computed: {
        product () {
            return this.factor1 / this.factor2;
        },
    },
});
</script>