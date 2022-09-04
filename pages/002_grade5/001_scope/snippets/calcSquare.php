<div id="calc-percentages">
    <select v-model="selected">
        <option disabled value="">Form auswählen</option>
        <option>Quadrat</option>
        <option>Rechteck</option>
    </select>
    <span>Ergebnis: {{ selected_calc(selected) }}</span>
    <br><br>
    <label for="calc-scope-sidea">Side A</label>
    <input id="calc-scope-sidea" v-model="sidea" type="number">
    <br>
    <label for="calc-scope-sideb">Side B</label>
    <input id="calc-scope-sideb" v-model="sideb" type="number">
    <br>
    <br>
    <span>{{ no_values(selected) }}</span>
</div>

<script>
new Vue({
    el: "#calc-percentages",
    data: {
        sidea: 0,
        sideb: 0,
        selected: '',
    },
    methods: {
        no_values (selected) {
            switch (selected) {
                case "Rechteck":
                    return "Hinweis: Bitte Side A und Side B ausfüllen!";
                case "Quadrat":
                    return "Hinweis: Bitte nur Side A ausfüllen!";
            }
        },
        selected_calc (selected) {
            switch (selected) {
                case "Rechteck":
                    return this.sidea * 2 + this.sideb * 2;
                case "Quadrat":
                    return this.sidea * 4;
            }
        },
    },
});
</script>