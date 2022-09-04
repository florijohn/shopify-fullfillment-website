<div id="calc-substraction">
    <label for="calc-substraction-factor-1">Minuend</label>
    <input id="calc-substraction-factor-1" v-model="factor1" type="number">
    -
    <label for="calc-substraction-factor-2">Subtrahend</label>
    <input id="calc-substraction-factor-2" v-model="factor2" type="number">
    = {{ product }}
</div>

<script>
new Vue({
    el: "#calc-substraction",
    data: {
        factor1: 1,
        factor2: 1,
    },
    computed: {
        product () {
            return this.factor1 - this.factor2;
        },
    },
});
</script>