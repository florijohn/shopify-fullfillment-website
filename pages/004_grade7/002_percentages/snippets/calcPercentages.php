<div id="calc-percentages">
    <input id="calc-percentages-percent" v-model="percent" type="number">
    <label for="calc-percentages-percent">%</label>
    <label for="calc-percentages-number">Von</label>
    <input id="calc-percentages-number" v-model="number" type="number">
    <br>
    <br>
    {{ no_values() }}
    <br>
    <br>
    Ergebnis: {{ result }}
</div>

<script>
new Vue({
    el: "#calc-percentages",
    data: {
        percent: 0,
        number: 0,
    },
    methods: {
        no_values () {
            if ( +this.percent == 0 || +this.number == 0 ) {
                return "Hinweis: Bitte beide Felder ausfüllen!";
        }
        }, 
    },
    computed: {
        result () {
            return ( +this.percent / 100 ) * +this.number;
        },
    },
});
</script>
