$(document).ready(function(){
  $('.cnpj').mask('00.000.000/0000-00', {placeholder: '__.___.___/____-__'});
  $('.cpf').mask('000.000.000-00', {placeholder: '___.___.___-__'});
  
  var TelefoneMask = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 0 0000-0000' : '(00) 0000-00009';
  };

  var rsOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(TelefoneMask.apply({}, arguments), options);
    }
  };
  
  $('.celular').mask(TelefoneMask, rsOptions);
});