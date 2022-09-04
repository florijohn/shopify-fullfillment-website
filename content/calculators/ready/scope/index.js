var app = new Vue({ 
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
