<style>
  html {
    zoom: 100%;
  }

  .font-weight-bold {
    font-weight: bold !important;
    font-size: 15px !important;
  }
</style>



<div class="card-header mb-3">

  <table class="table table-bordered  " id="data-table">
    <div class="card-header pt-7 mb-3">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label fw-bolder text-gray-800">Fecha para Consultar</span>
        <span class="text-gray-400 mt-1 fw-bold fs-6">Visa , Yape , Efectivo</span>
      </h3>
      <div class="row">
        <div class="col-sm-2 ">
          <div class="card-toolbar">
            <input type="text" name="datefilter" value="" class="form-control mt-5" placeholder="Ingresar Fecha">
          </div>
        </div>
        <div class="col-sm-8"></div>
        <div class="col-sm-2 ">
          Venta Total: <h3 id="id_total"></h3>
        </div>
      </div>
    </div>
    <thead>
      <tr class="fw-bolder text-muted bg-light">
        <th class="text-center">#</th>
        <th class="text-center">Fecha</th>
        <th class="text-center">Dia</th>
        <th class="text-center"> <img src="images/yape.png" style="width: 54px;height: 50px;" /></th>
        <th class="text-center"> <img src="images/visa.png" style="width: 81px;height: 30px;" /></th>
        <th class="text-center">Efectivo</th>
        <th class="text-center"> <img src="images/plin.png" style="width: 44px;height: 42px;" /></th>
        <th class="text-center">Total</th>
        <th class="text-center"></th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
      <tr>
        <td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar o ingresar fecha a
          consultar</td>
      </tr>
    </tbody>
  </table>
</div>


<div class="modal fade bd-example-modal-lg" id="ModalReportDiario" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalReportDiarioLabel">Reporte Diario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered  " id="data-table-diario">
          <thead>
            <tr class="fw-bolder text-muted bg-light">
              <th class="text-center">Nª Pedido</th>
              <th class="text-center">Mesa</th>
              <th class="text-center">Cantidad</th>
              <th class="text-center">Hora</th>
              <th class="text-center">Yape</th>
              <th class="text-center">Plin</th>
              <th class="text-center">Efectivo</th>
              <th class="text-center">Visa</th>
              <th class="text-center">Total</th>
              <th class="text-center"></th>

            </tr>
          </thead>
          <tfoot>
          </tfoot>
          <tbody>
            <tr>
              <td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar o ingresar
                fecha a consultar</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="cambiarPrecio() ">Guardar</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">

  function DetalleList(fecha) {
    $('#ModalReportDiario').modal('show');

    $('#data-table-diario tbody').empty();
    var i = 0;
    var strHTML = "";

    $.ajax({
      url: "./controller/ReportesController.php",
      type: "POST",
      datatype: "json",
      data: {
        function: "ReporteDia",
        fecha: fecha,
      },
      success: function (data) {
        var result = JSON.parse(data);
        if (result.length <= 0) {
          strHTML += '<tr><td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';
        } else {

          $.each(result, function () {
            i++;
            strHTML += '<tr>' +
              '<td class="text-center" >' + (this.idpedido = null ? "" : this.idpedido) + '</td>' +
              '<td class="text-center" >' + (this.mesa = null ? "" : this.mesa) + '</td>' +

              '<td class="text-center" >' + (this.total_pedidos == null ? "" : this.total_pedidos) + '</td>' +
              '<td class="text-center" >' + (this.hora == null ? "" : this.hora) + '</td>' +

              '<td class="text-center" >' + (this.yape == null ? "" : this.yape) + '</td>' +
              '<td class="text-center" >' + (this.plin == null ? "" : this.plin) + '</td>' +
              '<td class="text-center" >' + (this.efectivo == null ? "" : this.efectivo) + '</td>' +
              '<td class="text-center" >' + (this.visa == null ? "" : this.visa) + '</td>' +
              '<td class="text-center" >' + (this.total == null ? "" : this.total) + '</td>' +
              '<td><button id="myPopover_'+i+'" type="button" onclick="pedidodetalle(this,'+this.idpedido+')" class="btn btn-lg btn-danger" data-toggle="popover"><i class="far fa-regular fa-eye"></i></button></td>'
            '</tr>';

          });
        }
        $('#data-table-diario tbody').append(strHTML);
      },
    },
      JSON
    );

  }

  function pedidodetalle(html,idpedido) {
    var id ="#"+html.id;
    var platos="";

    $.ajax({
      url: "./controller/pedidoController.php",
      type: "POST",
      datatype: "json",
      data: {
        function: "ReporteProductoDetallePover",
        idpedido:idpedido,
        },
      success: function (data) {
        var result = JSON.parse(data); 
           $.each(result, function () {
            platos+=" "+this.nombre+"----"+this.precioU+"-----\n\n\n";
        });
        $(id).popover({title : platos}); 
        },JSON});



    setTimeout(() => {
      $(id).popover({title : platos});
    $(id).popover();
    }, 2000);

    // position=position -1 ;
    // var strHTML="";
    // $($($($($(html).parent()).parent())).parent()).children().each(function(index,row){
    //   strHTML+='<tr>'+row.innerHTML+'</tr>'
    //   if(index == position){
    //     strHTML+='<tr><td>aqui toy</td></tr>'
    //   }
    // })
    // $('#data-table-diario tbody').empty();

    // $('#data-table-diario tbody').append(strHTML);

    // append('<tr><td>aqui toy</td></tr>')
  }

  $(function () {
    moment.locale('es');
    $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

      $('#data-table tbody').empty();
      $('#data-table tfoot').empty();

      var i = 0;
      var strHTML = "";
      var id_total = 0;
      var strHTML_foot = "";
      $.ajax({
        url: "./controller/ReportesController.php",
        type: "POST",
        datatype: "json",
        data: {
          function: "ReporteDiario",
          inicio: picker.startDate.format('YYYY-MM-DD'),
          fin: picker.endDate.format('YYYY-MM-DD')
        },
        success: function (data) {
          var result = JSON.parse(data);
          if (result.length <= 0) {
            strHTML += '<tr><td colspan="10" class="text-center" style="padding-left: 15%">No hay información para mostrar</td></tr>';
          } else {
            var yape_total = 0;
            var plin_total = 0;
            var visa_total = 0;
            var efectivo_total = 0;
            var TOTAL_TOTAL = 0;

            $.each(result, function () {
              yape_total += parseInt(this.YAPE);
              plin_total += parseInt(this.PLIN);
              visa_total += parseInt(this.VISA);
              efectivo_total += parseInt(this.EFECTIVO);


              var dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
              var numeroDia = new Date(this.fecha).getDay() + 1;
              var nombreDia = dias[numeroDia];
              var total = parseInt(this.YAPE) + parseInt(this.VISA) + parseInt(this.EFECTIVO) + parseInt(this.PLIN);
              id_total += total;
              TOTAL_TOTAL += total;

              i++;
              strHTML += '<tr  data-idpersona="' + this.idpersona + '">' +
                '<td class="text-center" >' + i + '</td>' +
                '<td class="text-center" >' + (this.fecha = null ? "" : this.fecha) + '</td>' +
                '<td class="text-center" >' + (nombreDia === null ? "" : nombreDia) + '</td>' +
                '<td class="text-center" >' + (this.YAPE == null ? "" : this.YAPE) + '</td>' +
                '<td class="text-center" >' + (this.VISA == null ? "" : this.VISA) + '</td>' +
                '<td class="text-center" >' + (this.EFECTIVO == null ? "" : this.EFECTIVO) + '</td>' +
                '<td class="text-center" >' + (this.PLIN == null ? "" : this.PLIN) + '</td>' +
                '<td class="text-center" >' + (total == null ? "" : total) + '</td>' +
                '<td class="" > <button onclick="DetalleList(\'' + this.fecha + '\')" class="btn btn-sm  btn-success" style="margin-top: -8px;padding: 6px;">Ver Detalle </button></td>' +
                '</tr>';
            });
          }
          if (result.length != 0) {
            strHTML_foot = '<tr>' +
              '<td class="text-center" > </td>' +
              '<td class="text-center font-weight-bold" colspan="2">Total  </td>' +
              '<td class="text-center font-weight-bold" >' + yape_total + '</td>' +
              '<td class="text-center font-weight-bold" >' + visa_total + '</td>' +
              '<td class="text-center font-weight-bold " >' + efectivo_total + '</td>' +
              '<td class="text-center font-weight-bold" >' + plin_total + '</td>' +
              '<td class="text-center font-weight-bold" >' + TOTAL_TOTAL + ' </td>' +
              '</tr>';

          }


          $('#data-table tbody').append(strHTML);
          $('#data-table').find('tfoot').append(strHTML_foot);

          $('#id_total').text(id_total);
        },
      },
        JSON
      );

    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
    });

  });
</script>
