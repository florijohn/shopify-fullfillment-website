var app = new Vue({ 
  el: "#calc-percentages",
  data: {
      a: 0,
      b: 0,
      c: 0,
      selected: '',
  },
  methods: {
      no_values () {
          if ( +this.a == 0 || +this.b == 0 || +this.c == 0 ) {
              return "Hinweis: Bitte alle Felder ausfüllen!";
      }
      },
  },
  computed: {
    result () {
      return Math.sqrt(this.a * this.a + this.b * this.b + this.c * this.c);  
    },  
  },
});
