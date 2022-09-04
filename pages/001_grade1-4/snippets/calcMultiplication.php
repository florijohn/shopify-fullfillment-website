<div id="calc-multiplication">
    <label for="calc-multiplication-factor-1">Faktor 1</label>
    <input id="calc-multiplication-factor-1" v-model="factor1" type="number">
    x
    <label for="calc-multiplication-factor-2">Faktor 2</label>
    <input id="calc-multiplication-factor-2" v-model="factor2" type="number">
    = {{ product }}
</div>

<script>
new Vue({
    el: "#calc-multiplication",
    data: {
        factor1: 1,
        factor2: 1,
    },
    computed: {
        product () {
            return this.factor1 * this.factor2;
        },
    },
});
</script>
