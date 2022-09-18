<style>
  html {
    zoom: 100%;
  }
</style>



<div class="card-header mb-3">

  <table class="table" id="data-table">
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
         Venta Total:  <h3 id="id_total"></h3>
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
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar o ingresar fecha a consultar</td>
      </tr>
    </tbody>
  </table>
</div>

</div>

<script type="text/javascript">
  $(function() {
    moment.locale('es');


    $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
      }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

      $('#data-table tbody').empty();
      var i = 0;
      var strHTML = "";
      var id_total = 0;
      $.ajax({
          url: "./controller/ReportesController.php",
          type: "POST",
          datatype: "json",
          data: {
            function: "ReporteDiario",
            inicio: picker.startDate.format('YYYY-MM-DD'),
            fin: picker.endDate.format('YYYY-MM-DD')
          },
          success: function(data) {
            debugger;
            var result = JSON.parse(data);
            if (result.length <= 0) {
              strHTML += '<tr><td colspan="10" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';
            } else {
              $.each(result, function() {

                var dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
                var numeroDia = new Date(this.fecha).getDay() + 1;
                var nombreDia = dias[numeroDia];
                var total = parseInt(this.YAPE) + parseInt(this.VISA) + parseInt(this.EFECTIVO) + parseInt(this.PLIN);
                id_total+=total;
                i++;
                strHTML += '<tr onclick="seleccionaFila($(this))" data-idpersona="' + this.idpersona + '">' +
                  '<td class="text-center" >' + i + '</td>' +
                  '<td class="text-center" >' + (this.fecha == null ? "" : this.fecha) + '</td>' +
                  '<td class="text-center" >' + (nombreDia == null ? "" : nombreDia) + '</td>' +
                  '<td class="text-center" >' + (this.YAPE == null ? "" : this.YAPE) + '</td>' +
                  '<td class="text-center" >' + (this.VISA == null ? "" : this.VISA) + '</td>' +
                  '<td class="text-center" >' + (this.EFECTIVO == null ? "" : this.EFECTIVO) + '</td>' +
                  '<td class="text-center" >' + (this.PLIN == null ? "" : this.PLIN) + '</td>' +
                  '<td class="text-center" >' + (total == null ? "" : total) + '</td>' +

                  '</tr>';
              });
            }
            $('#data-table tbody').append(strHTML);
            $('#id_total').text(id_total);            
          },
        },
        JSON
      );

    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
    });

  });
</script>