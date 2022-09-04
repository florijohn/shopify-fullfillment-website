Umrechnungsfaktor: 1000
<input id="calc-byte-converter-1000" v-model="byte-1000" type="number">
<select v-model="selected" id="data_unit">
    <option selected value=""></option>
    <option>KB (Kilobytes)</option>
    <option>MB (Megabytes)</option>
    <option>GB (Gigabytes)</option>
    <option>TB (Terabytes)</option>
</select>


<input type="number" id="data" value="1000" />
    <select id="data_unit" autocomplete="off">
        <option>B (Bytes)</option>
        <option selected>KB (Kilobytes)</option>
        <option>MB (Megabytes)</option>
        <option>GB (Gigabytes)</option>
        <option>TB (Terabytes)</option>
    </select>
    <span>sind</span>
    <span id="result">1</span>
    <select id="result_unit" autocomplete="off">
        <option>B (Byte)</option>
        <option>KB (Kilobytes)</option>
        <option selected>MB (Megabytes)</option>
        <option>GB (Gigabytes)</option>
        <option>TB (Terabytes)</option>
    </select>
    <p><button onclick="convert_1000();">Umrechnen</button></p>

    <h2>Umrechnungsfaktor: 1024</h2>

    <input type="number" id="data_1024" value="1024" />
    <select id="data_unit_1024" autocomplete="off">
        <option>B (Bytes)</option>
        <option selected>KiB (Kilobytes)</option>
        <option>MiB (Megabytes)</option>
        <option>GiB (Gigabytes)</option>
        <option>TiB (Terabytes)</option>
    </select>
    <span>sind</span>
    <span id="result_1024">1</span>
    <select id="result_unit_1024" autocomplete="off">
        <option>B (Byte)</option>
        <option>KiB (Kilobytes)</option>
        <option selected>MiB (Megabytes)</option>
        <option>GiB (Gigabytes)</option>
        <option>TiB (Terabytes)</option>
    </select>
    <p><button onclick="convert_1024();">Umrechnen</button></p>
    

<script>
        function calculate(value, source, target, base)
        {
            var result = 0;
            if (source > target)
                result = value * Math.pow(base, Math.abs(source - target));
            else 
                result = value / Math.pow(base, Math.abs(source - target));

            return result;
        }

        function convert_1000()
        {
            var data = parseInt(document.getElementById("data").value);
            var unit = document.getElementById("data_unit").selectedIndex;
            var result_unit = document.getElementById("result_unit").selectedIndex;

            document.getElementById("result").innerText = calculate(data, unit, result_unit, 1000);
        }

        function convert_1024()
        {
            var data = parseInt(document.getElementById("data_1024").value);
            var unit = document.getElementById("data_unit_1024").selectedIndex;
            var result_unit = document.getElementById("result_unit_1024").selectedIndex;

            document.getElementById("result_1024").innerText = calculate(data, unit, result_unit, 1024);
        }
    </script>
    