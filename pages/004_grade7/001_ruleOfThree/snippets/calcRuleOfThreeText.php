<div id="calc-rule-of-three-text">
Ihr steht im Supermarkt an der Käsetheke und wollt 3 kg Gouda kaufen.
<input id="calc-rule-of-three-factor-2" v-model="factor2" type="number"> Kilogramm Gouda kosten <input id="calc-rule-of-three-factor-1" v-model="factor1" type="number"> Euro. Wieviel kosten <input id="calc-rule-of-three-factor-2" v-model="factor3" type="number"> Kilogramm?

    <br>
    Ergebnis: {{ product }} €
</div>

<script>
new Vue({
    el: "#calc-rule-of-three-text",
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