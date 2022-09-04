var app = new Vue({ 
  el: "#calc-cross-product",
  data: {
      height: 0,
      radius: 0,
      area: 0,
      scope: 0,
      mantelhoehe: 0,
      mantelflaeche: 0,
      oberflaeche: 0,
      volumen: 0,
      selected: '',
  },
  computed: {
    height1 () {
      return Math.PI * this.radius * this.radius;  
    },
    radius1 () {
      return Math.sqrt( (Math.PI * this.radius * this.radius) / Math.PI);  
    },
    area1 () {
      return Math.PI * this.radius * this.radius;  
    },
    scope1 () {
      return Math.PI * 2 * this.radius;  
    },
    mantelhoehe1 () {
      return Math.sqrt((+this.height * +this.height) + (+this.radius * +this.radius));  
    },
    mantelflaeche1 () {
      return Math.PI * +this.radius * +this.mantelhoehe;  
    },
    oberflaeche1 () {
      return Math.PI * this.radius * this.radius;  
    },
    volumen1 () {
      return 1 / 3 * +this.area * +this.mantelflaeche;  
    },
  },
});
