Advanced form management at JavaScript
===

## How to use

```
<div>
  <input type="text"     name="input-name" value=""  />
  <input type="checkbox" name="checkbox"   value="A" data-option="{"":"","a":"A","b":"B"}" />
  <select name="select"></select>
</div>
<script>
//	Get input object.
var input = $OP.Form('form-name').Input('input-name');

//	Get input value.
var value = $input.Value();

//	Set input value.
input.Value('new value');

//	Event action.
input.Event('change', function(e, input){
    if( input.value ){
        input.Form().Input('checkbox').Value({A:true});
    }else{
        input.Form().Input('checkbox').Value({A:false});
    }
});

//	Generate dynamic select option by input data.
$OP.Form('form-name').Input('checkbox').Event('change', function(e, input){
    var option = input.Data('option');
    input.Form().Input('select').Option(option);
});
</script>
```
