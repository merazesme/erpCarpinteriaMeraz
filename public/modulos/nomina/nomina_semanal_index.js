// Desactiva los inputs del modal
$('input').prop('disabled', true).addClass('deshabilitado');
$('#semanas').text(`Semana ${numSemana} del año`);
var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
/* Obtiene el primer y ultimo dia de la semana (objetos) numero 'x' de año
    https://es.stackoverflow.com/questions/7003/c%C3%B3mo-puedo-obtener-el-primer-y-ultimo-d%C3%ADa-de-una-semana-concreta-en-javascript
    https://momentjs.com/docs/#/displaying/as-object/
*/
var f_i = moment().isoWeek(numSemana).startOf("isoweek").toObject();
var f_f = moment().isoWeek(numSemana).endOf("isoweek").toObject();
//console.log( moment().isoWeek(numSemana).startOf("isoweek").format())
var fechai = moment(f_i).toObject();
var fechaf = moment(f_f).toObject();
