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
      return this.b * this.f - this.c * this.e;  
    },
    result2 () {
      return this.c * this.d - this.a * this.f;  
    },
    result3 () {
      return this.a * this.e - this.b * this.d;  
    }, 
  },
});
