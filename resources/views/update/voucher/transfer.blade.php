@extends('layouts.app')

@section('htmlheader_title', "Editar Voucher Traspaso")

@section('main-content')

<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Editar Voucher - Traspaso <small class="hidden-print">Editar un voucher de traspaso monetario entre cuentas bancarias de la empresa.</small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Editar Voucher</li>
                <li><a class="link-effect" href="">Traspaso</a></li>
            </ol>
        </div>
    </div>
</div>

<div class="content content-narrow">
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <!-- Form -->
                <form class="form-horizontal" id="formulario" action="{{ url('/update/voucher/transfer') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="voucher_id" value="{{ $voucher->id }}">
                    <input type="hidden" name="lines" value="{{ $lines }}">
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <label class="css-input switch switch-sm switch-default">
                                    <input type="checkbox" id="auto_correl" name="auto_correl" checked="" disabled=""><span></span> Correlativo Automático
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="form-control" type="number" id="correl" name="correl" placeholder="Ingrese correlativo" disabled="" required="">
                                    <label for="correl">Correlativo</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <div class="form-material">
                                    <input class="js-datepicker form-control" type="text" id="date" name="date" data-date-format="dd-mm-yyyy" placeholder="Ingrese fecha, formato dd-mm-aaaa" required="">
                                    <label for="date">Fecha</label>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="description" name="description" placeholder="Ingrese glosa de voucher" required="" value="{{ $voucher->description }}">
                                    <label for="description">Glosa</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-content border-t">
                        <div class="form-group">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Cuenta contable</th>
                                        <th>Detalle</th>
                                        <th>Tipo Doc.</th>
                                        <th>Nº Doc.</th>
                                        <th>Fecha</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 1; $i <= $lines; $i++)
                                    <tr>
                                        <td>
                                            <div class="form-material">
                                                <select class="form-control" id="account{{ $i }}" name="account{{ $i }}" style="width: 100%" placeholder="Cuenta contable">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="detalle{{ $i }}" name="detalle{{ $i }}" placeholder="Detalle" value="{{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->detail) ? $voucher->voucherdetails[$i - 1]->detail : '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <select class="form-control" id="doctype_id{{ $i }}" name="doctype_id{{ $i }}" style="width: 100%" placeholder="Tipo Doc.">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="doc_number{{ $i }}" name="doc_number{{ $i }}" placeholder="Nº Doc." value="{{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->doc_number) ? $voucher->voucherdetails[$i - 1]->doc_number : '' }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material">
                                                <input class="js-datepicker form-control" type="text" id="fecha{{ $i }}" name="fecha{{ $i }}" data-date-format="dd-mm-yyyy" placeholder="Fecha" required="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" onClick="this.select();" id="debe{{ $i }}" name="debe{{ $i }}" placeholder="..." value="{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->debit : 0 }}" min="0">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" onClick="this.select();" id="haber{{ $i }}" name="haber{{ $i }}" placeholder="..." value="{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->credit : 0 }}" min="0">
                                            </div>
                                        </td>
                                    </tr>
                                    @endfor

                                    <tr>
                                        <td colspan="5" class="text-right">
                                            Totales
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" id="totaldebe" name="totaldebe"  placeholder="..." value="0" disabled="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-material input-group">
                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                <input class="form-control" type="number" id="totalhaber" name="totalhaber"  placeholder="..." value="0" disabled="">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="block-content border-t">
                        <div class="form-group">
                            <label class="col-xs-12" for="voucher-img1">Adjuntar imagen (opcional)</label>
                            <div class="col-xs-12">
                                <input type="file" id="img" name="img" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="block-content block-content-mini block-content-full border-t">
                        <div class="row">
                            <div class="col-xs-12 text-right">
                                <button class="btn btn-default" id="sendButton" type="submit"><i class="fa fa-check-circle-o"></i> Guardar cambios</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END Form -->
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/js/plugins/select2/select2-bootstrap.min.css') }}">

<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
var $lines = {{ $lines }};
var $correlnumber = {{ $voucher->sequence }};

var $accounts = [ @foreach ($accounts as $account) { id: {{ $account->id }}, text: '{{ $account->codigo }} - {{ $account->nombre }}' }, @endforeach ];

var $doctypes = [ @foreach (\App\Doctype::all() as $doctype) { id: {{ $doctype->id }}, text: '{{ $doctype->code }}', title: '{{ $doctype->description }}' }, @endforeach ];

@for ($i = 0; $i <= $lines; $i++) {
    $("#account{{ $i }}").on('change', function() {
        var $value = $(this).find("option:selected").attr("value");
        if($value){
            $("#fecha{{ $i }}").prop("required", true);
            $("#detalle{{ $i }}").prop("required", true);
        }else{
            $("#fecha{{ $i }}").prop("required", false);
            $("#detalle{{ $i }}").prop("required", false);
        }
    });
    
    $("#account{{ $i }}").select2({
        data: $accounts,
        placeholder: "Seleccione...",
        selectOnClose: true,
        allowClear: true,
    }).val({{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->account->id : 0 }}).trigger('change');

    $("#doctype_id{{ $i }}").select2({
        data: $doctypes,
        placeholder: "Tipo Doc.",
        allowClear: true,
        selectOnClose: true,
        templateResult: formatOption
    }).val({{ isset($voucher->voucherdetails[$i - 1]) && isset($voucher->voucherdetails[$i - 1]->doctype) ? $voucher->voucherdetails[$i - 1]->doctype->id : 0 }}).trigger('change');
    
    $("#fecha{{ $i }}").datepicker({language: 'es', todayHighlight: true, autoclose: true}).datepicker("setDate", "{{ isset($voucher->voucherdetails[$i - 1]) ? $voucher->voucherdetails[$i - 1]->date->format('d-m-Y') : 'today' }}");
    
    $('#debe{{ $i }}').on('focusout', function() { 
        if($('#debe{{ $i }}').val() == '')
            $('#debe{{ $i }}').val(0);
        $('#totaldebe').val( parseInt($('#debe1').val()) + parseInt($('#debe2').val()) + parseInt($('#debe3').val()) + parseInt($('#debe4').val()) + parseInt($('#debe5').val()) + parseInt($('#debe6').val()) + parseInt($('#debe7').val()) + parseInt($('#debe8').val()) + parseInt($('#debe9').val()) + parseInt($('#debe10').val()) );
    });

    $('#haber{{ $i }}').on('focusout', function() { 
        $('#totalhaber').val( parseInt($('#haber1').val()) + parseInt($('#haber2').val()) + parseInt($('#haber3').val()) + parseInt($('#haber4').val()) + parseInt($('#haber5').val()) + parseInt($('#haber6').val()) + parseInt($('#haber7').val()) + parseInt($('#haber8').val()) + parseInt($('#haber9').val()) + parseInt($('#haber10').val()) );
    });
}
@endfor

$("#date").datepicker({language: 'es', todayHighlight: true, autoclose: true}).datepicker("setDate", "{{ $voucher->date->format('d/m/Y') }}");

$('#auto_correl').on('change', function() { 
        $("#correl").prop("disabled", $('#auto_correl').prop("checked"));
        updateCorrel();
    });

$( document ).ready(function() {
    updateCorrel();
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
        event.preventDefault();
        return false;
        }
    });
    $('#totaldebe').val( parseInt($('#debe1').val()) + parseInt($('#debe2').val()) + parseInt($('#debe3').val()) + parseInt($('#debe4').val()) + parseInt($('#debe5').val()) + parseInt($('#debe6').val()) + parseInt($('#debe7').val()) + parseInt($('#debe8').val()) + parseInt($('#debe9').val()) + parseInt($('#debe10').val()) );
    $('#totalhaber').val( parseInt($('#haber1').val()) + parseInt($('#haber2').val()) + parseInt($('#haber3').val()) + parseInt($('#haber4').val()) + parseInt($('#haber5').val()) + parseInt($('#haber6').val()) + parseInt($('#haber7').val()) + parseInt($('#haber8').val()) + parseInt($('#haber9').val()) + parseInt($('#haber10').val()) );
});

function updateCorrel() {
    if($("#auto_correl").prop("checked")){
        $("#correl").val($correlnumber);
    }
}

function formatOption (option) {
    var $option = $(
      '<div><strong>' + option.text + '</strong></div><div>' + option.title + '</div>'
    );
    return $option;
};

$("#formulario").submit( function (e) {
    $("#sendButton").prop("disabled", true);
});

$("select").on('select2:unselecting', function(e) {
    $(this).data('unselecting', true);
}).on('select2:open', function(e) { // note the open event is important
    if ($(this).data('unselecting')) {    
        $(this).removeData('unselecting'); // you need to unset this before close
        $(this).select2('close');
    }
});

</script>

@endsection