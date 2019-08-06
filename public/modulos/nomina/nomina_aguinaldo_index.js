function imprime() {
  $('#aguinaldos').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'copyHtml5',
          title: `Carpintería Meraz | Nómina aguinaldo | ${anio}`,
          footer: true
      },
      {
          extend: 'excelHtml5',
          title: `Carpintería Meraz | Nómina aguinaldo | ${anio}`,
          filename: `Nomina-aguinaldo-excel-${anio}`,
          footer: true
      },
      {
          extend: 'pdfHtml5',
          text: 'PDF',
          title: `Carpintería Meraz | Nómina aguinaldo | ${anio}`,
          filename: `Nomina-aguinaldo-${anio}`,
          footer: true
      }]
  });
}
