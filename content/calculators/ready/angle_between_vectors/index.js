var app = new Vue({ 
  el: "#calc-cross-product",
  data: {
      a: 1,
      b: 2,
      c: 3,
      d: 4,
      e: 5,
      f: 6,
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
    result () {
      return ((Math.PI) / 2 ) * Math.cosh(( this.a * this.d + this.b * this.e + this.c * this.f) / ( Math.sqrt(this.a * this.a + this.b * this.b + this.c * this.c)) * (Math.sqrt(this.d * this.d + this.e * this.e + this.f * this.f)));  
    },
  },
});


