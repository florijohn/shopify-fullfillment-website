<div id="calc-rule-of-three">
    (
    <label for="calc-rule-of-three-factor-1">Faktor 1</label>
    <input id="calc-rule-of-three-factor-1" v-model="factor1" type="number">
    /
    <label for="calc-rule-of-three-factor-2">Faktor 2</label>
    <input id="calc-rule-of-three-factor-2" v-model="factor2" type="number">
    )
    *
    <label for="calc-rule-of-three-factor-2">Faktor 3</label>
    <input id="calc-rule-of-three-factor-2" v-model="factor3" type="number">
    = {{ product }}
</div>

<script>
new Vue({
    el: "#calc-rule-of-three",
    data: {
        factor1: 25,
        factor2: 5,
        factor3: 3,
    },
    computed: {
        product () {
            return ( +this.factor1 / +this.factor2 ) * +this.factor3;
        },
    },
});
</script>