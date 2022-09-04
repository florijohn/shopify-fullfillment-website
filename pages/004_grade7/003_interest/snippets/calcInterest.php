<div id="calc-interest">
    <label for="calc-interest-amount">Kapital</label>
    <input id="calc-interest-amount" v-model="amount" type="number">
    <label for="calc-interest-profit">Profit</label>
    <input id="calc-interest-profit" v-model="profit" type="number">
    <label for="calc-interest-interestRate">Zinssatz in %</label>
    <input id="calc-interest-interestRate" v-model="interestRate" type="number">
    <br>
    Ergebnis: {{ product }} €
</div>

<script>
new Vue({
    el: "#calc-interest",
    data: {
        amount: 10000,
        profit: 0,
        interestRate: 10,
    },
    computed: {
        product () {
            if (1 > 0) {
                return 12;
            } else {
                return 1;
            }
        },
    },
});
</script>
