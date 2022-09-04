var app = new Vue({ 
  el: "#calc-cross-product",
  data: {
      a: 0,
      b: 0,
      c: 0,
      d: 0,
      e: 0,
      f: 0,
      selected: '',
  },
  methods: {
      no_values () {
          if ( +this.a == 0 || +this.b == 0 || +this.c == 0 || +this.d == 0 || +this.e == 0 || +this.f == 0) {
              return "Hinweis: Bitte alle Felder ausfüllen!";
      }
      },
  },
  computed: {
    result1 () {
      return (1 / (Math.sqrt(this.a * this.a + this.b * this.b + this.c * this.c))) * this.a;
    },
    result2 () {
      return (1 / (Math.sqrt(this.a * this.a + this.b * this.b + this.c * this.c))) * this.b;  
    },
    result3 () {
      return (1 / (Math.sqrt(this.a * this.a + this.b * this.b + this.c * this.c))) * this.c;  
    }, 
  },
});
