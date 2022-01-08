 var Pedidolist={};
		
 function demoFromHTML() {


	$.ajax({
		url: "./controller/reporteDetalle.php",
		type: "POST",
		datatype: "json", 
		success: function (data) { 

		 },
	  },
	  JSON
	); 
	 
	//  debugger
	
	// var pdf = new jsPDF('p', 'pt', 'letter');
    // // source can be HTML-formatted string, or a reference
    // // to an actual DOM element from which the text will be scraped.
    // source = $('#customers')[0];

    // // we support special element handlers. Register them with jQuery-style 
    // // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // // There is no support for any other type of selectors 
    // // (class, of compound) at this time.
    // specialElementHandlers = {
    //     // element with id of "bypass" - jQuery style selector
    //     '#bypassme': function (element, renderer) {
    //         // true = "handled elsewhere, bypass text extraction"
    //         return true
    //     }
    // };
    // margins = {
    //     top: 80,
    //     bottom: 60,
    //     left: 40,
    //     width: 522
    // };
    // // all coords and widths are in jsPDF instance's declared units
    // // 'inches' in this case
    // pdf.fromHTML(
    // source, // HTML string or DOM elem ref.
    // margins.left, // x coord
    // margins.top, { // y coord
    //     'width': margins.width, // max width of content on PDF
    //     'elementHandlers': specialElementHandlers
    // },

    // function (dispose) {
    //     // dispose: object with X, Y of the last line add to the PDF 
    //     //          this allow the insertion of new lines after html
    //     pdf.save('Test.pdf');
    // }, margins);
  };

	//Cargar datos al cargar el Modal de modificar
	function showDetalleProducto(idproducto,name){
		$('#reporte').remove();
		$('#modal_reporte').append('<a id="reporte" class="btn btn-sm btn-success" style="cursor:pointer" href="http://dulce.com.pe/taller2/controller/pedidoController.php?function=ReporteProductoDetalle&cliente='+name+'&idproducto='+idproducto+'&reportepdf=true" target="_blank"><span class="glyphicon glyphicon-eye-open"></span>Ver detalle</a>')

		$('#tbListarPedidoDetalle tbody').empty();
		 $.ajax({
			url: "./controller/pedidoController.php",
			type: "POST",
			datatype: "json",
			data: { 
			  function: "ReporteProductoDetalle",
			  idproducto:idproducto, 
			  },
			success: function (data) {  
			  var result = JSON.parse(data); 
			  var i=0;
 				var strHTML=''
				if (result.data.length <= 0) {
					strHTML += '<tr><td colspan="100" class="text-left" style="padding-left: 15%">No hay información para mostrar</td></tr>';
	
				} else {
	
					$.each(result.data, function () { 
						strHTML += '<tr>'+							
 							'<td class="text-center" >' + (this.categoria == null ? "" : this.categoria) + '</td>' +
							'<td class="text-center" >' + (this.producto == null ? "" : this.producto) + '</td>' +
							'<td class="text-center" >' + (this.cantidad == null ? "" : this.cantidad) + '</td>' +
							'<td class="text-center" >' + (this.cantidad == null ? "" : this.descripcion) + '</td>' +
							'<td class="text-center" >' + (this.precioU == null ? "" : this.precioU) + '</td>' +
							'<td class="text-center" >' + (this.total == null ? "" : this.total) + '</td>' +  
							'</tr>';
	
					});
	
				}
				$('#tbListarPedidoDetalle').append(strHTML);

			 },
		  },
		  JSON
		); 
	}
	
	
	function preEliminar(code){
		$('#id_eliminar_temp').val(code);
	}
	
	function eliminarRegistro(){
		code=$('#id_eliminar_temp').val();
		$.ajax({
            url: './controller/c_mantSubdominios.php',
            type: 'POST',
			datatype: 'json',
            data: 'cond=4'+'&code='+code,
            success: function(data) {
				if(data==1){
					$('#menu_subdominio').click();
				}
				else if(data==0)
				alert("Error al Registrar");
			}
        });
		
	}
	
	/*function enviar_email(code){
		alert("Se enviara un Email");
	}*/
	
	
	$(function(){   
       $("#file").on("change", function(){
           /* Limpiar vista previa */
           $("#vista-previa").html('');
           //var archivos = document.getElementById('file').files;
		   var archivos =  $("#file").prop("files");
		   //var archivos = $('#file').files;
           var navegador = window.URL || window.webkitURL;
		   
           /* Recorrer los archivos */
        for(x=0; x<archivos.length; x++)
        {
            /* Validar tamaño y tipo de archivo */
            var size = archivos[x].size;
            var type = archivos[x].type;
            var name = archivos[x].name;
            if (size > 1024*1024)
            {
                $("#vista-previa").append("<p style='color: red'>El archivo "+name+" supera el máximo permitido 1MB</p>");
            }
            //else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif')
			else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' )
            {
                $("#vista-previa").append("<p style='color: red'>El archivo "+name+" no es del tipo de imagen permitida.</p>");
            }
            else
            {
              //var objeto_url = navegador.createObjectURL(archivos[x]);
			 var objeto_url = navegador.createObjectURL(archivos[x]);
              $("#vista-previa").append("<img src="+objeto_url+" width='150' height='150'>");
            }
        }
    });
       
		$("#btn").on("click", function(){
			var formData = new FormData($("#formSubdominio")[0]);
			var ruta = "./controller/upload_imagen.php";
			$.ajax({
				url: ruta,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos)
				{
					var element = datos.split('*');
					if(element[0]=='0'){
						$("#respuesta").html(element[1]);
					}else if(element[0]=='1'){
						$("#respuesta").html(element[2]);
						$("#imagen").val(element[1]);
					}else{
						alert("No es vaido")
					}
					//$("#respuesta").html(datos);
					//alert(element[1]);
				}
			});
        });
       
    });
	
	

	$(document).ready(function(){
		
 		$.ajaxSetup({
		'beforeSend' : function(xhr) {
			xhr.overrideMimeType('text/html; charset=ISO-8859-1');
		},
		});
		
		$('#fechainicio').datepicker({
			format: "yyyy-mm-dd",
			todayHighlight: true,
			autoclose: true
		});
		
		
		 $("#fechafin").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true
		});
		
		generar_tabla();
		
	
		//formulario insertar Registro
		$('#formSubdominio').formValidation({
			message: 'El valor no es valido',
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				ruc: {
					message: 'El campo es invalido',
					validators: {
						notEmpty: {
							message: 'El RUC es obligatorio'
						},
						regexp: {
							regexp: /^[0-9_\. ]+$/, ///^[a-zA-Z0-9_\. ]+$/
							message: 'El campo no puede tener simbolos'
						}
					}
				}
			}
		}).on('success.form.fv', function(e) {
				// Prevent form submission
				e.preventDefault();

				var $form = $(e.target),
				fv    = $form.data('formValidation');
				
				var formData = new FormData($("#formSubdominio")[0]);
				var ruta = "./controller/upload_imagen.php";
				
				/*if($('#cond').val()=='3'){
					$.ajax({
						url: ruta,
						type: "POST",
						data: formData,
						contentType: false,
						processData: false,
						success: function(datos)
						{
							//$("#respuesta").html(datos);
							//alert(datos);
						}
					});
				}*/
			
				// Use Ajax to submit form data
				$.ajax({
					url: $form.attr('action'),
					type: 'POST',
					data: $form.serialize(),
					success: function(data) {
						if(data==1){
						//alert("Se Actualizo Correctamente");
						//generar_tabla()
						//$('.close').click();
						$('#menu_subdominio').click();
						}
						else if(data==0)
						alert("Error al Registrar");
					
					}
				});
			});
		
		
		
	});

	
	function generar_tabla(){
		var fechainicio=$('#fechainicio').val();
		var fechafin=$('#fechafin').val();
		
		$('#tabla_guia').dataTable().fnDestroy();
		$("#tabla_guia").dataTable({	  
		ajax: {
			//url: "./controller/list_mantBancos.php?diasx="+diasx+"&diasy="+diasy+"&tipo="+tipo,
			url: "./controller/pedidoController.php",
			type: "GET",
			datatype: "json",
			data: { 
                function: "ReportePedido",
 				fechainicio:fechainicio,
				fechafin: fechafin 
                },
				complete:function(xhr){
					Pedidolist=xhr.responseJSON;
				}
			 //data: 'diasx='+diasx+'&diasy='+diasy,
		},
		
		searching: true,
		lengthChange: true,
		//pageLength: 20,  
		//autoFill: true
		//columnDefs: [ { searchable: false, targets: 0 } ]
		//paging: false,
		});
	}
	
	function generar_tabla2(){
		fechainicio=$('#fechainicio').val();
		fechafin=$('#fechafin').val();
		$('#tabla_guia').dataTable().fnDestroy();
		$("#tabla_guia").dataTable({	  
		ajax: {
			//url: "./controller/list_mantBancos.php?diasx="+diasx+"&diasy="+diasy+"&tipo="+tipo,
			url: "./controller/list_subdominios.php",
			type: "GET",
			datatype: "json",
			 //data: 'diasx='+diasx+'&diasy='+diasy,
		},
		
		searching: true,
		lengthChange: true,
		//pageLength: 20,  
		//autoFill: true
		//columnDefs: [ { searchable: false, targets: 0 } ]
		//paging: false,
		});
	}
	
	
	function exportar1(){
		/*var diasx=$.trim($('#fec_inicio_buscar').val()); 
		var diasy=$.trim($('#fec_fin_buscar').val()); 
		
		if(diasx=='Desde' || diasy=='Hasta'){
		//$("#mensaje").html("Seleccionar una fecha.<br>");
		return;
		}
		
		window.open("tesoreria/cartaFianzaExcel.php?diasx="+diasx+"&diasy="+diasy); */
		fechainicio=$('#fechainicio').val();
		fechafin=$('#fechafin').val();
		
		window.open("./controller/exportar_excel.php?diasx="+fechainicio+"&diasy="+fechafin);
		
	}

	function exportar2(){
		fechainicio=$('#fechainicio').val();
		fechafin=$('#fechafin').val();
		
		window.open("./controller/exportar_excel2.php?diasx="+fechainicio+"&diasy="+fechafin);
	}
	
	function exportar3(){
		fechainicio=$('#fechainicio').val();
		fechafin=$('#fechafin').val();
		
		window.open("./controller/exportar_excel3.php?diasx="+fechainicio+"&diasy="+fechafin);
	}
	