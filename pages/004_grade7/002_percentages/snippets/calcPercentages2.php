<div id="calc-percentages2">
    <input id="calc-percentages-firstnumber" v-model="firstnumber">
    <label for="calc-percentages-firstnumber">ist wieviel % von</label>
    <input id="calc-percentages-number2" v-model="number">
    <br>
    <br>
    {{ no_values() }}
    <br>
    <br>
    Ergebnis: {{ result }} %
</div>

<script>
new Vue({
    el: "#calc-percentages2",
    data: {
        firstnumber: 0,
        number: 0,
    },
    methods: {
        no_values () {
            if ( +this.firstnumber == 0 || +this.number == 0 ) {
                return "Hinweis: Bitte beide Felder ausfüllen!";
        }
        }, 
    },
    computed: {
        result () {
            return ( +this.firstnumber / +this.number ) * 100;
        },
    },
});
</script>
