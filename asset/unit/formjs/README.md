Advanced form management at JavaScript
===

## How to use

```
<form name="form-name">
  <input type="text"     name="input-name" value=""  />
  <input type="checkbox" name="checkbox"   value="A" data-option="{"":"","a":"A","b":"B"}" />
  <select name="select"></select>
</form>
<script>
//  Get form object.
var form = $OP.Form('form-name');

//  Get input object.
var input = form.Input('input-name');

//  Get input value.
var value = input.Value();

//  Set input value.
input.Value('new value');

//	Event action.
input.Event('change', function(e, input){
  if( input.value ){
    input.Form().Input('checkbox').Value({A:true});
  }else{
    input.Form().Input('checkbox').Value({A:false});
  }
});

//  Generate dynamic select option by input data.
$OP.Form('form-name').Input('checkbox').Event('change', function(e, input){
  var option = input.Data('option');
  input.Form().Input('select').Option(option);
});
</script>
```
