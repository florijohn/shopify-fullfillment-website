<div id="calc-scalarproduct">
    <table class="vector">
        <tr>
            <td rowspan="3"> u= </td>
            <td rowspan="3"><img src="https://www.mathepower.com/klauf.png"></td>
            <td><input id="calc-scalar-product-a" v-model="a" type="number"></td>
            <td rowspan="3"><img src="https://www.mathepower.com/klzu.png"></td>
            <td rowspan="3"> und v=</td>
            <td rowspan="3"><img src="https://www.mathepower.com/klauf.png"></td>
            <td><input id="calc-scalar-product-d" v-model="d" type="number"></td>
            <td rowspan="3"><img src="https://www.mathepower.com/klzu.png"></td>
        </tr>
        <tr>
            <td><input id="calc-scalar-product-b" v-model="b" type="number"></td>
            <td><input id="calc-scalar-product-e" v-model="e" type="number"></td>
        </tr>
        <tr>
            <td><input id="calc-scalar-product-c" v-model="c" type="number"></td>
            <td><input id="calc-scalar-product-f" v-model="f" type="number"></td>
        </tr>
        <tr>
            
        </tr>
    </table>
    <span>Skalarprodukt: {{ result }}</span>
    <br>
    <br>
    <span>{{ no_values(selected) }}</span>
</div>

<script>
new Vue({
    el: "#calc-scalarproduct",
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
      result () {
        return this.a * this.d + this.b * this.e + this.c * this.f;  
      },  
    },
});
</script>
